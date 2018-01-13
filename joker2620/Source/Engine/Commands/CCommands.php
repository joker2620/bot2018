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

use joker2620\Source\Engine\BotFunction;
use joker2620\Source\Engine\Interfaces\CommandIntefce;
use joker2620\Source\Engine\ModuleCommand\CommandList;
use joker2620\Source\Engine\ModuleCommand\CommandsTemplate;

/**
 * Class CCommands
 *
 * @category Commands
 * @package  Joker2620SourceEngineCommands
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
