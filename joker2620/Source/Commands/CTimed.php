<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 7.1;
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Commands;

use joker2620\Source\Interfaces\CommandIntefce;
use joker2620\Source\ModuleCommand\CommandsTemplate;

/**
 * Class CTimed
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class CTimed extends CommandsTemplate implements CommandIntefce
{
    /**
     * CTimed constructor.
     */
    public function __construct()
    {
    }

    /**
     * Функция для запуска выполнения комманды
     *
     * @param array $item Данные пользователя.
     *
     * @return mixed
     */
    public function runCom($item)
    {
        $return   = [
            'Время: #what_dey# #what_time#',
            '---------------',
            'Вы: #first_name# #last_name#',
            'Ваш пол: #sex_dis#',
            'Ваш айди: @id#uid#',
            '---------------',
            "Имя бота: #neme_bot#",
            'Автор бота @joker2620 (Назым Бавбеков)',
            'Версия бота: #version# (b#build#)',
        ];
        return implode("\n", $return);
    }
}