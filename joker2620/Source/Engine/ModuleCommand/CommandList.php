<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category ModuleCommand
 * @package  Joker2620SourceEngineModuleCommand
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */

namespace joker2620\Source\Engine\ModuleCommand;

use joker2620\Source\Engine\Loger;
use joker2620\Source\Exception\BotError;

/**
 * Class CommandList
 *
 * @category ModuleCommand
 * @package  Joker2620SourceEngineModuleCommand
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CommandList
{

    /**
     * Команды
     */
    static $commands;

    /**
     * Список комманд
     * mode 0 - только пользовательские,
     * mode 1 - только админитраторские,
     * mode 2 - все.
     *
     * @param int $mode Режим
     *
     * @return array
     */
    public function getCommandList($mode)
    {

        $command = [];
        foreach (self::$commands as $commands) {
            switch ($commands[2]) {
            case 0:
                    $command[0][] = $commands[3];
                break;
            case 1:
                    $command[1][] = $commands[3];
                break;
            }
        }
        $ucomm = array_merge(["--- Команды бота ---\n"], $command[0]);
        $acomm = array_merge(
            ["\n---- Команды для администрации ---\n"],
            $command[1]
        );
        switch ($mode) {
        case 0:
                $command = $ucomm;
            break;
        case 1:
                $command = $acomm;
            break;
        case 2:
                $command = array_merge($ucomm, $acomm);
            break;
        }
        return $command;
    }

    /**
     * Список команд комманд (загрузчик)
     *
     * В данном списке можно увидеть список комманд бота в формате:
     * 0 => регулярное выражение
     * 1 => название класса комманды (из директории joker2620\Source/Engine/Commands)
     * 2 => права доступа к команде, 0 - всем, 1 - только администрации
     * 3 => то как будет отображаться коммада в списке комманд
     *
     * @return void
     */
    protected function loadCommand()
    {
        if (self::$commands == null) {
            self::$commands = $this->commands();
        }
    }

    /**
     * Commands()
     *
     * @return array
     */
    protected function commands()
    {
        return include_once 'Config.php';
    }

    /**
     * GetCommand()
     *
     * @return mixed
     */
    protected function getCommand()
    {
        return self::$commands;
    }

    /**
     * AddCommand($regexp, $class, $rule, $print)
     *
     * @param string  $regexp Регулярное выражение
     * @param object  $class  Объект класса
     * @param boolean $rule   Привилегии
     * @param string  $print  Отображение в списке команд
     *
     * @return object $this
     * @throws BotError
     */
    protected function addCommand($regexp, $class, $rule, $print)
    {
        if (count(self::$commands) > 1) {
            foreach (self::$commands as $command) {
                if ($command[1] instanceof $class) {
                    Loger::getInstance()->logger(
                        'Попытка добавить существующую команду "' .
                        get_class($class)
                    );
                    continue;
                }
            }
        }
        self::$commands [] = [$regexp, $class, $rule, $print];
        return $this;
    }

}
