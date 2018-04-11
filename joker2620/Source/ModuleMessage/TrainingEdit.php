<?php
declare(strict_types = 1);

namespace joker2620\Source\ModuleMessage;

use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\User\User;


/**
 * Class TrainingEdit
 *
 * @package joker2620\Source\ModuleMessage
 */
class TrainingEdit
{
    public $user;

    private $baseName;

    private $baseData;


    /**
     * TrainingEdit constructor.
     */
    public function __construct()
    {
        $this->user     = new User();
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


    public function __destruct()
    {
        $data_to_write = json_encode($this->baseData, JSON_UNESCAPED_UNICODE);
        $resource      = fopen($this->baseName, 'w+');
        fwrite($resource, $data_to_write);
        fclose($resource);
    }


    /**
     * addAnswer()
     *
     * @param bool $no
     */
    protected function addAnswer(bool $no = false)
    {
        foreach ($this->baseData as $key_base => $data_base) {
            if ($data_base[2] == $this->user->getId() && $data_base[1] == false) {
                $this->baseData[$key_base] = [
                    $data_base[0],
                    $no == false ? $this->user->getMessageData()['body'] : false,
                    false,
                    isset($data_base[3]) ? $data_base[3] : false
                ];
            }
        }
    }


    protected function delAnswer()
    {
        foreach ($this->baseData as $key_base => $data_base) {
            if ($data_base[2] == $this->user->getId() && $data_base[1] == false) {
                unset($this->baseData[$key_base]);
            }
        }
    }


    /**
     * addTraining()
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
                    $this->user->getId(), $data_base[3]
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
     * addQuestion()
     *
     * @param bool $no
     */
    protected function addQuestion(bool $no = false)
    {
        $this->baseData   = $this->uniqueMultiArray($this->baseData, 0);
        $this->baseData   = $this->uniqueMultiArray($this->baseData, 2);
        $this->baseData[] = [
            $this->user->getMessageData()['body'],
            false,
            $no == false ? $this->user->getId() : false,
            $this->user->getId()
        ];
    }


    /**
     * uniqueMultiArray()
     *
     * @param array $array
     * @param int   $key
     *
     * @return array
     */
    protected function uniqueMultiArray(array $array, int $key)
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
     * scanMsgUser()
     *
     * @return bool
     */
    protected function scanMsgUser()
    {
        if ($this->baseData) {
            foreach ($this->baseData as $key_base => $data_base) {
                if ($data_base[2] == $this->user->getId()) {
                    return true;
                }
            }
        }
        return false;
    }
}
