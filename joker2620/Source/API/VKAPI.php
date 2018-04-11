<?php
declare(strict_types = 1);

namespace joker2620\Source\API;

use joker2620\Source\Exception\BotError;
use joker2620\Source\Functions\BotFunction;
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;
use VK\Client\VKApiClient;

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
class VKAPI
{
    private $accessToken, $vkapi, $botFucntion;

    /**
     * VKAPI constructor.
     */
    public function __construct()
    {
        $this->accessToken = UserConfig::getConfig()['ACCESS_TOKEN'];
        $this->botFucntion = new BotFunction();
        $this->vkapi       = new VKApiClient();
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
        if (!is_int($user_id) || !is_string($file_name)) {
            throw new BotError('Error: call uploadVoice.');
        }
        $server_response = $this->docsGUServer($user_id, 'audio_message');
        $upload_response = $this->upload($server_response['upload_url'], $file_name, 'file');
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
        if (!is_int($peer_id) || !is_string($type)) {
            throw new BotError('Error: call docs_GetUploadServer.');
        }
        return $this->vkapi->docs()->getMessagesUploadServer(
            $this->accessToken,
            [
                'peer_id' => $peer_id,
                'type' => $type,
            ]
        );
    }

    /**
     * Функция загрузки файлов
     *
     * @param string $url       Адрес сервера
     * @param string $file_name Имя файла
     *
     * @param string $type
     *
     * @return mixed
     * @throws BotError
     */
    public function upload($url, $file_name = '', $type = 'photo')
    {
        if (!is_string($url) || !is_string($file_name) && !is_object($file_name)) {
            throw new BotError('Error: call api.');
        }
        return $this->vkapi->getRequest()->upload($url, $type, $file_name);
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
        if (!is_string($file) || !is_string($title)) {
            throw new BotError('Error: call docs_Save.');
        }
        return $this->vkapi->docs()->save(
            $this->accessToken,
            [
                'file' => $file,
                'title' => $title,
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
     */
    public function methodAPI($method, $params = [])
    {
        if (!is_string($method) || !is_array($params)) {
            throw new BotError('Error: call api.');
        }
        $access_token = $this->getToken($params);
        return $this->vkapi->getRequest()->request($method, $access_token, $params);
    }

    /**
     * searchToken()
     *
     * @param string $parameters
     *
     * @return mixed
     *
     */
    private function getToken($parameters = '')
    {
        $token = $this->accessToken;
        if (is_array($parameters)) {
            if (isset($parameters['access_token'])
                && is_string($parameters['access_token']) && '' != $parameters['access_token']
            ) {
                $token = $parameters['access_token'];
            }
        }
        return $token;
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
        if (!is_int($peer_id) || !is_string($file_name) && !is_object($file_name)) {
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
        return $this->vkapi->photos()->getMessagesUploadServer(
            $this->accessToken,
            [
                'peer_id' => $peer_id,
            ]
        );
    }

    /**
     * Функция сохранения фотографий
     *
     * @param string $photo  Фото
     * @param int    $server Сервер
     * @param string $hash   Хеш
     *
     * @return mixed
     * @throws BotError
     */
    public function photoSave($photo, $server, $hash)
    {
        if (!is_string($photo) || !is_int($server) || !is_string($hash)) {
            throw new BotError('Error: call photo_Save.');
        }
        return $this->vkapi->photos()->saveMessagesPhoto(
            $this->accessToken,
            [
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
        if (!is_int($peer_id) || !is_string($message) || !is_array($attachment) && !is_bool($attachment)) {
            throw new BotError('Error: call messagesSend.');
        }
        return $this->vkapi->messages()->send(
            $this->accessToken,
            [
                'peer_id' => $peer_id,
                'message' => $message ?
                    $this->botFucntion->ucFirst($message) :
                    SustemConfig::getConfig()['MESSAGE']['Main'][1],
                'attachment' => $attachment ?
                    implode(',', $attachment) : false,
            ]
        );
    }

    /**
     * Функция получения основных данных о пользователе
     *
     * @param int         $peer_id Айди
     * @param bool|string $name_sk Все варианты склонения имени и фамилии
     *
     * @return mixed
     * @throws BotError
     */
    public function usersGet($peer_id, $name_sk = true)
    {
        if (!is_int($peer_id) && !is_bool($name_sk)) {
            throw new BotError('Error: call usersGet.');
        }
        $param = ['timezone', 'sex', 'photo_50', 'city'];
        if (true == $name_sk) {
            $param = array_merge(
                $param, [
                    'first_name_abl', 'first_name_ins', 'first_name_acc',
                    'first_name_dat', 'first_name_gen', 'last_name_abl',
                    'last_name_ins', 'last_name_acc', 'last_name_dat', 'last_name_gen'
                ]
            );
        }
        return $this->vkapi->users()->get(
            $this->accessToken, [
                'user_ids' => $peer_id,
                'fields' => $param,
            ]
        );
    }
}
