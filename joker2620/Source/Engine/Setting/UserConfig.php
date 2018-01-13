<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Setting
 * @package  Joker2620\Source\Engine\Setting
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */

namespace joker2620\Source\Engine\Setting;

/**
 * Class UserConfig
 *
 * @category Setting
 * @package  Joker2620\Source\Engine\Setting
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class UserConfig
{

    /**
     * Копия класса
     */
    private static $_instance;

    /**
     * UserConfig constructor.
     *
     * @ignore
     */
    private function __construct()
    {

    }

    /**
     * GetConfig()
     *
     * @return UserConfig
     */
    public static function getConfig()
    {
        if (self::$_instance == null) {
            $conf_dir        = dirname(dirname(dirname(__DIR__)));
            self::$_instance = include $conf_dir .
                '/Configuration/UserConfig.php';
        }
        return self::$_instance;
    }
}
