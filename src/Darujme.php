<?php

namespace SunErgoS\DarujmeNaLaravel;

class Darujme extends BaseDarujme {

    use Concerns\HttpClient;

    /**
     * Vráti zoznam používateľov pre organizáciu
     *
     * @param  array $params
     * @return array
     */
    public function listOfUsers($params = []): array
    {

        $this->path = "/v1/users";
        $this->method = "GET";
        $this->params = $params;

        return $this->processHttpRequest();

    }

    /**
     * Zatiaľ nefunguje - [Podpis nie je platný]
     * 
    */
    /*
    public function deleteUser($path_vars = [], $params = [])
    {

        $this->path = strtr("/v1/users/userId", $path_vars);
        $this->method = "DEL";
        $this->params = $params;

        return $this->processHttpRequest();

    }
    */

    /**
     * Priradiť rolu používateľa ku organizácii
     * 
     * @param array $path_vars
     * @param array $body
     * @return array
     */
    public function addUserToOrganization($path_vars = [], $body = []): array
    {

        $this->path = strtr("/v1/users/userId", $path_vars);
        $this->method = "PUT";
        $this->body = $body;

        return $this->processHttpRequest();

    }

    /**
     * Vráti zoznam kampaní
     * 
     * @param  array $params
     * @return array
     */
    public function listOfCampaigns($params = []): array
    {

        $this->path = "/v1/campaigns";
        $this->method = "GET";
        $this->params = $params;

        $this->addSignatureHeader();

        return $this->processHttpRequest();

    }
    
    /**
     * Vráti detail používateľa na základe :id
     *
     * @param  array $path_vars
     * @return array
     */
    public function userDetail($path_vars = []): array
    {

        $this->path = strtr("/v1/users/id", $path_vars);

        $this->addSignatureHeader();

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

        // body
        // params
        // path_vars

        $this->path = "/v1/payments";

        $this->addSignatureHeader();

        return $this->http->get(self::prepareApiUrl(), $params)->json();

    }

    /* 404  
    public function paymentDetail(array $path_vars, array $params = []): array
    {

        $this->path = strtr("/v1/payments/id", $path_vars);

        $this->http->replaceHeaders(['X-Signature' => self::createSecret()]);

        return $this->http->get(self::prepareApiUrl(), $params)->json();

    }
    */

}