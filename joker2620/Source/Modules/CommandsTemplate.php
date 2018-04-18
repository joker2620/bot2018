<?php
declare(strict_types = 1);

namespace joker2620\Source\Modules;

use joker2620\Source\API\VKAPI;
use joker2620\Source\Engine\Loger;
use joker2620\Source\User\User;
use joker2620\Source\User\UserData;


/**
 * Class CommandsTemplate
 *
 * @package joker2620\Source\ModuleCommand
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
