<?php
declare(strict_types = 1);

namespace nazbav\Source\Modules;

use nazbav\Source\API\VKAPI;
use nazbav\Source\Engine\Loger;
use nazbav\Source\User\User;
use nazbav\Source\User\UserData;


/**
 * Class CommandsTemplate
 *
 * @package nazbav\Source\ModuleCommand
 */
abstract class CommandsTemplate
{
    protected $regexp;

    protected $display;

    protected $permission = 0;

    protected $vkapi;

    protected $user;

    protected $loger;

    protected $dataBase;

    /**
     * CommandsTemplate constructor.
     */
    public function __construct()
    {
        $this->loger    = new Loger();
        $this->vkapi    = new VKAPI();
        $this->user     = new User();
        $this->dataBase = new UserData();
        $this->dataBase->write('lastMessage', $this->user->getMessageData()['body']);
    }


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return mixed
     */
    abstract public function runCommand(array $matches);


    public function getDisplay()
    {
        return $this->display;
    }


    /**
     * getPermission()
     *
     * @return int
     */
    public function getPermission()
    {
        return $this->permission;
    }


    public function getRegexp()
    {
        return $this->regexp;
    }
}
