<?php
declare(strict_types = 1);

namespace joker2620\Source\API;

use joker2620\Source\Exception\BotError;
use joker2620\Source\Loger\Loger;


/**
 * Class Curl
 *
 * @package joker2620\Source\API
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
     * curl()
     *
     * @param string $url
     * @param int    $curlmode
     * @param null   $file_name
     *
     * @return mixed
     * @throws BotError
     */
    public function curl(string $url, int $curlmode = 0, $file_name = null)
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
     * curlMode()
     *
     * @param int  $curlmode
     * @param null $file_name
     *
     * @return array
     */
    private function curlMode(int $curlmode = 0, $file_name = null)
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
