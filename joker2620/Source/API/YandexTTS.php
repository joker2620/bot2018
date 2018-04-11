<?php
declare(strict_types = 1);


namespace joker2620\Source\API;

use joker2620\Source\Exception\BotError;
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;


/**
 * Class YandexTTS
 *
 * @package joker2620\Source\API
 */
class YandexTTS extends Curl
{


    /**
     * getVoice()
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
        $file_name = SustemConfig::getConfig()['DIR_AUDIO'] .
            '/aud_' . md5($text) . '.ogg';
        if (file_exists($file_name)) {
            $this->validFile($file_name);
            return $file_name;
        }

        $filevoice = fopen($file_name, 'w+');
        $query     = http_build_query(
            [
                'format' => 'opus',
                'lang' => $lang,
                'speaker' => $speaker,
                'key' => UserConfig::getConfig()['SPEECH_KEY'],
                'emotion' => $emoticon,
                'text' => $text,
            ]
        );

        $urladress = SustemConfig::getConfig()['YA_ENDPOINT'] . '?' . $query;
        $this->curl($urladress, 4, $filevoice);
        $this->validFile($file_name);
        return $file_name;
    }


    /**
     * validFile()
     *
     * @param string $file_name
     *
     * @throws BotError
     */
    private function validFile(string $file_name)
    {
        $read_file = fopen($file_name, 'r');
        $get_data  = fread($read_file, filesize($file_name));
        if (preg_match('/Key param is empty or absent\\!/iu', $get_data)) {
            throw new BotError(
                'YandexAPI: не указан(или не верный) ключ. Удалите файл: ' .
                $file_name
            );
        }
    }
}
