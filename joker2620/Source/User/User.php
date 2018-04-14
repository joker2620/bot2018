<?php
declare(strict_types = 1);


namespace joker2620\Source\User;

use joker2620\Source\Interfaces\UserInterface;


/**
 * Class User
 *
 * @package joker2620\Source\User
 */
class User implements UserInterface
{

    static protected $userInfo;

    static protected $messageData;


    /**
     * setUserData()
     *
     * @param array $user_info
     * @param array $messageData
     *
     * @return void
     */
    public function setUserData(array $user_info, array $messageData): void
    {
        self::$messageData = $messageData;
        self::$userInfo    = $user_info;
    }

    /**
     * getId()
     *
     * @return int
     */
    public function getId(): int
    {
        return self::$userInfo['id'];
    }


    /**
     * getFirstName()
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return self::$userInfo['first_name'];
    }


    /**
     * getLastName()
     *
     * @return string
     */
    public function getLastName(): string
    {
        return self::$userInfo['last_name'];
    }


    /**
     * getInfo()
     *
     * @return array
     */
    public function getInfo(): array
    {
        return self::$userInfo;
    }


    /**
     * getMessageData()
     *
     * @return array
     */
    public function getMessageData(): array
    {
        return self::$messageData;
    }
}