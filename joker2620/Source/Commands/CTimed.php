<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;


use joker2620\Source\Modules\CommandsTemplate;


/**
 * Class CTimed
 *
 * @package joker2620\Source\Commands
 */
class CTimed extends CommandsTemplate
{

    protected $regexp = 'время';

    protected $display = ' - "время" - Показывает время.';

    protected $permission = 0;


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return string
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
