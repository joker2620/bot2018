<?php
declare(strict_types = 1);
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

use joker2620\Source\Interfaces\ModuleInterface;
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;

/**
 * Class HTMessages
 *
 * @category ModuleMessage
 * @package  Joker2620\Source\ModuleMessage
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class HTMessages extends HTMessagesBase implements ModuleInterface
{
    /**
     * Деструктор
     *
     * @ingore
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Функция поиска текстового ответа на сообщение
     *
     * @return bool|string
     *
     */
    public function getAnwser()
    {
        $return = $this->scanAnswer();
        if (!$return) {
            $return = $this->prehistoric(true);
        }
        if (!$return) {
            $return = $this->prehistoric();
        }
        if (!$return) {
            $return = $this->noAnswer($return);
        }
        return [$return, false];
    }


    /**
     * _noAnswer()
     *
     * @return string
     */
    private function scanAnswer()
    {
        $return = false;
        if (UserConfig::getConfig()['USER_TRAINING']) {
            if (preg_match('/^(\!наобучение)$/iu', $this->user->getMessageData()['body'])) {
                $return = $this->addTraining();
            } elseif ($this->scanMsgUser()) {
                if (preg_match('/^(нет)$/iu', $this->user->getMessageData()['body'])) {
                    $this->addAnswer(true);
                    $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][6];
                } elseif (preg_match('/^(!мусор)$/iu', $this->user->getMessageData()['body'])) {
                    $this->delAnswer();
                    $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][9];
                } else {
                    if (mb_strlen($this->user->getMessageData()['body']) > 5) {
                        $this->addAnswer();
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
     * _noAnswer()
     *
     * @param $return
     *
     * @return string
     */
    private function noAnswer($return)
    {
        if (UserConfig::getConfig()['USER_TRAINING']) {
            $this->addQuestion();
            $return = sprintf(
                SustemConfig::getConfig()['MESSAGE']['TextMessage'][1],
                $this->user->getMessageData()['body']
            );
        } elseif ($return && UserConfig::getConfig()['SAVE_TRAINING_FALSE']) {
            $this->addQuestion(true);
            $return = sprintf(
                SustemConfig::getConfig()['MESSAGE']['TextMessage'][3],
                $this->user->getMessageData()['body']
            );
        } elseif (!($return)) {
            $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][0];
        }
        return $return;
    }
}
