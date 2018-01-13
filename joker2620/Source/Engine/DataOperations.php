<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine;

use joker2620\Source\Exception\BotError;

/**
 * Class DataOperations
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class DataOperations
{
    /**
     * Функция получения данных
     *
     * @param array $data Тестовые данные
     *
     * @see php://input интерфейс вывода
     *
     * @return bool|mixed
     * @throws BotError
     */
    public static function getData($data = [])
    {
        if (!is_array($data) && empty($data)) {
            $request = json_decode(file_get_contents('php://input'), true);
            if (empty($request)) {
                throw new BotError('Пришел пустой запрос');
            } else {
                return $request;//LOLILOOP
            }
        }
        return $data;
    }

    /**
     * Функция отправки данных
     *
     * @param string $data Даннык
     *
     * @return void
     */
    public static function putData($data = 'ok')
    {
        echo $data;
        // exit;
    }
}
