<?php
declare(strict_types = 1);

namespace joker2620\Source\Modules;

use joker2620\Source\Interfaces\Modules\ModuleInterface;
use joker2620\Source\Setting\Config;


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
        if (Config::getConfig()['USER_TRAINING']) {
            if (preg_match(
                '/^(' . Config::getConfig()['MESSAGE']['toLearn'] . ')$/iu',
                $this->user->getMessageData()['body']
            )) {
                $return = $this->addTraining();
            } elseif ($this->scanMsgUser()) {
                if (preg_match(
                    '/^(' . Config::getConfig()['MESSAGE']['not'] . ')$/ui',
                    $this->user->getMessageData()['body']
                )) {
                    $this->addAnswer(true);
                    $return = Config::getConfig()['MESSAGE']['AnswerNotGiven'];
                } elseif (preg_match(
                    '/^(' . Config::getConfig()['MESSAGE']['Clear'] . ')$/ui',
                    $this->user->getMessageData()['body']
                )) {
                    $this->delAnswer();
                    $return = Config::getConfig()['MESSAGE']['MessageDeleted'];
                } else {
                    if (mb_strlen($this->user->getMessageData()['body']) > 5) {
                        $this->addAnswer();
                        $return
                            = Config::getConfig()['MESSAGE']['ThanksForAnswer'];
                    } else {
                        $return
                            = Config::getConfig()['MESSAGE']['tooShotAnswer'];
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
        if (Config::getConfig()['USER_TRAINING']) {
            $this->addQuestion();
            $return = sprintf(
                Config::getConfig()['MESSAGE']['IDontKnowHelpMe'],
                $this->user->getMessageData()['body']
            );
        } elseif (!($return)) {
            $return = Config::getConfig()['MESSAGE']['IDontKnowWhatToAnswer'];
        }
        return $return;
    }
}
