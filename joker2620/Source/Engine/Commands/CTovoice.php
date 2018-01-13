<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Commands
 * @package  Joker2620SourceEngineCommands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine\Commands;


use joker2620\Source\API\VKAPI;
use joker2620\Source\API\YandexTTS;
use joker2620\Source\Engine\Interfaces\CommandIntefce;
use joker2620\Source\Engine\ModuleCommand\CommandsTemplate;
use joker2620\Source\Engine\Setting\ConfgFeatures;
use joker2620\Source\Engine\Setting\SustemConfig;

/**
 * Class CTovoice
 *
 * @category Commands
 * @package  Joker2620SourceEngineCommands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class CTovoice extends CommandsTemplate implements CommandIntefce
{
    /**
     * CTovoice constructor.
     */
    public function __construct()
    {
    }

    /**
     * Функция для запуска выполнения комманды
     *
     * @param array $item Данные пользователя.
     *
     * @return mixed
     */
    public function runCom($item)
    {
        if (ConfgFeatures::getConfig()['YANDEX_SPEECH']) {
            $messagefilename = YandexTTS::getInstance()->getVoice(
                $item['matches'][2][0],
                'omazh'
            );
            $doccs           = VKAPI::getInstance()->uploadVoice(
                $item['user_id'],
                $messagefilename
            );
            $return          = [
                $item['matches'][2][0],
                ['doc' . $doccs['owner_id'] . '_' . $doccs['id']]
            ];
        } else {
            $return = SustemConfig::getConfig()['MESSAGE']['TextCommand'][2];
        }
        return $return;
    }
}
