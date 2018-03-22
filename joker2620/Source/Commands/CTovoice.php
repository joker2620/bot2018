<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Commands;

use joker2620\Source\API\VKAPI;
use joker2620\Source\API\YandexTTS;
use joker2620\Source\ModuleCommand\CommandsTemplate;
use joker2620\Source\Setting\ConfgFeatures;
use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\User;

/**
 * Class CTovoice
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CTovoice extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'молви (.{1,500})';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "молви (текст < 500 символ)" - произнесет сообщение.';
    /**
     * Права доступа
     */
    protected $permission = 0;

    /**
     * Функция для запуска выполнения комманды
     *
     * @param array $matches
     *
     * @return mixed
     *
     */
    public function runCommand(array $matches)
    {
        if (ConfgFeatures::getConfig()['YANDEX_SPEECH']) {
            $messagefilename = YandexTTS::getInstance()->getVoice(
                $matches[1][0],
                'omazh'
            );
            $doccs           = VKAPI::getInstance()->uploadVoice(
                User::getId(),
                $messagefilename
            );
            $return          = [
                $matches[1][0],
                ['doc' . $doccs['owner_id'] . '_' . $doccs['id']]
            ];
        } else {
            $return = SustemConfig::getConfig()['MESSAGE']['TextCommand'][2];
        }
        return $return;
    }
}
