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

/**
 * Class CSovet
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CSovet extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'совет';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "совет" - дает совет.';
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
        $jsondata = json_decode(
            $this->vkapi
                ->curl('http://fucking-great-advice.ru/api/random'),
            true
        );
        return strip_tags(strtr($jsondata['text'], ['&nbsp;' => ' ']));
    }
}
