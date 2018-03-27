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
 * Class CDecode
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CDecode extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'раскодируй (.{1,3000})';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "раскодируй (до 3 тыс. символ)" - раскодирует сообщение.';
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
        $message = base64_decode($matches[1][0]);
        return $message;
    }
}
