<?php
declare(strict_types = 1);
/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category Interfaces
 * @package  Joker2620\Source\Interfaces
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Interfaces;

/**
 * Interface ModuleInterface
 *
 * @category Interfaces
 * @package  Joker2620\Source\Interfaces
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
interface ModuleInterface
{
    /**
     * Получение ответа от модуля
     *
     * @return mixed
     *
     */
    public function getAnwser();
}
