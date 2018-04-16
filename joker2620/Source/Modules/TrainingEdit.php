<?php
declare(strict_types = 1);

namespace joker2620\Source\Modules;

use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\User\User;
use MrKody\JsonDb\JsonDb;


/**
 * Class TrainingEdit
 *
 * @package joker2620\Source\ModuleMessage
 */
class TrainingEdit
{
    const FALSE = 'false';
    public  $user;
    private $baseName;
    private $jsonBD;

    /**
     * TrainingEdit constructor.
     */
    public function __construct()
    {
        $this->baseName = SustemConfig::getConfig()['FILE_TRAINING'];
        $this->jsonBD   = new JsonDb();
        //question answer training author
        $this->jsonBD->from($this->baseName);
        $this->user = new User();
    }

    /**
     * addAnswer()
     *
     * @param bool $no
     */
    protected function addAnswer(bool $no = false)
    {
        $no = $this->replLogic($no);
        //question answer training author
        $select = $this->jsonBD->select('question, answer, training')->where(
            [
                'answer' => self::FALSE,
                'training' => $this->user->getId()
            ],
            'AND'
        )->get();
        if (!empty($select) && $select[0]['answer'] == self::FALSE && $select[0]['training'] == $this->user->getId()) {
            //question answer training author
            $this->jsonBD->update(
                [
                    'training' => self::FALSE,
                    'answer' => $no == self::FALSE ? $this->user->getMessageData()['body'] : self::FALSE,
                ]
            )
                ->where(['answer' => self::FALSE, 'training' => $this->user->getId()], 'AND')
                ->trigger();
        }
    }

    /**
     * replLogic()
     *
     * @param bool $bool
     *
     * @return string
     */
    function replLogic(bool $bool)
    {
        $return = self::FALSE;
        switch ($bool) {
            case true:
                $return = 'true';
                break;
            case false:
                $return = 'false';
                break;
        }
        return $return;
    }

    /**
     * delAnswer()
     *
     */
    protected function delAnswer()
    {
        //question answer training author
        $this->jsonBD->delete()->where(
            [
                'answer' => self::FALSE,
                'training' => $this->user->getId()
            ],
            'AND'
        )->trigger();
    }

    /**
     * addTraining()
     *
     * @return string
     */
    protected function addTraining()
    {
        $message = SustemConfig::getConfig()['MESSAGE']['HereIsEmpty'];
        $select  = $this->jsonBD->select('question, answer, training')->where(
            [
                'answer' => self::FALSE,
                'training' => self::FALSE
            ],
            'AND'
        )->get();
        if (!empty($select[0]) && $select[0]['answer'] == self::FALSE && $select[0]['training'] == self::FALSE) {
            //question answer training author
            $this->jsonBD->update(['training' => $this->user->getId()])
                ->where(['answer' => self::FALSE, 'training' => self::FALSE], 'AND')
                ->trigger();
            $message = sprintf(
                SustemConfig::getConfig()['MESSAGE']['HelpAnswer'],
                $select[0]['question']
            );
        }
        return $message;
    }

    /**
     * addQuestion()
     *
     * @param bool $no
     */
    protected function addQuestion(
        bool $no = false
    ) {
        $no      = $this->replLogic($no);
        $replace = $this->jsonBD->select('question')
            ->where(['question' => $this->user->getMessageData()['body']])
            ->get();
        if (!$replace) {
            $this->jsonBD->insert(
                $this->baseName,
                [//question answer training author
                    'question' => $this->user->getMessageData()['body'],
                    'answer' => self::FALSE,
                    'training' => $no == self::FALSE ? $this->user->getId() : self::FALSE,
                    'author' => $this->user->getId()
                ]
            );
        }
    }

    /**
     * uniqueMultiArray()
     *
     * @param array $array
     * @param int   $key
     *
     * @return array
     */
    protected function uniqueMultiArray(
        array $array, int $key
    ) {
        $temp_array = [];
        if (is_array($array)) {
            $inter     = 0;
            $key_array = [];

            foreach ($array as $value) {
                if (!in_array($value[$key], $key_array)) {
                    $key_array[$inter]  = $value[$key];
                    $temp_array[$inter] = $value;
                }
                $inter++;
            }
        }
        return $temp_array;
    }


    /**
     * scanMsgUser()
     *
     * @return bool
     */
    protected function scanMsgUser()
    {
        return !empty(
        $this->jsonBD->select('*')
            ->where(['training' => $this->user->getId()])
            ->get()
        );
    }
}
