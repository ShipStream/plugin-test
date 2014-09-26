<?php

class Test_Test_Source_Serviceurl implements Plugin_Source_Interface
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
            ['label' => 'bot.whatismyipaddress.com', 'value' => 'http://bot.whatismyipaddress.com'],
        ];
    }

}
