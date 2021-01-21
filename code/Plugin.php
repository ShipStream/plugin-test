<?php

class ShipStream_Test_Plugin extends Plugin_Abstract
{
    /**
     * Fetches your public IP, saves it in the remote storage, fetches it and logs it.
     */
    public function update_ip()
    {
        $serviceUrl = $this->getConfig('service_url');
        if ( ! $serviceUrl) {
            throw new Exception('Service URL not configured.');
        }

        $client = $this->getHttpClient(['base_uri' => $serviceUrl]);
        $response = $client->get('');
        $myIp = $response->getBody()->getContents();

        $this->setState('test', array(
            'my_ip' => $myIp,
            'my_name' => $this->getConfig('whoami'),
            'last_updated' => time(),
        ));

        $data = $this->getState('test');
        $this->log("{$data['my_name']}'s IP is {$data['my_ip']}, last updated at ".date('c', $data['last_updated']).".");
    }

    /**
     * Dummy method to demonstrate ability to setup the cron job via the configuration file.
     */
    public function dummyCronJob()
    {
        $this->setState('dummy cron job last run', time());
    }

    /**
     * Respond to order:created events.
     *
     * @param array $data
     */
    public function respondOrderCreated($data)
    {
        $this->log("Order # {$data['unique_id']} was created.");
    }

    /**
     * Respond to 'testCallback'
     *
     * @param $query
     * @param $headers
     * @param $data
     * @return false|string
     */
    public function myTestCallback($query, $headers, $data)
    {
        return json_encode(['success' => TRUE]);
    }

    /*
     * Webhook Methods
     */

    /**
     * Verify webhook request authenticity.
     *
     * @param array $query
     * @param array $headers
     * @param string $data
     * @return bool
     */
    public function verifyWebhook($query, $headers, $data)
    {
        echo "Got it!\n";
        $this->yieldWebhook();
        return TRUE;
    }

    /**
     * If authenticity was verified, handle the webhook data (does not block response to webhook request).
     *
     * @param array $query
     * @param array $headers
     * @param string $data
     * @return bool
     */
    public function handleWebhook($query, $headers, $data)
    {
        $this->log("Received webhook: (".http_build_query($query)."):\n$data");
        return TRUE;
    }

    /*
     * OAuth Methods
     */

    /**
     * Validate that all necessary config fields are filled out.
     *
     * @throws Exception
     */
    public function oauthValidateConfig()
    {
        if ( ! preg_match('/\w+/', $this->getConfig('whoami'))) {
            throw new Exception('Who Am I must contain only alphanumeric characters or underscores.');
        }
        if ( ! $this->getConfig('oauth_key')) {
            throw new Exception('OAuth API Key is not configured.');
        }
        if ( ! $this->getConfig('oauth_secret')) {
            throw new Exception('OAuth API Secret is not configured.');
        }
    }

    /**
     * Get the URL that the user will visit to setup the OAuth connection
     *
     * @param array $connectParams
     * @return string
     */
    public function oauthGetConnectButton($connectParams = [])
    {
        $apiKey = urlencode($this->getConfig('oauth_api_key'));
        $clientId = urlencode($this->getConfig('whoami'));
        $scopes = urlencode('foo,bar,baz');
        $redirect = urlencode($this->oauthGetRedirectUrl());
        $url = "http://www.example.com/oauth_test.php?action=authorize&api_key=$apiKey&client=$clientId&scopes=$scopes&redirect_uri=$redirect";
        return '<a href="'.$url.'">Connect To OAuth Test</a>';
    }

    /**
     * @param $request
     */
    public function oauthHandleRedirect($request)
    {
        $this->oauthSetTokenData($request['secret']);
    }

    /**
     * @return array Key-value pairs of test results
     * @throws Exception
     */
    public function oauthTest()
    {
        $response = ''; // TODO $this->oauthClient()->request('test'); or similar
        throw new Exception('API not yet working..');
        return [
            'TODO' => 'Return data from live API to prove working operation.'
        ];
    }

}
