<?php

namespace SunErgoS\DarujmeNaLaravel;

class DarujmeNaLaravel extends BaseDarujme {

    use Concerns\HttpClient;
    
    /**
     * Vráti zoznam kampaní
     * 
     * @param  array $params
     * @return array
     */
    public function listOfCampaigns($params = []): array
    {

        $this->path = "/v1/campaigns";

        $this->http->replaceHeaders(['X-Signature' => self::createSecret()]);

        return $this->http->get(self::prepareApiUrl(), $params)->json();

    }
            
    /**
     * Vráti zoznam používateľov pre organizáciu
     *
     * @param  array $params
     * @return array
     */
    public function listOfUsers($params = []): array
    {

        $this->path = "/v1/users";

        $this->http->replaceHeaders(['X-Signature' => self::createSecret()]);

        return $this->http->get(self::prepareApiUrl(), $params)->json();

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

    /* 404  
    public function paymentDetail(array $path_vars, array $params = []): array
    {

        $this->path = strtr("/v1/payments/id", $path_vars);

        $this->http->replaceHeaders(['X-Signature' => self::createSecret()]);

        return $this->http->get(self::prepareApiUrl(), $params)->json();

    }
    */

}