<?php

class Test_Test_Plugin extends Plugin_Abstract
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
        $myIp = file_get_contents($serviceUrl);

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
     * @param array $data
     */
    public function respondOrderCreated($data)
    {
        $this->log("Order # {$data['unique_id']} was created.");
    }

    /**
     * @param array $query
     * @param array $headers
     * @param string $data
     * @return bool
     */
    public function verifyWebhook($query, $headers, $data)
    {
        echo "Got it!";
        $this->yieldWebhook();
        return TRUE;
    }

    /**
     * @param array $query
     * @param array $headers
     * @param string $data
     * @return bool
     */
    public function handleWebhook($query, $headers, $data)
    {
        $this->log("Received webhook: (".http_build_query($query)."):\n$data");
    }

}
