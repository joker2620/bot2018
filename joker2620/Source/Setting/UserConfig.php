<?php
declare(strict_types = 1);


namespace joker2620\Source\Setting;


/**
 * Class UserConfig
 *
 * @package joker2620\Source\Setting
 */
class UserConfig
{


    private static $instance;


    /**
     * UserConfig constructor.
     */
    private function __construct()
    {
    }


    /**
     * getConfig()
     *
     * @return mixed
     */
    public static function getConfig()
    {
        if (self::$instance == null) {
            $conf_dir       = dirname(dirname(__DIR__));
            self::$instance = include $conf_dir .
                '/Configuration/UserConfig.php';
        }
        return self::$instance;
    }
}
