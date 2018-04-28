<?php
declare(strict_types = 1);
/**
 * File: UserData.php;
 * Author: nazbav;
 * Date: 15.04.2018;
 * Time: 16:37;
 */

namespace nazbav\Source\Interfaces\User;


/**
 * Class UserData
 *
 * @package nazbav\Source\Interfaces
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