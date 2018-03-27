<?php
declare(strict_types = 1);
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
     * setUserData()
     *
     * @param array $user_info
     * @param array $messageData
     *
     * @return
     */
    public function setUserData(array $user_info, array $messageData);

    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();

    /**
     * Get raw driver's user info.
     *
     * @return array
     */
    public function getInfo();

    /**
     * Get message data
     *
     * @return array
     */
    public function getMessageData();
}