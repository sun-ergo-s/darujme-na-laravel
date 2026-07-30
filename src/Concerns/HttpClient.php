<?php

namespace SunErgoS\DarujmeNaLaravel\Concerns;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

trait HttpClient {

    /**
     * API url pre Darujme.sk
     * 
     * @var string
     */
    const API_URL = 'https://api.darujme.sk';

    /**
     * Cesta pre API požiadavku
     * 
     * @var string
     */
    protected string $path;

    /**
     * Metóda pre API požiadavku
     * 
     * @var string
     */
    protected string $method;

    /**
     * Telo požiadavky 
     * 
     * @var array
     */
    protected array $body = [];

    /**
     * Parametre požiadavky 
     * 
     * @var array
     */
    protected array $params = [];

    /**
     * HTTP klient
     * 
     * return Illuminate\Support\Facades\Http
     */
    protected $http;

    /**
     * Užívateľský token pre 'Authorization' hlavičku
     * 
     * 
     */
    protected ?string $token = null;

    protected function processHttpRequest()
    {

        $this->addSignatureHeader();

        switch ($this->method) {
            case 'GET':
                return $this->http->get($this->prepareApiUrl(), $this->params)->json();
                break;
            case 'POST':
                return $this->http->post($this->prepareApiUrl(), $this->body)->json();
                break;
            case 'DEL':
                return $this->http->delete($this->prepareApiUrl(), $this->params)->json();
                break;
            case 'PUT':
                return $this->http->put($this->prepareApiUrl(), $this->body)->json();
                break;
            default:
                return [];
                break;
        }

    }

    protected function addSignatureHeader(): void
    {   
        $this->http->replaceHeaders(['X-Signature' => $this->createSecret()]);
    }

    /**
     * Pridá hlavičky do HTTP klienta
     * a opakovanie požiadavky v prípade vypršaného tokena
     *
     * @return void
     */
    protected function prepareHttpRequest(): void
    {

        $this->addHeaders();
        $this->addRetryOption();
        $this->addUserToken();

    }

    protected function addHeaders(): void
    {

        $this->http = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-ApiKey' => config('darujme.key'),
            'X-Organisation' => config('darujme.organization_id')
        ]);

    }

    protected function addRetryOption(): void
    {

        $this->http->retry(2, 0, function(RequestException $exception) {

            if (!$exception instanceof RequestException || $exception->response->status() !== 401) {
                return false;
            }
         
            $this->setUserToken();
         
            return true;

        });

    }

    protected function addUserToken(): void
    {

        $this->token = session()->get('darujme_sk_user_token');

        if(!$this->token){
            $this->setUserToken();
        }else {
            $this->http->withHeaders(['Authorization' => 'TOKEN ' . $this->token]);
        }

    }

    /**
     * Získava token z Darujme.sk
     *
     * @return void
     */
    protected function setUserToken(): void
    {

        $this->path = '/v1/tokens';
        $this->method = "POST";
        $this->body = [
            "username" => config('darujme.username'),
            "password" => config('darujme.password')
        ];
        $this->http->withHeaders(['X-Signature' => $this->createSecret()]);
        $this->token = $this->processHttpRequest()["response"]["token"];

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
    protected function createSecret(): string
    {

        $body = count($this->body) ? json_encode($this->body) : "";
        $path = $this->path . "/";
        $payload = "{$body}:{$path}";
        $signature = hash_hmac('sha256', mb_convert_encoding($payload, 'UTF-8'), mb_convert_encoding(config('darujme.secret'), 'UTF-8'));

        return $signature;

    }

    /**
     * Vráti API url spolu s cestou
     *
     * @return string
     */
    protected function prepareApiUrl(): string
    {

        return self::API_URL . $this->path . "/";
        
    }

}