<?php
declare(strict_types = 1);
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

use joker2620\Source\ModuleCommand\CommandsTemplate;
use joker2620\Source\Plugins\AutoSing\SignArt;

/**
 * Class CGeneratesing
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CGeneratesing extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'вбумажку (.{1,20})';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "вбумажку (текст < 20 символ)" - создаст сигну.';
    /**
     * Права доступа
     */
    protected $permission = 0;

    /**
     * Функция для запуска выполнения комманды
     *
     * @param $matches
     *
     * @return mixed
     *
     */
    public function runCommand(array $matches)
    {
        $content  = new SignArt();
        $autosign = $content->generate($matches[1][0], [0, 34, 56]);
        $photo    = $this->vkapi->uploadPhoto($this->user->getId(), $autosign);
        $content->imageDestroy($autosign);
        return [
            $matches[1][0], [
                'photo' . $photo['owner_id'] . '_' . $photo['id']
            ]
        ];
    }
}
