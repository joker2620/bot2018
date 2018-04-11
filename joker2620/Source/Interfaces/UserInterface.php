<?php
declare(strict_types = 1);


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
     * @return mixed
     */
    public function setUserData(array $user_info, array $messageData);


    public function getId();


    public function getFirstName();


    public function getLastName();


    public function getInfo();


    public function getMessageData();
}