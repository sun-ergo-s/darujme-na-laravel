<?php

namespace SunErgoS\DarujmeNaLaravel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Client\RequestException;

class DarujmeNaLaravel {

    /**
     * API url pre Darujme.sk
     * 
     * @var string
     */
    const API_URL = 'https://api.darujme.sk';

    /**
     * Užívateľský token pre 'Authorization' hlavičku
     * 
     * 
     */
    private ?string $token = null;

    /**
     * HTTP klient
     * 
     * return Illuminate\Support\Facades\Http
     */
    private $http;

    /**
     * Cesta pre API požiadavku
     * 
     * @var string
     */
    private string $path;

    /**
     * Telo požiadavky 
     * 
     * @var array
     */
    private array $body = [];
    
    /**
     * Zabezpečí užívateľský token a pripraví HTTP klient
     * 
     * @return void
     */
    public function __construct()
    {

        $this->token = session()->get('darujme_sk_user_token');
        
        self::prepareHttpRequest();

        if(!$this->token){
            self::setUserToken();
        }else {
            $this->http->withHeaders(['Authorization' => 'TOKEN ' . $this->token]);
        }

    }
    
    /**
     * Pridá hlavičky do HTTP klienta
     * a opakovanie požiadavky v prípade vypršaného tokena
     *
     * @return void
     */
    private function prepareHttpRequest(): void
    {

        $this->http = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-ApiKey' => Config::get('darujme.key'),
            'X-Organisation' => Config::get('darujme.organization_id')
        ]);

        $this->http->retry(2, 0, function(RequestException $exception) {

            if (!$exception instanceof RequestException || $exception->response->status() !== 401) {
                return false;
            }
         
            self::setUserToken();
         
            return true;

        });

    }
        
    /**
     * Získava token z Darujme.sk
     *
     * @return void
     */
    public function setUserToken(): void
    {

        $this->path = '/v1/tokens';
        $this->body = [
            "username" => Config::get('darujme.username'),
            "password" => Config::get('darujme.password')
        ];
        $this->http->withHeaders(['X-Signature' => self::createSecret()]);
        $this->token = $this->http->post(self::prepareApiUrl(), $this->body)["response"]["token"];

        // Uloží token do relácie
        session()->put('darujme_sk_user_token', $this->token);

        // doplní 'Authorization' hlavičku
        $this->http->withHeaders(['Authorization' => 'TOKEN ' . $this->token]);

        // vráti počiatočnú hodnotu tela kvôli ďalším volaniam, ktoré nedefinujú telo požiadavky
        $this->body = [];

    }
    
    /**
     * Vytvára šifrovací kľúč pre 'X-Signature' hlavičku
     *
     * @return string
     */
    public function createSecret(): string
    {

        $body = count($this->body) ? json_encode($this->body, JSON_FORCE_OBJECT) : "";
        $path = $this->path . "/";
        $payload = "{$body}:{$path}";
        $signature = hash_hmac('sha256', mb_convert_encoding($payload, 'UTF-8'), mb_convert_encoding(Config::get('darujme.secret'), 'UTF-8'));

        return $signature;

    }
    
    /**
     * Vráti zoznam kampaní
     *
     * @return array
     */
    public function listOfCampaigns(): array
    {

        $this->path = "/v1/campaigns";
        $params = [
            "status" => "active"
        ];

        $this->http->replaceHeaders(['X-Signature' => self::createSecret()]);
        $response = $this->http->get(self::prepareApiUrl(), $params);

        return $response->json();

    }
            
    /**
     * Vráti zoznam používateľov pre organizáciu
     *
     * @param  int $limit
     * @param  int $page
     * @param  string $name
     * @param  string $surname
     * @param  string $email
     * @param  string $organisation_id
     * @return array
     */
    public function listOfUsers(int $limit = 10, int $page = 1, string $name = "", string $surname = "", string $email = "", string $organisation_id = null): array
    {

        $this->path = "/v1/users";

        $params = [
            "limit" => $limit,
            "page" => $page,
            "name" => $name,
            "surname" => $surname,
            "email" => $email,
            "organisation_id" => $organisation_id ? $organisation_id : Config::get('darujme.organization_id'),
        ];

        $this->http->replaceHeaders(['X-Signature' => self::createSecret()]);

        return $this->http->get(self::prepareApiUrl(), $params)->json();

    }
    
    /**
     * Vráti detail používateľa na základe :id
     *
     * @param  string $id
     * @return array
     */
    public function userDetail(string $id): array
    {

        $this->path = "/v1/users/{$id}";

        $this->http->replaceHeaders(['X-Signature' => self::createSecret()]);

        return $this->http->get(self::prepareApiUrl())->json();

    }
    
    /**
     * Vráti zoznam platieb
     *
     * @param  array $params
     * @return array
     */
    public function listOfPayments(array $params = []): array
    {

        $this->path = "/v1/payments";

        $this->http->replaceHeaders(['X-Signature' => self::createSecret()]);

        return $this->http->get(self::prepareApiUrl(), $params)->json();

    }
    
    /**
     * Vráti API url spolu s cestou
     *
     * @return string
     */
    private function prepareApiUrl(): string
    {

        return self::API_URL . $this->path . "/";
        
    }

}