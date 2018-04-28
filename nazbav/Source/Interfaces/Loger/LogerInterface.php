<?php
declare(strict_types = 1);
/**
 * File: LogerInterface.php;
 * Author: nazbav;
 * Date: 15.04.2018;
 * Time: 16:54;
 */

namespace nazbav\Source\Interfaces\Loger;


/**
 * Interface LogerInterface
 *
 * @package nazbav\Source\Interfaces\Loger
 */
interface LogerInterface
{

    /**
     * logger()
     *
     * @param $message
     *
     */
    public function logger($message): void;

    /**
     * message()
     *
     * @param string $message
     * @param string $answer
     */
    public function message(string $message, string $answer): void;
}