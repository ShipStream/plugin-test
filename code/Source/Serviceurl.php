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
            ['label' => 'whatismyipaddress.com (insecure)', 'value' => 'http://bot.whatismyipaddress.com'],
            ['label' => 'ipify.org (secure)', 'value' => 'https://api.ipify.org'],
        ];
    }

}
