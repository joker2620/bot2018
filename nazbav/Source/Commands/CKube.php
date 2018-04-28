<?php
declare(strict_types = 1);

/**
 * Проект: nazbav/bot2018
 * Author: nazbav;
 * PHP version 7.1;
 *
 * @category Commands
 * @package  nazbav\Source\Commands
 * @author   nazbav <joker2000joker@list.ru>
 * @license  https://github.com/nazbav/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/nazbav/bot2018 #VKCHATBOT
 */
namespace nazbav\Source\Commands;

use nazbav\Source\Modules\CommandsTemplate;


/**
 * Class Cball
 *
 * @category Commands
 * @package  nazbav\Source\Commands
 * @author   nazbav <joker2000joker@list.ru>
 * @license  https://github.com/nazbav/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/nazbav/bot2018 #VKCHATBOT
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
            $this->addToBalance($rand_int);
        } else
            $message = 'проиграли';
        return 'Вы загадали ' . $matches[1][0] . ', выпало ' . $rand_int . ', вы ' . $message;
    }

    /**
     * addToBalance()
     *
     * @param int $rand_int
     */
    public function addToBalance(int $rand_int)
    {
        $start = (int)$this->dataBase->read('balance');
        $this->dataBase->write('balance', $rand_int + $start);
    }
}
