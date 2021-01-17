<?php

declare(strict_types=1);

namespace joker2620\Source\API;

use joker2620\Source\Exception\BotError;
use joker2620\Source\Setting\Config;
use VK\TransportClient\Curl\CurlHttpClient;

/**
 * Class YandexTTS.
 */
class YandexTTS
{
    /**
     * getVoice().
     *
     * @param string $text
     * @param string $speaker
     * @param string $emoticon
     * @param string $lang
     *
     * @return string
     */
    public function getVoice(
        string $text,
        string $speaker = 'jane',
        string $emoticon = 'good',
        string $lang = 'ru-RU'
    ) {
        $file_name = Config::getConfig()['DIR_AUDIO'].
            '/aud_'.md5($text).'.ogg';
        if (file_exists($file_name)) {
            $this->validFile($file_name);

            return $file_name;
        }

        $filevoice = fopen($file_name, 'w+');
        $query = http_build_query(
            [
                'format'  => 'opus',
                'lang'    => $lang,
                'speaker' => $speaker,
                'key'     => Config::getConfig()['SPEECH_KEY'],
                'emotion' => $emoticon,
                'text'    => $text,
            ]
        );
        $http_client = new CurlHttpClient(10);
        $urladress = Config::getConfig()['YA_ENDPOINT'].'?'.$query;
        $http_data = $http_client->post($urladress, ['file' => new \CURLFile($filevoice)]);
        $decoded_body = json_decode($http_data->getBody(), true);
        if ($decoded_body === null || !is_array($decoded_body)) {
            $decoded_body = $http_data->getBody();
        }
        $this->validFile($decoded_body);

        return $decoded_body;
    }

    /**
     * validFile().
     *
     * @param string $file_name
     *
     * @throws BotError
     */
    private function validFile(string $file_name)
    {
        $read_file = fopen($file_name, 'r');
        $get_data = fread($read_file, filesize($file_name));
        if (preg_match('/Key param is empty or absent\\!/iu', $get_data)) {
            throw new BotError(
                'YandexAPI: не указан(или не верный) ключ. Удалите файл: '.
                $file_name
            );
        }
    }
}
