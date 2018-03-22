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
 * Class SustemConfig
 *
 * @category Setting
 * @package  Joker2620\Source\Setting
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class SustemConfig
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
     * GetConfig()
     *
     * @return SustemConfig
     */
    public static function getConfig()
    {
        if (self::$instance == null) {
            $conf_dir       = dirname(dirname(__DIR__));
            self::$instance = include $conf_dir .
                '/Configuration/SustemConfig.php';
        }
        return self::$instance;
    }
}
