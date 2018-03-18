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

use joker2620\Source\BotFunction;
use joker2620\Source\Interfaces\CommandIntefce;
use joker2620\Source\ModuleCommand\CommandList;
use joker2620\Source\ModuleCommand\CommandsTemplate;

/**
 * Class CCommands
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class CCommands extends CommandsTemplate implements CommandIntefce
{
    /**
     * CCommands constructor.
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
        $admin        = BotFunction::getInstance()->scanAdm($item['user_id']);
        $command_list = new CommandList();
        if ($admin == true) {
            $items = $command_list->getCommandList(2);
        } else {
            $items = $command_list->getCommandList(0);
        }
        return implode("\n", $items);
    }
}
