<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Commands
 * @package  Joker2620SourceEngineCommands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine\Commands;

use joker2620\Source\Engine\Interfaces\CommandIntefce;
use joker2620\Source\Engine\ModuleCommand\CommandsTemplate;
use joker2620\Source\Engine\Setting\SustemConfig;

/**
 * Class CTimed
 *
 * @category Commands
 * @package  Joker2620SourceEngineCommands
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
        $datatime = date('d.m.Y H:i:s');
        $return   = [
            "Время: {$datatime}",
            "Ваш айди: @id{$item['user_id']}",
            "Автор бота @joker2620 (Назым Бавбеков)",
            "Версия бота: " . SustemConfig::getConfig()['VERSION'] . " (b" .
            SustemConfig::getConfig()['BUILD'] . ")."
        ];
        return implode("\n", $return);
    }
}
