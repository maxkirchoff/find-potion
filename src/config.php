<?php
namespace FindPotion;

use Exception;

class Config
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function get_config()
    {
        // Load the conf str
        $conf_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'config.ini';

        // Check for conf file's existence
        if (! file_exists($conf_file))
        {
            throw new Exception("Configuration cannot be found.");
        }

        // parse the conf file
        return parse_ini_file($conf_file, true);
    }
}