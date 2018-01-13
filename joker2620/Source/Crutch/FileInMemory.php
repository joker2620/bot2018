<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Cructh
 * @package  Joker2620\Source\Crutch
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Crutch;

/**
 * Class FileInMemory
 *
 * @category Cructh
 * @package  Joker2620\Source\Crutch
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class FileInMemory
{

    /**
     * Instance
     *
     * @ignore
     */
    private static $_instance;

    /**
     * ConfigCommands constructor.
     *
     * @ignore
     */
    private function __construct()
    {

    }

    /**
     * GetInstance
     *
     * @ignore
     * @return FileInMemory
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new FileInMemory;
        }
        return self::$_instance;
    }

    /**
     * GetFilePost
     *
     * @param array $file Файл
     *
     * @return array
     */
    public function getFilePost($file)
    {
        $delimiter = '-------------' . uniqid();
        $post_data = PostConstructor::getBody($file, $delimiter);
        return [$post_data, $delimiter];
    }
}
