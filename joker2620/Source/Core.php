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
namespace joker2620\Source;

use joker2620\Source\API\VKAPI;
use joker2620\Source\DataFlow\DataFlow;
use joker2620\Source\Exception\BotError;
use joker2620\Source\Functions\BotFunction;
use joker2620\Source\Loger\Loger;
use joker2620\Source\ModuleCommand\HTCommands;
use joker2620\Source\ModuleMessage\HTMessages;
use joker2620\Source\Modules\Modules;
use joker2620\Source\Setting\ConfgFeatures;
use joker2620\Source\Setting\ConfigValidation;
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;
use joker2620\Source\User\User;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;

/**
 * Class Core
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class Core extends VKCallbackApiServerHandler
{
    private $userData;
    private $modules;
    private $flow;
    private $loger;
    private $vkapi;
    private $botFunctions;

    /**
     * Core constructor.
     */
    public function __construct()
    {
        $this->botFunctions = new BotFunction();
        $this->flow         = new DataFlow();
        $this->vkapi        = new VKAPI();
        $this->modules      = new Modules();
        $this->userData     = new User();
        $this->loger        = new Loger();
        $config_valid       = new ConfigValidation();
        $module_commands    = new HTCommands();
        $module_messages    = new HTMessages();

        $config_valid->validationConfig();
        $this->modules->addModule($module_commands)->addModule($module_messages);
    }

    /**
     * @param int         $group_id
     * @param null|string $secret
     */
    public function confirmation(int $group_id, ?string $secret)
    {
        $this->flow->putData(UserConfig::getConfig()['CONFIRMATION_TOKEN']);
        $this->loger->logger('confirmation send');
    }

    /**
     * @param int         $group_id
     * @param null|string $secret
     * @param array       $object
     */
    public function messageNew(int $group_id, ?string $secret, array $object)
    {

        $users          = $this->vkapi->usersGet($object['user_id'], true);
        $users          = max($users);
        $object['body'] = $this->botFunctions->filterString($object['body']);
        $this->userData->setUserData($users, $object);
        $ansver = false;

        foreach ($this->modules->getModule() as $module) {
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
        $message = $this->botFunctions->replace($message);
        $this->loger->message($this->userData->getMessageData()['body'], $message);
        $this->vkapi->messagesSend($this->userData->getId(), $message, $attachments);
        $this->flow->putData();
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
            $this->loger->logger($object);
            throw new BotError('the secret key does not match or is missing');
        }
        if ($mesage) {
            $this->vkapi->messagesSend(
                $object['created_by'],
                $mesage,
                [
                    'wall' . $object['owner_id'] . '_' .
                    $object['id']
                ]
            );
        }
        $this->flow->putData();
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
            $data_poll = $this->vkapi->methodAPI(
                'polls.getById',
                [
                    'access_token' => UserConfig::getConfig()['ADMIN_TOKEN'],
                    'owner_id' => $object['owner_id'],
                    'poll_id' => $object['poll_id']
                ]
            );
            $userdata  = $this->vkapi->usersGet(
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
            $this->vkapi->methodAPI(
                'messages.send',
                [
                    'user_ids' => implode(
                        ',',
                        UserConfig::getConfig()['ADMINISTRATORS']
                    ),
                    'message' => $message
                ]
            );
            $this->flow->putData();
        }
    }

}
