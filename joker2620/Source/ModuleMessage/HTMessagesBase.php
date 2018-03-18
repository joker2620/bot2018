<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
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
use joker2620\Source\Setting\UserConfig;

/**
 * Class HTMessagesBase
 *
 * @category ModuleMessage
 * @package  Joker2620\Source\ModuleMessage
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class HTMessagesBase extends TrainingEdit
{
    private $database = [];

    /**
     * Сканер Prehistoric
     *
     * Основной сканер поиска ответов в базе.
     *
     * @param array $msgsx Данные пользователя
     *
     * @param bool  $file_base
     *
     * @return bool|string
     * @see \similar_text() Функция для определения процента схожести текста,
     *
     */
    public function prehistoric(&$msgsx, $file_base = false)
    {
        //$this->database = [];
        $return         = false;
        $height         = UserConfig::getConfig()['MIN_PERCENT'];
        if ($file_base) {
            $fname     = SustemConfig::getConfig()['FILE_TRAINING'];
            $results   = fopen($fname, 'r+');
            $result    = fread($results, filesize($fname));
            $base_data = json_decode($result, true);
            if ($result) {
                foreach ($base_data as $lines) {
                    $height = $this->scanBase($msgsx, $lines, $height);
                }
                unset($result);
            }
            fclose($results);
        } else {
            $fname  = SustemConfig::getConfig()['FILE_BASE'];
            $result = file(
                $fname,
                FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
            );
            if ($result) {
                foreach ($result as $lines) {
                    $lines  = explode('\\', $lines);
                    $height = $this->scanBase($msgsx, $lines, $height);
                }
                unset($result);
            }
        }
        if ($this->database != []) {
            ksort($this->database);
            $answer = end($this->database);
            $answer = $answer[array_rand($answer)];
            $return = $answer;
        }
        return $return;
    }

    /**
     * _scanBase()
     *
     * @param $msgsx
     * @param $lines
     *
     * @param $height
     *
     * @return mixed
     */
    private function scanBase($msgsx, $lines, $height)
    {
        $height = $this->getHeight($height);
        if (similar_text($msgsx['body'], $lines[0], $percent)) {
            $percent = intval($percent);
            if ($percent >= $height) {
                $this->setDatabase($percent, $lines[1]);
            }
        }
        return $height;
    }

    /**
     * _getHeight()
     *
     * @param $height
     *
     * @return mixed
     */
    private function getHeight(&$height)
    {
        $arraykey = array_keys($this->database);
        sort($arraykey);
        $maxkey = end($arraykey);
        return $height < $maxkey ? $maxkey : $height;
    }

    /**
     * setDatabase()
     *
     * @param $per
     * @param $value
     */
    private function setDatabase($per, $value)
    {
        $this->database[$per][] = $value;
    }
}
