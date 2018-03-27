<?php
declare(strict_types = 1);
/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category API
 * @package  Joker2620\Source\API
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\API;

use joker2620\Source\Exception\BotError;
use joker2620\Source\Loger\Loger;

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
    private $loger;

    /**
     * Curl constructor.
     */
    public function __construct()
    {
        $this->loger = new Loger();
    }

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
        if (!is_string($url) || !is_int($curlmode)) {
            throw new BotError('cURL: ошибка, не верные данные');
        }
        if (!function_exists('curl_init')) {
            throw new BotError('cURL Не работает');
        }
        $curl_setopt = $this->curlMode($curlmode, $file_name);
        $curlh       = curl_init($url);
        curl_setopt_array($curlh, $curl_setopt);
        $result = curl_exec($curlh);
        $error  = curl_error($curlh);
        if ($error) {
            $this->loger->logger($error);
            $this->loger->logger($result);
            throw new BotError('[ERROR]: ' . $error . ' ' . $url);
        }
        curl_close($curlh);
        return $result;
    }

    /**
     * _curlMode()
     *
     * @param int   $curlmode  Режим
     * @param mixed $file_name Доп. Данные
     *
     * @return array
     * @internal param string $url Ссылка
     */
    private function curlMode($curlmode = 0, $file_name = null)
    {
        $curl_setopt = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true
        ];
        switch ($curlmode) {
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
        return $curl_setopt;
    }
}
