<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine;

use joker2620\Source\Engine\Setting\SustemConfig;
use joker2620\Source\Engine\Setting\UserConfig;

/**
 * Class Loger
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class Loger
{
    /**
     * Копия класса
     */
    private static $_instance;

    /**
     * Loger constructor.
     */
    private function __construct()
    {
    }

    /**
     * GetInstance()
     *
     * @return Loger
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Loger();
        }

        return self::$_instance;
    }

    /**
     * Функция logger
     *
     * Функция добавления информации в лог-файл
     *
     * @param mixed $message Сообщение
     *
     * @return Loger
     */
    public function logger($message = false)
    {
        if ($message) {
            if (is_array($message)) {
                $message = json_encode($message, JSON_UNESCAPED_UNICODE);
            }
            $log_file = SustemConfig::getConfig()['DIR_LOG'] .
                '/ErrorLog/log_' . date('j-m-Y') . '.log';
            self::_writeLog($log_file, "{$message}\n");
        }
        return $this;
    }

    /**
     * WriteLog()
     *
     * @param string $file    Файл
     * @param string $message Текст
     *
     * @return void
     */
    private function _writeLog($file, $message)
    {
        $datetime = date('d-m-Y H:i:s');
        $logger   = fopen($file, 'a+');
        fwrite($logger, "[{$datetime}]: " . $message);
        fclose($logger);
    }

    /**
     * Функция message
     *
     * Функция создания логов текстовых сообщений,
     * и группировки их по пользователям.
     *
     * @param int    $uid     Айди пользователя
     * @param string $message Сообщение
     * @param string $answer  Ответ
     *                        бота
     *
     * @return void
     */
    public function message($uid, $message, $answer)
    {
        if (UserConfig::getConfig()['SAVE_MESSAGE']) {
            $message       = BotFunction::getInstance()->filterString($message);
            $answer        = BotFunction::getInstance()->filterString($answer);
            $log_file_chat = SustemConfig::getConfig()['DIR_LOG'] .
                "/chats/chat_id{$uid}.chat";
            self::_writeLog($log_file_chat, "[{$message}]=>[{$answer}]" . "\n");
        }
    }
}
