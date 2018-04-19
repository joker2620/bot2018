<?php
declare(strict_types = 1);
/**
 * File: UserData.php;
 * Author: Joker2620;
 * Date: 14.04.2018;
 * Time: 21:41;
 */

namespace joker2620\Source\User;

use joker2620\JsonDb\JsonDb;
use joker2620\Source\Engine\BotFunction;
use joker2620\Source\Interfaces\User\UserDataInterface;
use joker2620\Source\Setting\Config;

/**
 * Class UserData
 *
 * @package joker2620\Source\User
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
    }

    /**
     * getVar()
     *
     * @param $name
     *
     * @return string
     */
    public function read($name): string
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