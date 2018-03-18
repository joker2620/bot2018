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
 * Class CGetvote
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class CGetvote extends CommandsTemplate implements CommandIntefce
{
    /**
     * CGetvote constructor.
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
        $array = [
            'шикардос', 'кулл',
            'великолепно', 'О боже, как-же это прекрасно, ах какие... Я влюблен!',
            'О боже, как ты вообще такое дерьмо нашел!',
            'Хуже только фото где срут понни',
            'фу бл*ть, как это мерзко', 'дермище'
        ];
        if (isset($item['attachments'])) {
            return $array[array_rand($array)];
        } else {
            return 'Ну "ЗеБеСт" у тебя логика: "оцени то чего нет"...';
        }
    }
}
