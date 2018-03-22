<?php
/**
 * File: User.php;
 * Author: Joker2620;
 * Date: 22.03.2018;
 * Time: 0:29;
 */

namespace joker2620\Source;

use joker2620\Source\Interfaces\UserInterface;


/**
 * Class User
 *
 * @package joker2620\Source
 */
class User implements UserInterface
{
    /** @var string */
    static protected $userId;
    /** @var string */
    static protected $firstName;
    /** @var string */
    static protected $lastnName;
    /** @var array */
    static protected $userInfo;
    /** @var array */
    static protected $messageData;

    /**
     * User constructor.
     *
     * @param array $user_info
     * @param array $messageData
     */
    public function __construct(array $user_info, array $messageData)
    {
        self::$userId    = $user_info['id'];
        self::$firstName = $user_info['first_name'];
        self::$lastnName = $user_info['last_name'];
        unset($user_info['id'], $user_info['first_name'], $user_info['last_name']);
        self::$userInfo    = $user_info;
        self::$messageData = $messageData;
    }

    /**
     * @return string
     */
    static function getId()
    {
        return self::$userId;
    }

    /**
     * @return string
     */
    static function getFirstName()
    {
        return self::$firstName;
    }

    /**
     * @return string
     */
    static function getLastName()
    {
        return self::$lastnName;
    }

    /**
     * {@inheritdoc}
     */
    static function getInfo()
    {
        return self::$userInfo;
    }

    /**
     * {@inheritdoc}
     */
    static function getMessageData()
    {
        return self::$messageData;
    }
}