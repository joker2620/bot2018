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

use joker2620\Source\Crutch\FileInMemory;
use joker2620\Source\Crutch\ObjectFile;
use joker2620\Source\Engine\Setting\SustemConfig;
use joker2620\Source\Engine\Setting\UserConfig;
use joker2620\Source\Exception\BotError;

/**
 * Class VKAPI
 *
 * Класс для работы с API VK.COM
 *
 * @category API
 * @package  Joker2620\Source\API
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class VKAPI extends Curl
{
    /**
     * Копия класса
     */
    private static $_instance;

    /**
     * VKAPI constructor.
     */
    private function __construct()
    {
    }

    /**
     * GetInstance()
     *
     * @return VKAPI
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new VKAPI();
        }

        return self::$_instance;
    }

    /**
     * Функция загрузки голосовых сообщений в вк
     *
     * @param int    $user_id   Айди пользователя
     * @param string $file_name Имя файла
     *
     * @return mixed
     * @throws BotError
     */
    public function uploadVoice($user_id, $file_name)
    {
        if (!is_int($user_id) && !is_string($file_name)) {
            throw new BotError('Error: call uploadVoice.');
        }
        $server_response = $this->docsGUServer($user_id, 'audio_message');
        $upload_response = $this->upload($server_response['upload_url'], $file_name);
        $files           = $upload_response['file'];
        $save_response   = $this->docsSave($files, 'Voice message');
        $doccx           = max($save_response);
        return $doccx;
    }

    /**
     * Функция получения адреса для загрузки документов
     *
     * @param int    $peer_id Айди
     * @param string $type    Тип документа
     *
     * @return mixed
     * @throws BotError
     */
    public function docsGUServer($peer_id, $type)
    {
        if (!is_int($peer_id) && !is_string($type)) {
            throw new BotError('Error: call docs_GetUploadServer.');
        }
        return $this->methodAPI(
            'docs.getMessagesUploadServer', [
                'peer_id' => $peer_id,
                'type' => $type,
            ]
        );
    }

    /**
     * Функция (Application Programming Interface)
     *
     *  Для отправки запросов к API VK.COM
     *
     * @param string $method метод VK API
     * @param array  $params Массив параметров
     *
     * @return mixed
     * @throws BotError
     * @see    \ConfigVKAPI::ENDPOINT Адрес API
     * @see    \ConfigVKAPI::VERSION версия API
     * @see    \ConfigVKAPI::ACCESS_TOKEN Токен сообщества
     */
    public function methodAPI($method, $params = [])
    {
        if (!is_string($method) && !is_array($params)) {
            throw new BotError('Error: call api.');
        }
        if (!isset($params['access_token'])) {
            $params['access_token'] = UserConfig::getConfig()['ACCESS_TOKEN'];
        }
        $params['lang'] = 'ru';
        $params['v']    = SustemConfig::getConfig()['VK_VERSION'];

        $query        = http_build_query($params);
        $curlurl      = SustemConfig::getConfig()['VK_ENDPOINT'] .
            $method . '?' . $query;

        $responsejson = $this->curl($curlurl);
        $response     = json_decode($responsejson, true);
        if (!isset($response['response'])
            || empty($response['response'])
            || isset($response['error'])
        ) {
            (new ErrorScaner)->read($response, $method, $params);
        }
        return $response['response'];
    }


    /**
     * Функция загрузки файлов
     *
     * @param string $url       Адрес сервера
     * @param string $file_name Имя файла
     *
     * @return mixed
     * @throws BotError
     */
    public function upload($url, $file_name = '')
    {
        if (!is_string($url) && !is_string($file_name)) {
            throw new BotError('Error: call api.');
        }
        if ($file_name instanceof ObjectFile) {
            $fileobject   = FileInMemory::getInstance()->getFilePost(
                ['file1' => $file_name]
            );
            $responsejson = $this->curl($url, 1, $fileobject);
        } elseif (is_file($file_name) && file_exists($file_name)) {
            $responsejson = $this->curl($url, 2, $file_name);
        } else {
            throw new BotError('Error in: VKAPI::upload()');
        }
        $response = json_decode($responsejson, true);
        if (!$response || isset($response['error'])) {
            (new ErrorScaner)->read($response, 'upload()');
        }

        return $response;

    }

    /**
     * Функция сохранения документа
     *
     * @param string $file  Имя файла
     * @param string $title Заголовок
     *
     * @return mixed
     * @throws BotError
     */
    public function docsSave($file, $title)
    {
        if (!is_string($file) && !is_string($title)) {
            throw new BotError('Error: call docs_Save.');
        }
        return $this->methodAPI(
            'docs.save', [
                'file' => $file,
                'title' => $title,
            ]
        );
    }

    /**
     * Функция зарузки фотографий
     *
     * @param int    $peer_id   Айди
     * @param string $file_name Имя файла
     *
     * @return mixed
     * @throws BotError
     */
    public function uploadPhoto($peer_id, $file_name)
    {
        if (!is_int($peer_id) && !is_string($file_name)) {
            throw new BotError('Error: call uploadPhoto.');
        }
        $server_response = $this->photosGUServer($peer_id);
        $upload_response = $this->upload($server_response['upload_url'], $file_name);
        $photo           = $upload_response['photo'];
        $server          = $upload_response['server'];
        $hashd           = $upload_response['hash'];
        $save_response   = $this->photoSave($photo, $server, $hashd);
        $photo           = max($save_response);
        return $photo;
    }

    /**
     * Функция получения адреса для загрузки фотографи
     *
     * @param int $peer_id Айди
     *
     * @return mixed
     * @throws BotError
     */
    public function photosGUServer($peer_id)
    {
        if (!is_int($peer_id)) {
            throw new BotError('Error: call photos_GetUploadServer.');
        }
        return $this->methodAPI(
            'photos.getMessagesUploadServer', [
                'peer_id' => $peer_id,
            ]
        );
    }

    /**
     * Функция сохранения фотографий
     *
     * @param string $photo  Фото
     * @param string $server Сервер
     * @param string $hash   Хеш
     *
     * @return mixed
     * @throws BotError
     */
    public function photoSave($photo, $server, $hash)
    {
        if (!is_string($photo) && !is_string($server) && !is_string($hash)) {
            throw new BotError('Error: call photo_Save.');
        }
        return $this->methodAPI(
            'photos.saveMessagesPhoto', [
                'photo' => $photo,
                'server' => $server,
                'hash' => $hash,
            ]
        );
    }

    /**
     * Функция отправки сообщений
     *
     * @param int    $peer_id    Айди
     * @param string $message    Сообщение
     * @param array  $attachment Вложения
     *
     * @return mixed
     * @throws BotError
     */
    public function messagesSend($peer_id, $message = '', $attachment = [])
    {
        if (!is_int($peer_id) && !is_string($message) && !is_array($attachment)) {
            throw new BotError('Error: call messagesSend.');
        }
        return $this->methodAPI(
            'messages.send', [
                'peer_id' => $peer_id,
                'message' => !empty($message) ? $message :
                    'Крякнула уточка, крякнул и бот :)',
                'attachment' => !empty($attachment) ?
                    implode(',', $attachment) : false,
            ]
        );
    }

    /**
     * Функция получения основных данных о пользователе
     *
     * @param int    $peer_id   Айди
     * @param string $name_case Склонение имени и фамилии
     *
     * @return mixed
     * @throws BotError
     */
    public function usersGet($peer_id, $name_case = 'nom')
    {
        if (!is_int($peer_id) && !is_string($name_case)) {
            throw new BotError('Error: call usersGet.');
        }
        return $this->methodAPI(
            'users.get', [
                'user_id' => $peer_id,
                'fields' => 'sex',
                'name_case' => $name_case
            ]
        );
    }
}
