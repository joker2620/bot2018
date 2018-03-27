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
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;

/**
 * Class YandexTTS
 *
 * Класс для работы с API YANDEX.RU
 *
 * @category API
 * @package  Joker2620\Source\API
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class YandexTTS extends Curl
{
    /**
     * Функция генерации голоса из текста
     *
     * @param string $text     Текст
     * @param string $speaker  Имя спикера
     * @param string $emoticon Эмоциональный окрас
     * @param string $lang     Язык
     *
     * @see \ConfigCore::DIR_AUDIO Папка с аудио
     * @see \ConfigYandex::SPEECH_KEY Ключ API
     * @see \ConfigYandex::ENDPOINT Адрес API
     *
     * @return string
     * @throws BotError
     */
    public function getVoice(
        $text,
        $speaker = 'jane',
        $emoticon = 'good',
        $lang = 'ru-RU'
    ) {
        if (!is_string($text) || !is_string($speaker) ||
            !is_string($emoticon) || !is_string($lang)
        ) {
            throw new BotError('Error: call getVoice().');
        };
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
     * ValidFile()
     *
     * Проверка файла на ошибки
     *
     * @param string $file_name Файл
     *
     * @throws BotError
     * @return void
     */
    private function validFile($file_name)
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
