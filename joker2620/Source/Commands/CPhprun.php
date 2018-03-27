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
 * Class CPhprun
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CPhprun extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'скомпиль (.{1,3000})';
    /**
     * Отображение команды в списке
     */
    protected $display = 'скомпиль (PHP CODE)" - компилирует программу';
    /**
     * Права доступа
     */
    protected $permission = 1;

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
        ob_start();
        eval($matches[1][0]);
        $message = ob_get_clean();
        return $message;
    }
}
