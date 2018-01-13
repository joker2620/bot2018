<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Interfaces
 * @package  Joker2620\Source\Engine\Interfaces
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine\Interfaces;

/**
 * Interface ModuleInterface
 *
 * @category Interfaces
 * @package  Joker2620\Source\Engine\Interfaces
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
interface ModuleInterface
{
    /**
     * Получение ответа от модуля
     *
     * @param array $item Данные пользователя.
     *
     * @return mixed
     */
    public function getAnwser($item);
}
