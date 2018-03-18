<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 7.1;
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source;

use joker2620\Source\Exception\BotError;

/**
 * Class DataOperations
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class DataOperations
{
    /**
     * Функция получения данных
     *
     * @param string $request
     *
     * @return bool|mixed
     * @throws BotError
     */
    public static function getData($request = '')
    {
        if (!is_array($request) && !$request) {
            $request = json_decode(file_get_contents('php://input'));
            if (!$request) {
                throw new BotError('Пришел пустой запрос');
            }
        } else {
            $request = (object)$request;
        }
        return $request;
    }

    /**
     * Функция отправки данных
     *
     * @param string $data Даннык
     *
     * @return void
     */
    public static function putData($responce = 'ok')
    {
        echo $responce;
    }
}
