<?php
declare(strict_types = 1);

namespace joker2620\Source\Modules;

use joker2620\Source\Interfaces\ModuleInterface;
use joker2620\Source\ModulesClasses\HTMessagesBase;
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;


/**
 * Class HTMessages
 *
 * @package joker2620\Source\ModuleMessage
 */
class HModuleMessages extends HTMessagesBase implements ModuleInterface
{
    /**
     * getAnwser()
     *
     * @return array
     */
    public function getAnwser(): array
    {
        $return = $this->scanAnswer();
        if (!$return) {
            $return = $this->prehistoric(true);
        }
        if (!$return) {
            $return = $this->prehistoric();
        }
        if (!$return) {
            $return = $this->noAnswer();
        }
        return [$return, false];
    }


    /**
     * scanAnswer()
     *
     * @return bool|string
     */
    private function scanAnswer()
    {
        $return = false;
        if (UserConfig::getConfig()['USER_TRAINING']) {
            if (preg_match(
                '/^(\!' . SustemConfig::getConfig()['MESSAGE']['TextMessage']['toLearn'] . ')$/iu',
                $this->user->getMessageData()['body']
            )) {
                $return = $this->addTraining();
            } elseif ($this->scanMsgUser()) {
                if (preg_match(
                    '/^(' . SustemConfig::getConfig()['MESSAGE']['TextMessage']['not'] . ')$/ui',
                    $this->user->getMessageData()['body']
                )) {
                    $this->addAnswer(true);
                    $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][6];
                } elseif (preg_match(
                    '/^(' . SustemConfig::getConfig()['MESSAGE']['TextMessage']['Clear'] . ')$/ui',
                    $this->user->getMessageData()['body']
                )) {
                    $this->delAnswer();
                    $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][9];
                } else {
                    if (mb_strlen($this->user->getMessageData()['body']) > 5) {
                        $this->addAnswer();
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
     * noAnswer()
     *
     * @return bool|string
     */
    private function noAnswer()
    {
        $return = false;
        if (UserConfig::getConfig()['USER_TRAINING']) {
            $this->addQuestion();
            $return = sprintf(
                SustemConfig::getConfig()['MESSAGE']['TextMessage'][1],
                $this->user->getMessageData()['body']
            );
        } elseif ($return && UserConfig::getConfig()['SAVE_TRAINING_FALSE']) {
            $this->addQuestion(true);
            $return = sprintf(
                SustemConfig::getConfig()['MESSAGE']['TextMessage'][3],
                $this->user->getMessageData()['body']
            );
        } elseif (!($return)) {
            $return = SustemConfig::getConfig()['MESSAGE']['TextMessage'][0];
        }
        return $return;
    }
}
