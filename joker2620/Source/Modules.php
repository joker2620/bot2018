<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */

namespace joker2620\Source;

use joker2620\Source\Exception\BotError;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;

/**
 * Class Modules
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
abstract class Modules extends VKCallbackApiServerHandler
{
    /**
     * Модули
     */
    private static $modules;

    /**
     * Получение модуля
     *
     * @return object
     */
    protected function getModule()
    {
        return self::$modules;
    }

    /**
     * Функция добавления модуля
     *
     * @param object $class Объект класса
     *
     * @return $this
     * @throws BotError
     */
    protected function addModule($class)
    {
        $no_register = false;
        if (count(self::$modules) > 1) {
            foreach (self::$modules as $module) {
                if ($module instanceof $class) {
                    $no_register = true;
                }
            }
        }
        if (!$no_register) {
            self::$modules [] = $class;
        }
        return $this;
    }
}
