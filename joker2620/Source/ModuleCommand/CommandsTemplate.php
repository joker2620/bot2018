<?php
declare(strict_types = 1);
/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category ModuleCommand
 * @package  Joker2620\Source\ModuleCommand
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\ModuleCommand;

use joker2620\Source\API\VKAPI;
use joker2620\Source\Loger\Loger;
use joker2620\Source\User\User;

/**
 * Class CommandsTemplate
 *
 * @category ModuleCommand
 * @package  Joker2620\Source\ModuleCommand
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
abstract class CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp;
    /**
     * Отображение команды в списке
     */
    protected $display;
    /**
     * Права доступа
     */
    protected $permission = 0;

    /**
     * VKAPI
     */
    protected $vkapi;

    /**
     * VKAPI
     */
    protected $user;

    protected $loger;

    /**
     * CommandsTemplate constructor.
     */
    public function __construct()
    {
        $this->loger = new Loger();
        $this->vkapi = new VKAPI();
        $this->user  = new User();
    }

    /**
     * Функция для запуска выполнения комманды
     *
     * @param $matches
     *
     * @return
     */
    abstract public function runCommand(array $matches);

    /**
     * @return string
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @return string
    {
     */
    public function getRegexp()
    {
        return $this->regexp;
    }
}
