<?php

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
namespace joker2620\Source;

use joker2620\Source\API\VKAPI;
use joker2620\Source\Exception\BotError;
use joker2620\Source\ModuleCommand\HTCommands;
use joker2620\Source\ModuleMessage\HTMessages;
use joker2620\Source\Setting\ConfgFeatures;
use joker2620\Source\Setting\ConfigValidation;
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;

/**
 * Class Core
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class Core extends Modules
{
    /**
     * Core constructor.
     */
    public function __construct()
    {
        (new ConfigValidation)->validationConfig();
        $this->addModule(new HTCommands())->addModule(new HTMessages());
    }

    /**
     * @param int         $group_id
     * @param null|string $secret
     */
    public function confirmation(int $group_id, ?string $secret)
    {
        DataOperations::putData(UserConfig::getConfig()['CONFIRMATION_TOKEN']);
        Loger::getInstance()->logger('confirmation send');
    }

    /**
     * @param int         $group_id
     * @param null|string $secret
     * @param array       $object
     */
    public function messageNew(int $group_id, ?string $secret, array $object)
    {
        $users          = VKAPI::getInstance()->usersGet($object['user_id'], true);
        $users          = max($users);
        $object['body'] = BotFunction::getInstance()->filterString($object['body']);
        new User($users, $object);
        $ansver = false;

        foreach ($this->getModule() as $module) {
            $handler = $module->getAnwser();
            if (is_array($handler) | is_string($handler)) {
                $ansver = $handler;
                break;
            }
        }
        $attachments = false;
        if ($ansver) {
            if (is_array($ansver)) {
                $attachments = $ansver[1];
                $message     = $ansver[0];
            } else {
                $message = $ansver;
            }
        } else {
            $message = SustemConfig::getConfig()['MESSAGE']['Main'][0];
        }
        $message = BotFunction::getInstance()->replace($message);
        Loger::getInstance()->message(User::getMessageData()['body'], $message);
        VKAPI::getInstance()->messagesSend(User::getId(), $message, $attachments);
        DataOperations::putData();
    }

    /**
     * Сканер постов
     *
     * @param int         $group_id
     * @param null|string $secret
     * @param array       $object
     *
     * @return void
     * @throws BotError
     */

    public function wallPostNew(int $group_id, ?string $secret, array $object)
    {
        if (!isset($object['attachments'])
            and !isset($object['copy_history'])
        ) {
            $mesage = 'Ты не прикрепил ни одного вложения к посту! Исправь этот недочет!';
        } elseif ($object['text'] == '') {
            $mesage
                = 'Ты не написал ни слова...
             разве тебе нечего сказать?! - Не думаю, напиши хотя-бы пару слов к посту!';
        } elseif ($object['text']) {
            $array  = [
                'Воу воу, это шедевр!',
                'Умничка, у тебя получился хороший пост!',
                'Отлично, все получилось!'
            ];
            $mesage = $array[array_rand($array)];
        } else {
            Loger::getInstance()->logger($object);
            throw new BotError('the secret key does not match or is missing');
        }
        if ($mesage) {
            VKAPI::getInstance()->messagesSend(
                $object['created_by'],
                $mesage,
                [
                    'wall' . $object['owner_id'] . '_' .
                    $object['id']
                ]
            );
        }
        DataOperations::putData();
    }

    /**
     * Сканер опросов
     *
     * @param int         $group_id
     * @param null|string $secret
     * @param array       $object
     *
     * @return void
     */
    public function pollVoteNew(int $group_id, ?string $secret, array $object)
    {
        if (ConfgFeatures::getConfig()['ENABLE_ADMIN_TOKEN']) {
            $data_poll = VKAPI::getInstance()->methodAPI(
                'polls.getById',
                [
                    'access_token' => UserConfig::getConfig()['ADMIN_TOKEN'],
                    'owner_id' => $object['owner_id'],
                    'poll_id' => $object['poll_id']
                ]
            );
            $userdata  = VKAPI::getInstance()->usersGet(
                $object['user_id']
            );
            $userdata  = max($userdata);
            $votes     = 'Не удалось определить';
            foreach ($data_poll['answers'] as $answers) {
                if ($object['option_id'] == $answers['id']) {
                    $votes = $answers['text'];
                    break;
                }
            }
            $message
                = "В опросе: '{$data_poll['question']}', пользователь @id{$object['user_id']} ({$userdata['first_name']} {$userdata['last_name']}), проголосовал за '{$votes}'. Всего голосов в опросе: {$data_poll['votes']}'.";//Опрос
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
