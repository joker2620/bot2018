<?php
declare(strict_types = 1);
/**
 * File: UserData.php;
 * Author: nazbav;
 * Date: 14.04.2018;
 * Time: 21:41;
 */

namespace nazbav\Source\User;

use nazbav\JsonDb\JsonDb;
use nazbav\Source\Engine\BotFunction;
use nazbav\Source\Interfaces\User\UserDataInterface;
use nazbav\Source\Setting\Config;

/**
 * Class UserData
 *
 * @package nazbav\Source\User
 */
class UserData implements UserDataInterface
{
    private $userFile;
    private $dataBase;
    private $botFunction;
    private $user;

    /**
     * UserData constructor.
     */
    public function __construct()
    {
        $this->dataBase    = new JsonDb();
        $this->botFunction = new BotFunction();
        $this->user        = new User();
        $this->userFile    = $this->botFunction->buildPath(
            Config::getConfig()['DIR_BASE'], 'Users.json'
        );
        $this->dataBase->from($this->userFile);
        $this->user();
    }

    /**
     * user()
     *
     * @return array
     */
    public function user(): array
    {
        $users = $this->dataBase->select('uid')->where(['uid' => $this->user->getId()])->get();
        if (!isset($users[0])) {
            $uvars        = Config::getConfig()['DEFAULT_USER_VARS'];
            $uvars['uid'] = $this->user->getId();
            return $this->dataBase->insert($uvars);
        }
        return [];
    }

    /**
     * getVar()
     *
     * @param $name
     *
     * @return string
     */
    public function read($name)
    {
        $user_var = $this->dataBase
            ->select($name)
            ->where(['uid' => $this->user->getId()])
            ->get();
        if (isset($user_var[0])) {
            return $user_var[0][$name];
        }
        return '';
    }

    /**
     * write()
     *
     * @param $name
     * @param $param
     *
     * @return JsonDb
     */
    public function write($name, $param)
    {
        return $this->dataBase
            ->update([$name => $param])
            ->where(['uid' => $this->user->getId()])
            ->trigger();
    }
}