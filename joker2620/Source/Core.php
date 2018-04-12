<?php
declare(strict_types = 1);

namespace joker2620\Source;

use joker2620\Source\API\VKAPI;
use joker2620\Source\DataFlow\DataFlow;
use joker2620\Source\Exception\BotError;
use joker2620\Source\Functions\BotFunction;
use joker2620\Source\Loger\Loger;
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
 * @package joker2620\Source
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
        $config_valid->validationConfig();
        $this->modules->loadModules();
    }


    /**
     * confirmation()
     *
     * @param int         $group_id
     * @param null|string $secret
     */
    public function confirmation(int $group_id, ?string $secret)
    {
        $this->flow->putData(UserConfig::getConfig()['CONFIRMATION_TOKEN']);
        $this->loger->logger('confirmation send');
    }


    /**
     * messageNew()
     *
     * @param int         $group_id
     * @param null|string $secret
     * @param array       $object
     */
    public function messageNew(int $group_id, ?string $secret, array $object)
    {

        $users          = $this->vkapi->usersGet($object['user_id']);
        $users          = max($users);
        $object['body'] = $this->botFunctions->filterString($object['body']);
        $this->userData->setUserData($users, $object);
        $answer = false;
        foreach ($this->modules->getModule() as $module) {
            $handler = $module->getAnwser();
            if (is_array($handler) | is_string($handler)) {
                $answer = $handler;
                break;
            }
        }
        $attachments = false;
        if (empty($answer)) {
            $message = SustemConfig::getConfig()['MESSAGE']['Main'][0];
        } elseif (is_array($answer)) {
            $attachments = $answer[1];
            $message     = $answer[0];
        } else {
            $message = $answer;
        }
        $message = $this->botFunctions->replace($message);
        $this->loger->message($this->userData->getMessageData()['body'], $message);
        $this->vkapi->messagesSend($this->userData->getId(), $message, $attachments);
        $this->flow->putData();
    }


    /**
     * wallPostNew()
     *
     * @param int         $group_id
     * @param null|string $secret
     * @param array       $object
     *
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
     * pollVoteNew()
     *
     * @param int         $group_id
     * @param null|string $secret
     * @param array       $object
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
                $object['user_id'], []
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
                = "В опросе: '{$data_poll['question']}', пользователь @id{$object['user_id']} ({$userdata['first_name']} {$userdata['last_name']}), проголосовал за '{$votes}'. Всего голосов в опросе: {$data_poll['votes']}'.";
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
