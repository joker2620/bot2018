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


use joker2620\Source\ModuleCommand\CommandsTemplate;

/**
 * Class CTimed
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CTimed extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'время';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "время" - Показывает время.';
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
        $return = [
            'Для #first_name_acc# ничего не жалко!',
            'Держи что просил:',
            '---------------',
            'Время: #what_day# #what_time#',
            '---------------',
            'Вы: #first_name# #last_name#',
            'Ваш пол: #sex_dis#',
            'Ваш айди: @id#uid#',
            '---------------',
            "Имя бота: #name_bot#",
            'Автор бота: @joker2620 (Назым Бавбеков)',
            'Версия бота: #version# (сборка #build#)',
        ];
        return implode("\n", $return);
    }
}
