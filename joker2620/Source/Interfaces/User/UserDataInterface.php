<?php
declare(strict_types = 1);
/**
 * File: UserData.php;
 * Author: Joker2620;
 * Date: 15.04.2018;
 * Time: 16:37;
 */

namespace joker2620\Source\Interfaces\User;


/**
 * Class UserData
 *
 * @package joker2620\Source\Interfaces
 */
interface UserDataInterface
{
    /**
     * getVar()
     *
     * @param $name
     *
     * @return array
     */
    public function read($name);

    /**
     * addVar()
     *
     * @param $name
     * @param $param
     *
     */
    public function write($name, $param);


    /**
     * user()
     *
     * @return array
     */
    public function user();
}