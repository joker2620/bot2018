<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category Setting
 * @package  Joker2620\Source\Setting
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */

namespace joker2620\Source\Setting;

/**
 * Class ConfgFeatures
 *
 * @category Setting
 * @package  Joker2620\Source\Setting
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class ConfgFeatures
{
    /**
     * Копия класса
     */
    private static $instance;

    /**
     * SustemConfig constructor.
     *
     * @ignore
     */
    private function __construct()
    {
    }

    /**
     * GetConfig
     *
     * @return ConfgFeatures
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
