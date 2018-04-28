<?php
declare(strict_types = 1);


namespace nazbav\Source\Interfaces\User;


/**
 * Interface UserInterface
 *
 * @package nazbav\Source\Interfaces
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