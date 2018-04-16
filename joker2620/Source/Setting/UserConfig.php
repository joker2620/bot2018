<?php
declare(strict_types = 1);


namespace joker2620\Source\Setting;

use joker2620\Source\Interfaces\Setting\ConfigGetter;


/**
 * Class UserConfig
 *
 * @package joker2620\Source\Setting
 */
class UserConfig extends ConfigGetter
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
