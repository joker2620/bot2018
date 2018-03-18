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
final class HTMessages extends HTMessagesBase implements ModuleInterface
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
     * @param array $item Данные пользователя.
     *
     * @return bool|string
     */
    public function getAnwser($item)
    {
        $return = $this->scanAnswer($item);
        if (!$return) {
            $return = $this->prehistoric($item, true);
        }
        elseif (!$return) {
            $return = $this->prehistoric($item);
        }
        elseif (!$return) {
            $return = $this->noAnswer($return, $item);
        }
        return [$return, false];
    }


    /**
     * _noAnswer()
     *
     * @param $item
     *
     * @return string
     */
    private function scanAnswer($item)
    {
        $return = false;
        if (UserConfig::getConfig()['USER_TRAINING']) {
            if (preg_match('/^(\!наобучение)$/iu', $item['body'])) {
                $return = $this->addTraining($item);
            } elseif ($this->scanMsgUser($item)) {
                if (preg_match('/^(нет)$/iu', $item['body'])) {
                    $this->addAnswer($item, true);
                    $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][6];
                } elseif (preg_match('/^(!мусор)$/iu', $item['body'])) {
                    $this->delAnswer($item);
                    $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][9];
                } else {
                    if (mb_strlen($item['body']) > 5) {
                        $this->addAnswer($item);
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
     * @param $item
     *
     * @return string
     */
    private function noAnswer($return, $item)
    {
        if (UserConfig::getConfig()['USER_TRAINING']) {
            $this->addQuestion($item);
            $return = sprintf(
                SustemConfig::getConfig()['MESSAGE']['TextMessage'][1],
                $item['body']
            );
        } elseif ($return && UserConfig::getConfig()['SAVE_TRAINING_FALSE']) {
            $this->addQuestion($item, true);
            $return = sprintf(
                SustemConfig::getConfig()['MESSAGE']['TextMessage'][3],
                $item['body']
            );
        } elseif (!($return)) {
            $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][0];
        }
        return $return;
    }
}
