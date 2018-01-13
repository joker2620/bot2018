<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category ModuleMessage
 * @package  Joker2620\Source\Engine\ModuleMessage
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine\ModuleMessage;

use joker2620\Source\Engine\Interfaces\ModuleInterface;
use joker2620\Source\Engine\Setting\SustemConfig;
use joker2620\Source\Engine\Setting\UserConfig;


/**
 * Class HTMessages
 *
 * @category ModuleMessage
 * @package  Joker2620\Source\Engine\ModuleMessage
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
        $return  = false;
        $scaners = ['training', 'prehistoric', 'schooling'];//
        foreach ($scaners as $scaner) {
            if (empty($return)) {
                $scanner = $this->$scaner($item);
                if (!empty($scanner)) {
                    $return = $scanner;
                    break;
                }
            }
        }
        if (empty($return) && UserConfig::getConfig()['USER_TRAINING']) {
            $this->addQuestion($item);
            $return = sprintf(
                SustemConfig::getConfig()['MESSAGE']['TextMessage'][1],
                $item['body']
            );
        } elseif (empty($return) && UserConfig::getConfig()['SAVE_TRAINING_FALSE']) {
            $this->addQuestion($item, true);
            $return = sprintf(
                SustemConfig::getConfig()['MESSAGE']['TextMessage'][3],
                $item['body']
            );
        } elseif (empty($return)) {
            $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][0];
        }
        return [$return, false];
    }
}
