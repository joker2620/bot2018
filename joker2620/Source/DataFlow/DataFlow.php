<?php
declare(strict_types = 1);
/**
 * File: PutDataFlow.php;
 * Author: Joker2620;
 * Date: 24.03.2018;
 * Time: 13:22;
 */

namespace joker2620\Source\DataFlow;

use joker2620\Source\Exception\BotError;


/**
 * Class PutDataFlow
 *
 * @package joker2620\Source\DataFlow
 */
class DataFlow
{
    /**
     * Функция получения данных
     *
     * @param int|string $request
     *
     * @return bool|mixed
     * @throws BotError
     */
    public function readData($request = 0)
    {
        if (!is_array($request) && !$request) {
            $request = json_decode(file_get_contents('php://input'), true);
            if (!$request) {
                throw new BotError('Пришел пустой запрос');
            }
        }
        return (object)$request;
    }

    /**
     * Функция отправки данных
     *
     * @param string $responce
     *
     */
    public function putData(?string $responce = 'ok')
    {
        file_put_contents('php://output', $responce);
    }
}