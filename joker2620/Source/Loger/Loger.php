<?php
declare(strict_types = 1);
/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Loger;

use joker2620\Source\Functions\BotFunction;
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;
use joker2620\Source\User\User;

/**
 * Class Loger
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class Loger
{
    private $botFunction;
    private $userData;

    /**
     * Loger constructor.
     */
    public function __construct()
    {
        $this->botFunction = new BotFunction();
        $this->userData    = new User();
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
            self::writeLog($log_file, "{$message}\n");
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
    private function writeLog($file, $message)
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
     * @param string $message Сообщение
     * @param string $answer  Ответ
     *                        бота
     *
     * @return void
     */
    public function message($message, $answer)
    {
        if (UserConfig::getConfig()['SAVE_MESSAGE']) {
            $message       = $this->botFunction->filterString($message);
            $answer        = $this->botFunction->filterString($answer);
            $userid        = $this->userData->getId();
            $log_file_chat = SustemConfig::getConfig()['DIR_LOG'] .
                "/chats/chat_id{$userid}.chat";
            self::writeLog($log_file_chat, "[{$message}]=>[{$answer}]" . "\n");
        }
    }
}
