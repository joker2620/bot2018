<?php
declare(strict_types = 1);

namespace joker2620\Source\Engine;

use joker2620\Source\API\VKAPI;
use joker2620\Source\Modules\Modules;
use joker2620\Source\Setting\Config;
use joker2620\Source\Setting\ConfigValidation;
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
        $this->flow->putData(Config::getConfig()['CONFIRMATION_TOKEN']);
        $this->loger->logger('confirmation send');
    }


    /**
     * messageNew()
     *
     * @param int         $group_id
     * @param null|string $secret
     * @param array       $object
     *
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
            $message = Config::getConfig()['MESSAGE']['DefaultMessage'];
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
}
