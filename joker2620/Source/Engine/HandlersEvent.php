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

use joker2620\Source\API\VKAPI;
use joker2620\Source\Engine\ModuleCommand\HTCommands;
use joker2620\Source\Engine\ModuleMessage\HTMessages;
use joker2620\Source\Engine\Setting\ConfgFeatures;
use joker2620\Source\Engine\Setting\SustemConfig;
use joker2620\Source\Engine\Setting\UserConfig;
use joker2620\Source\Exception\BotError;

/**
 * Class HandlersEvent
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class HandlersEvent extends Modules
{
    /**
     * Параметры
     */
    protected $data;
    /**
     * Параметры
     */
    protected $moduleCommand;
    /**
     * Параметры
     */
    protected $moduleMessage;

    /**
     * HandlersEvent constructor.
     *
     * @param bool $test Режим тестирования
     */
    public function __construct($test = false)
    {
        $this->validationConfig();
        $this->data          = DataOperations::getData(
            is_array($test) ? $test : false
        );
        $this->moduleCommand = new HTCommands();
        $this->moduleMessage = new HTMessages();
        $this->addModule($this->moduleCommand)->addModule($this->moduleMessage);
    }

    /**
     * Обработчик подверждения
     *
     * @return void
     */
    protected function handConfirmation()
    {
        DataOperations::putData(UserConfig::getConfig()['CONFIRMATION_TOKEN']);
        Loger::getInstance()->logger('confirmation send');
    }


    /**
     * Сканер сообщений
     *
     * @see \ConfigMessages::MESSAGE Список автоматических сообщений
     *
     * @return void
     * @throws BotError
     */
    protected function handMessage()
    {
        $users                        = VKAPI::getInstance()->usersGet(
            $this->data['object']['user_id']
        );
        $this->data['object']         = array_merge(
            $this->data['object'],
            max($users)
        );
        $this->data['object']['body'] = BotFunction::getInstance()
            ->filterString($this->data['object']['body']);
        $ansver                       = false;
        foreach ($this->getModule() as $module) {
            $handler = $module->getAnwser($this->data['object']);
            if (is_array($handler) | is_string($handler) | is_int($handler)) {
                $ansver = $handler;
                break;
            }
        }
        $attachments = false;
        if (!empty($ansver)) {
            if (is_array($ansver)) {
                $attachments = $ansver[1];
                $message     = $ansver[0];
            } else {
                $message = $ansver;
            }
        } else {
            $message = SustemConfig::getConfig()['MESSAGE']['Main'][0];
        }
        $message = BotFunction::getInstance()->replace(
            $message,
            $this->data['object']
        );
        Loger::getInstance()->message(
            $this->data['object']['user_id'],
            $this->data['object']['body'],
            $message
        );
        VKAPI::getInstance()->messagesSend(
            $this->data['object']['user_id'],
            $message,
            $attachments
        );
        DataOperations::putData();
    }

    /**
     * Сканер постов
     *
     * @return void
     * @throws BotError
     */
    protected function wallPostNew()
    {
        if (!isset($this->data['object']['attachments'])
            and !isset($this->data['object']['copy_history'])
        ) {
            $postx = [
                'wall' . $this->data['object']['owner_id']
                . '_' . $this->data['object']['id']
            ];
            VKAPI::getInstance()->messagesSend(
                $this->data['object']['created_by'],
                'Ты не прикрепил ни одного вложения к посту! Исправь этот недочет!',
                $postx
            );
        } elseif ($this->data['object']['text'] == '') {
            $postx = [
                'wall' . $this->data['object']['owner_id'] . '_' .
                $this->data['object']['id']
            ];
            VKAPI::getInstance()->messagesSend(
                $this->data['object']['created_by'],
                'Ты не написал ни слова... разве тебе нечего сказать?!
                 - Не думаю, напиши хотя-бы пару слов к посту!',
                $postx
            );
        } elseif (!empty($this->data['object']['text'])) {
            $array = [
                'Воу воу, это шедевр!',
                'Умничка, у тебя получился хороший пост!',
                'Отлично, все получилось!'
            ];
            $postx = [
                'wall' . $this->data['object']['owner_id'] .
                '_' . $this->data['object']['id']
            ];
            VKAPI::getInstance()->messagesSend(
                $this->data['object']['created_by'],
                $array[rand(0, count($array) - 1)],
                $postx
            );
        } else {
            Loger::getInstance()->logger($this->data);
            throw new BotError('the secret key does not match or is missing');
        }
        DataOperations::putData();
    }

    /**
     * Сканер опросов
     *
     * @return void
     */
    protected function pollVoteNew()
    {
        if (ConfgFeatures::getConfig()['ENABLE_ADMIN_TOKEN']) {
            $data_poll = VKAPI::getInstance()->methodAPI(
                'polls.getById',
                [
                    'access_token' => UserConfig::getConfig()['ADMIN_TOKEN'],
                    'owner_id' => $this->data['object']['owner_id'],
                    'poll_id' => $this->data['object']['poll_id']
                ]
            );
            $userdata  = VKAPI::getInstance()->usersGet(
                $this->data['object']['user_id']
            );
            $userdata  = max($userdata);
            $votes     = 'Не удалось определить';
            foreach ($data_poll['answers'] as $answers) {
                if ($this->data['object']['option_id'] == $answers['id']) {
                    $votes = $answers['text'];
                    break;
                }
            }
            $message
                = "В опросе: '{$data_poll['question']}', пользователь @id{$this->data['object']['user_id']} ({$userdata['first_name']} {$userdata['last_name']}), проголосовал за '{$votes}'. Всего голосов в опросе: {$data_poll['votes']}'.";//Опрос
            VKAPI::getInstance()->methodAPI(
                'messages.send',
                [
                    'user_ids' => implode(
                        ',',
                        UserConfig::getConfig()['ADMINISTRATORS']
                    ),
                    'message' => $message
                ]
            );
            DataOperations::putData();
        }
    }
}
