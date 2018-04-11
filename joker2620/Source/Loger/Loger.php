<?php
declare(strict_types = 1);

namespace joker2620\Source\Loger;

use joker2620\Source\Functions\BotFunction;
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;
use joker2620\Source\User\User;


/**
 * Class Loger
 *
 * @package joker2620\Source\Loger
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
     * logger()
     *
     * @param $message
     *
     * @return $this
     */
    public function logger($message)
    {
        if (is_array($message)) {
            $message = json_encode($message, JSON_UNESCAPED_UNICODE);
        }
        $log_file = SustemConfig::getConfig()['DIR_LOG'] .
            '/ErrorLog/log_' . date('j-m-Y') . '.log';
        self::writeLog($log_file, "{$message}\n");
        return $this;
    }


    /**
     * writeLog()
     *
     * @param string $file
     * @param string $message
     */
    private function writeLog(string $file, string $message)
    {
        $datetime = date('d-m-Y H:i:s');
        $logger   = fopen($file, 'a+');
        fwrite($logger, "[{$datetime}]: " . $message);
        fclose($logger);
    }


    /**
     * message()
     *
     * @param string $message
     * @param string $answer
     */
    public function message(string $message, string $answer)
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
