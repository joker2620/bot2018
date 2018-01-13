<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Commands
 * @package  Joker2620\Source\Engine\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine\Commands;

use joker2620\Source\API\VKAPI;
use joker2620\Source\Engine\Interfaces\CommandIntefce;
use joker2620\Source\Engine\ModuleCommand\CommandsTemplate;

/**
 * Class CKurs
 *
 * @category Commands
 * @package  Joker2620\Source\Engine\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class CKurs extends CommandsTemplate implements CommandIntefce
{
    /**
     * CKurs constructor.
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
        $filekurs = VKAPI::getInstance()
            ->curl('http://www.cbr.ru/scripts/XML_daily.asp');
        preg_match(
            '/\<Valute ID=\"R01235\".*?\>(.*?)\<\/Valute\>/is',
            $filekurs,
            $array
        );
        preg_match('/<Value>(.*?)<\/Value>/is', $array[1], $rouble);
        preg_match(
            '/\<Valute ID=\"R01239\".*?\>(.*?)\<\/Valute\>/is',
            $filekurs,
            $euros
        );
        preg_match('/<Value>(.*?)<\/Value>/is', $euros[1], $euroc);
        preg_match(
            '/\<Valute ID=\"R01720\".*?\>(.*?)\<\/Valute\>/is',
            $filekurs,
            $ukraines
        );
        preg_match('/<Value>(.*?)<\/Value>/is', $ukraines[1], $ukraine);
        $message = [
            '💰Курс валют💰',
            '💵 Доллар $ - ' . str_replace(',', '.', $rouble[1]) . ' 💵',
            '💶 Евро € - ' . str_replace(',', '.', $euroc[1]) . ' 💶',
            '🔰 Гривна - ' . str_replace(',', '.', $ukraine[1]) . ' 🔰'
        ];
        return implode("\n", $message);
    }
}
