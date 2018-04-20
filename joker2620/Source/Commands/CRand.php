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

use joker2620\Source\Modules\CommandsTemplate;


/**
 * Class Cball
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CRand extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'ранд ([0-9]{1,}) ([0-9]{1,}|случ)';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "ранд (от) (число до или \'случ\')" - случайное число..';
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
     */
    public function runCommand(array $matches)
    {
        if ($matches[2][0] == "случ")
            $matches[2][0] = rand(1, 1000000);
        if ($matches[1][0] < $matches[2][0]) {
            $rand_int = "Число: " . rand((int)$matches[1][0], (int)$matches[2][0]);
        } else $rand_int = 'Не реально';
        return $rand_int;
    }
}
