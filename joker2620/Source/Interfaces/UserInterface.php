<?php
/**
 * File: UserInterface.php;
 * Author: Joker2620;
 * Date: 22.03.2018;
 * Time: 0:31;
 */

namespace joker2620\Source\Interfaces;


/**
 * Interface UserInterface
 *
 * @package joker2620\Source\Interfaces
 */
interface UserInterface
{
    /**
     * @return string
     */
    static function getId();

    /**
     * @return string
     */
    static function getFirstName();

    /**
     * @return string
     */
    static function getLastName();

    /**
     * Get raw driver's user info.
     *
     * @return array
     */
    static function getInfo();

    /**
     * Get message data
     *
     * @return array
     */
    static function getMessageData();
}