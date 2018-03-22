<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
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
use joker2620\Source\ModuleCommand\CommandList;
use joker2620\Source\ModuleCommand\CommandsTemplate;
use joker2620\Source\User;

/**
 * Class CCommands
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CCommands extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'команды';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "команды" - этот список.';
    /**
     * Права доступа
     */
    protected $permission = 0;

    /**
     * Функция для запуска выполнения комманды
     *
     * @param $matches
     *
     * @return mixed
     *
     */
    public function runCommand(array $matches)
    {
        $admin        = BotFunction::getInstance()->scanAdm(User::getId());
        $command_list = new CommandList();
        if ($admin == true) {
            $items = $command_list->getCommandList(2);
        } else {
            $items = $command_list->getCommandList(0);
        }
        return implode("\n", $items);
    }
}
