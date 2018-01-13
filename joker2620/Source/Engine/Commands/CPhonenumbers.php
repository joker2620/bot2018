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

use joker2620\Source\Engine\Interfaces\CommandIntefce;
use joker2620\Source\Engine\ModuleCommand\CommandsTemplate;
use joker2620\Source\Engine\Setting\ConfgFeatures;
use joker2620\Source\Engine\Setting\ConfigCommands;
use joker2620\Source\Engine\Setting\SustemConfig;

/**
 * Class CPhonenumbers
 *
 * @category Commands
 * @package  Joker2620\Source\Engine\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class CPhonenumbers extends CommandsTemplate implements CommandIntefce
{
    /**
     * CPhonenumbers constructor.
     */
    public function __construct()
    {
    }

    /**
     * Функция для запуска выполнения комманды
     *
     * @param array $item Данные пользователя.
     *                    *
     *
     * @see \ConfigCommands::PHONE_NUMBER База телефонных номеров
     *
     * @return mixed
     */
    public function runCom($item)
    {
        if (ConfgFeatures::getConfig()['ENABLE_SMS']) {
            $return = '';
            $phone  = ConfigCommands::getConfig()['PHONE_NUMBER'];
            ksort($phone);
            foreach ($phone as $itemx => $valuex) {
                $return .= $itemx . ' - ' . $valuex . "\n";
            }
        } else {
            $return = SustemConfig::getConfig()['MESSAGE']['TextCommand'][2];
        }
        return $return;
    }
}
