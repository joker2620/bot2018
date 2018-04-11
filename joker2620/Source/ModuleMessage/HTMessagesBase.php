<?php
declare(strict_types = 1);

namespace joker2620\Source\ModuleMessage;

use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;


/**
 * Class HTMessagesBase
 *
 * @package joker2620\Source\ModuleMessage
 */
class HTMessagesBase extends TrainingEdit
{
    private $database = [];


    /**
     * prehistoric()
     *
     * @param bool $file_base
     *
     * @return bool
     */
    public function prehistoric(bool $file_base = false)
    {

        $return = false;
        $height = UserConfig::getConfig()['MIN_PERCENT'];
        if ($file_base) {
            $fname     = SustemConfig::getConfig()['FILE_TRAINING'];
            $results   = fopen($fname, 'r+');
            $result    = fread($results, filesize($fname));
            $base_data = json_decode($result, true);
            if ($result) {
                foreach ($base_data as $lines) {
                    $height = $this->scanBase($lines, $height);
                }
                unset($result);
            }
            fclose($results);
        } else {
            $fname  = SustemConfig::getConfig()['FILE_BASE'];
            $result = file(
                $fname,
                FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
            );
            if ($result) {
                foreach ($result as $lines) {
                    $lines  = explode('\\', $lines);
                    $height = $this->scanBase($lines, $height);
                }
                unset($result);
            }
        }
        if ($this->database != []) {
            ksort($this->database);
            $answer = end($this->database);
            $answer = $answer[array_rand($answer)];
            $return = $answer;
        }
        return $return;
    }


    /**
     * scanBase()
     *
     * @param array $lines
     * @param int   $height
     *
     * @return int|mixed
     */
    private function scanBase(array $lines, int $height)
    {
        $height = $this->getHeight($height);
        if (similar_text($this->user->getMessageData()['body'], $lines[0], $percent)) {
            $percent = intval($percent);
            if ($percent >= $height) {
                $this->setDatabase($percent, $lines[1]);
            }
        }

        return $height;
    }


    /**
     * getHeight()
     *
     * @param int $height
     *
     * @return int|mixed
     */
    private function getHeight(int &$height)
    {
        $arraykey = array_keys($this->database);
        sort($arraykey);
        $maxkey = end($arraykey);
        return $height < $maxkey ? $maxkey : $height;
    }


    /**
     * setDatabase()
     *
     * @param int    $per
     * @param string $value
     */
    private function setDatabase(int $per, string $value)
    {
        $this->database[$per][] = $value;
    }
}
