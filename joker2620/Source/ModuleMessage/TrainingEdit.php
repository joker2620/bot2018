<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category ModuleMessage
 * @package  Joker2620\Source\ModuleMessage
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\ModuleMessage;

use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\User;

/**
 * Class TrainingEdit
 *
 * @category ModuleMessage
 * @package  Joker2620\Source\ModuleMessage
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class TrainingEdit
{
    /**
     * Файл базы пользовательских сообщений
     */
    private $baseName;
    /**
     * Массив из базы пользовательских сообщений
     */
    private $baseData;

    /**
     * TrainingEdit constructor.
     */
    public function __construct()
    {
        $this->baseName = SustemConfig::getConfig()['FILE_TRAINING'];
        if (file_exists($this->baseName)) {
            $file_name     = $this->baseName;
            $file_resource = fopen($file_name, "r+");
            $file_base     = fread($file_resource, filesize($file_name));
            if ($file_base) {
                $resource = json_decode($file_base, true);
                if ($resource !== false) {
                    $this->baseData = $resource;
                } else {
                    $this->baseData = [];
                }
            } else {
                $this->baseData = [];
            }
            fclose($file_resource);
        }
    }

    /**
     * TrainingEdit destructor.
     */
    public function __destruct()
    {
        $data_to_write = json_encode($this->baseData, JSON_UNESCAPED_UNICODE);
        $resource      = fopen($this->baseName, 'w+');
        fwrite($resource, $data_to_write);
        fclose($resource);
    }

    /**
     * Функция добавления ответа в пользовательскую базу.
     *
     * @param bool $no Режим
     *
     * @return void
     */
    protected function addAnswer($no = false)
    {
        foreach ($this->baseData as $key_base => $data_base) {
            if ($data_base[2] == User::getId() && $data_base[1] == false) {
                $this->baseData[$key_base] = [
                    $data_base[0],
                    $no == false ? User::getMessageData()['body'] : false,
                    false,
                    isset($data_base[3]) ? $data_base[3] : false
                ];
            }
        }
    }

    /**
     * Функция удаления сообщения из пользовательской базы
     *
     * @return void
     *
     */
    protected function delAnswer()
    {
        foreach ($this->baseData as $key_base => $data_base) {
            if ($data_base[2] == User::getId() && $data_base[1] == false) {
                unset($this->baseData[$key_base]);
            }
        }
    }

    /**
     * Функция включения режима "обучения", у определенного сообщения.
     *
     * @return string
     */
    protected function addTraining()
    {
        $message = SustemConfig::getConfig()['MESSAGE']['TextMessage'][8];
        foreach ($this->baseData as $key_base => $data_base) {
            if ($data_base[2] == 0 && $data_base[1] == false) {
                $this->baseData[$key_base] = [
                    $data_base[0], $data_base[1],
                    User::getId(), $data_base[3]
                ];

                $message = sprintf(
                    SustemConfig::getConfig()['MESSAGE']['TextMessage'][7],
                    $data_base[0]
                );
            }
        }
        return $message;
    }

    /**
     * Функция добавления вопроса в базу
     *
     * @param bool $no Режим
     *
     * @return void
     */
    protected function addQuestion($no = false)
    {
        $this->baseData   = $this->uniqueMultiArray($this->baseData, 0);
        $this->baseData   = $this->uniqueMultiArray($this->baseData, 2);
        $this->baseData[] = [
            User::getMessageData()['body'],
            false,
            $no == false ? User::getId() : false,
            User::getId()
        ];
    }

    /**
     * UniqueMultiArray()
     *
     * @param array $array Массив
     * @param mixed $key   Ключ
     *
     * @return array
     * @link   http://php.net/manual/ru/function.array-unique.php#116302
     */
    protected function uniqueMultiArray($array, $key)
    {
        $temp_array = [];
        if (is_array($array)) {
            $inter     = 0;
            $key_array = [];

            foreach ($array as $value) {
                if (!in_array($value[$key], $key_array)) {
                    $key_array[$inter]  = $value[$key];
                    $temp_array[$inter] = $value;
                }
                $inter++;
            }
        }
        return $temp_array;
    }

    /**
     * Функия сканирования сообщения.
     *
     * @return bool
     */
    protected function scanMsgUser()
    {
        if ($this->baseData) {
            foreach ($this->baseData as $key_base => $data_base) {
                if ($data_base[2] == User::getId()) {
                    return true;
                }
            }
        }
        return false;
    }
}
