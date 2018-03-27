<?php
declare(strict_types = 1);
/**
 * File: User.php;
 * Author: Joker2620;
 * Date: 22.03.2018;
 * Time: 0:29;
 */

namespace joker2620\Source\User;

use joker2620\Source\Interfaces\UserInterface;


/**
 * Class User
 *
 * @package joker2620\Source\Action
 */
class User implements UserInterface
{
    /** @var array */
    static protected $userInfo;
    /** @var array */
    static protected $messageData;

    /**
     * setUserData()
     *
     * @param array $user_info
     * @param array $messageData
     */
    public function setUserData(array $user_info, array $messageData)
    {
        self::$messageData = $messageData;
        self::$userInfo    = $user_info;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return self::$userInfo['id'];
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return self::$userInfo['first_name'];
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return self::$userInfo['last_name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getInfo()
    {
        return self::$userInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageData()
    {
        return self::$messageData;
    }
}