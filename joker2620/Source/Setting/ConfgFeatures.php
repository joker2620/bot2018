<?php
declare(strict_types = 1);


namespace joker2620\Source\Setting;


/**
 * Class ConfgFeatures
 *
 * @package joker2620\Source\Setting
 */
class ConfgFeatures
{

    private static $instance;


    /**
     * ConfgFeatures constructor.
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
                '/Configuration/FeaturesConfig.php';
        }
        return self::$instance;
    }
}
