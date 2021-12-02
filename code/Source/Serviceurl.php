<?php

class ShipStream_Test_Source_Serviceurl implements Plugin_Source_Interface
{

    /**
     * Return options for "Service URL"
     *
     * @param Plugin_Abstract $plugin
     * @return array
     */
    public function getOptions(Plugin_Abstract $plugin)
    {
        return [
            ['label' => 'ipinfo.io (insecure)', 'value' => 'http://ipinfo.io/ip'],
            ['label' => 'ipify.org (secure)', 'value' => 'https://api.ipify.org'],
        ];
    }

}
