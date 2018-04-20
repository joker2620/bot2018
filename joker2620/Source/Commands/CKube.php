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
class CKube extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'куб ([1-6]|случ)';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "куб (число)" - бросит кость.';
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
        if ($matches[1][0] == "случ")
            $matches[1][0] = rand(1, 6);
        $rand_int = rand(1, 6);
        if ($matches[1][0] == $rand_int) {
            $message = "выиграли. \nЗа победу вам зачислено: " . $rand_int;
            $this->dataBase->write('balance', $rand_int);
        } else
            $message = 'проиграли';
        return 'Вы загадали ' . $matches[1][0] . ', выпало ' . $rand_int . ', вы ' . $message;
    }
}
