<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category ModuleMessage
 * @package  Joker2620SourceEngineModuleMessage
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine\ModuleMessage;

use joker2620\Source\Engine\Setting\SustemConfig;
use joker2620\Source\Engine\Setting\UserConfig;

/**
 * Class HTMessagesBase
 *
 * @category ModuleMessage
 * @package  Joker2620SourceEngineModuleMessage
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class HTMessagesBase extends TrainingEdit
{
    /**
     * Сканер Training
     *
     * Служит для добавления ответа в базу.
     *
     * @param array $msgsx Даннык
     *
     * @return bool|string
     */
    public function training($msgsx)
    {
        $return = false;
        if (UserConfig::getConfig()['USER_TRAINING']) {
            if (preg_match('/^(\!наобучение)$/iu', $msgsx['body'])) {
                $return = $this->addTraining($msgsx);
            } elseif ($this->scanMsgUser($msgsx)) {
                if (preg_match('/^(нет)$/iu', $msgsx['body'])) {
                    $this->addAnswer($msgsx, true);
                    $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][6];
                } elseif (preg_match('/^(!мусор)$/iu', $msgsx['body'])) {
                    $this->delAnswer($msgsx);
                    $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][9];
                } else {
                    if (mb_strlen($msgsx['body']) > 5) {
                        $this->addAnswer($msgsx);
                        $return
                            = SustemConfig::getConfig()['MESSAGE']['TextMessage'][4];
                    } else {
                        $return
                            = SustemConfig::getConfig()['MESSAGE']['TextMessage'][2];
                    }
                }
            }
        }
        return $return;
    }


    /**
     * Сканер Schooling
     *
     * Ищет ответы в пользовательской базе
     * (в базе, где ответы на вопросы создают сами пользователи)
     *
     * @param array $msgsx Данык
     *
     * @return bool|string
     */
    public function schooling($msgsx)
    {
        $answer = [];
        $return = false;
        $height = UserConfig::getConfig()['MIN_PERCENT'];
        $result = file(SustemConfig::getConfig()['FILE_TRAINING']);
        if (!empty($result)) {
            $base_data = json_decode($result[0], true);
            if (!empty($base_data)) {
                foreach ($base_data as $lines) {
                    if (similar_text($msgsx['body'], $lines[0], $percent)) {
                        $arraykey = array_keys($answer);
                        if (count($answer) > 1) {
                            $maxkey = max($arraykey);
                        } else {
                            $maxkey = array_shift($arraykey);
                        }
                        if ($height < $maxkey) {
                            $height = $maxkey;
                        }
                        $percent = intval($percent);
                        if ($percent >= $height) {
                            $answer[$percent][] = $lines[1];
                        }
                    }
                }
            }
        }
        if (isset($answer)) {
            krsort($answer);
            $answer = array_shift($answer);
            $answer = $answer[rand(0, count($answer) - 1)];
            $return = $answer;
        }
        return $return;
    }

    /**
     * Сканер Prehistoric
     *
     * Основной сканер поиска ответов в базе.
     *
     * @param array $msgsx Данные пользователя
     *
     * @see \similar_text() Функция для определения процента схожести текста,
     *
     * @return bool|string
     */
    public function prehistoric($msgsx)
    {
        $answer = [];
        $return = false;
        $height = UserConfig::getConfig()['MIN_PERCENT'];
        $result = fopen(SustemConfig::getConfig()['FILE_BASE'], 'r');
        if (!empty($result)) {
            while (false !== ($lines = fgets($result))) {
                $lines = explode('\\', $lines);
                if (similar_text($msgsx['body'], $lines[0], $percent)) {
                    $arraykey = array_keys($answer);
                    if (count($answer) > 1) {
                        $maxkey = max($arraykey);
                    } else {
                        $maxkey = array_shift($arraykey);
                    }
                    if ($height < $maxkey) {
                        $height = $maxkey;
                    }
                    $percent = intval($percent);
                    if ($percent >= $height) {
                        $answer[$percent][] = $lines[1];
                    }
                }
            }
            fclose($result);
        }
        if (isset($answer)) {
            krsort($answer);
            // Loger::getInstance()->logger($answer);
            $answer = array_shift($answer);
            //  Loger::getInstance()->logger($answer);
            $answer = $answer[rand(0, count($answer) - 1)];
            $return = $answer;
        }
        return $return;
    }
}
