<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;


use joker2620\Source\ModulesClasses\CommandsTemplate;


/**
 * Class CGetvote
 *
 * @package joker2620\Source\Commands
 */
class CGetvote extends CommandsTemplate
{

    protected $regexp = 'Оцени';

    protected $display = ' - "Оацени" - оценит приклепленное вложение.';

    protected $permission = 0;


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return mixed|string
     */
    public function runCommand(array $matches)
    {
        $array = [
            'шикардос', 'кулл',
            'великолепно', 'О боже, как-же это прекрасно, ах какие... Я влюблен!',
            'О боже, как ты вообще такое дерьмо нашел!',
            'Хуже только фото где срут понни',
            'фу бл*ть, как это мерзко', 'дермище'
        ];
        if (isset($this->user->getMessageData()['attachments'])) {
            return $array[array_rand($array)];
        } else {
            return 'Ну "ЗеБеСт" у тебя логика: "оцени то чего нет"...';
        }
    }
}
