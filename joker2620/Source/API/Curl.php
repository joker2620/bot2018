<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category API
 * @package  Joker2620\Source\API
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */

namespace joker2620\Source\API;


use joker2620\Source\Engine\Loger;
use joker2620\Source\Exception\BotError;

/**
 * Class Curl
 *
 * @category API
 * @package  Joker2620\Source\API
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class Curl
{
    /**
     * Функция библиотеки CURL
     *
     * @param string $url       Ссылка
     * @param int    $curlmode  Режим
     * @param mixed  $file_name Доп. Данные
     *
     * @return mixed
     * @throws BotError
     */
    public function curl($url, $curlmode = 0, $file_name = null)
    {
        if (!function_exists('curl_init')) {
            throw new BotError('cURL Не работает');
        }
        $curl_setopt = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true
        ];
        switch ($curlmode) {
        case 0:
            $curl_setopt += [
                CURLOPT_HEADER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_URL => $url,
                CURLOPT_REFERER => $url
            ];
            break;
        case 1:
            $curl_setopt += [
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: multipart/form-data; boundary=' .
                    $file_name[1],
                    'Content-Length: ' . strlen($file_name[0])
                ],
                CURLOPT_POSTFIELDS => $file_name[0]
            ];
            break;
        case 2:
            $curl_setopt += [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => ['file' => new \CURLFile($file_name)]
            ];
            break;
        case 3:
            $curl_setopt += [
                CURLOPT_POST => true,
                CURLOPT_TIMEOUT, 30,
                CURLOPT_POSTFIELDS => $file_name
            ];
            break;
        case 4:
            $curl_setopt += [CURLOPT_FILE => $file_name];
            break;
        }
        $curlh = curl_init($url);
        curl_setopt_array($curlh, $curl_setopt);
        $result = curl_exec($curlh);
        $error  = curl_error($curlh);
        if ($error) {
            Loger::getInstance()->logger($error);
            Loger::getInstance()->logger($result);
            throw new BotError('[ERROR]: ' . $error . ' ' . $url);
        }
        curl_close($curlh);
        return $result;
    }
}
