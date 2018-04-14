<?php
declare(strict_types = 1);
/**
 * File: UserData.php;
 * Author: Joker2620;
 * Date: 14.04.2018;
 * Time: 21:41;
 */

namespace joker2620\Source\User;

use joker2620\Source\Functions\BotFunction;
use joker2620\Source\Setting\SustemConfig;
use MrKody\JsonDb\JsonDb;


/**
 * Class UserData
 *
 * @package joker2620\Source\User
 */
class UserData
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
            SustemConfig::getConfig()['DIR_USER'], 'Users.json'
        );
        $this->dataBase->from($this->userFile);
    }

    /**
     * getVar()
     *
     * @param $name
     *
     * @return array
     */
    public function getVar($name)
    {
        $user_var = $this->dataBase
            ->select($name)
            ->where(['uid' => $this->user->getId()])
            ->get();
        if (isset($user_var[0])) {
            return $user_var[0];
        }
        return [];
    }

    /**
     * newVar()
     *
     * @return array
     */
    public function user()
    {
        $users = $this->dataBase->select('uid')->where(['uid' => $this->user->getId()])->get();
        if (!isset($users[0])) {
            $uvars        = SustemConfig::getConfig()['DEFAULT_USER_VARS'];
            $uvars['uid'] = $this->user->getId();
            return $this->dataBase->insert(
                $this->userFile, $uvars
            );
        }
        return [];
    }

    /**
     * toVar()
     *
     * @param $name
     * @param $param
     *
     * @return JsonDb
     */
    public function addVar($name, $param = '')
    {
        return $this->dataBase
            ->update([$name => $param])
            ->where(['uid' => $this->user->getId()])
            ->trigger();
    }
}