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
 * Class CGetvote
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CGetvote extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'Оцени';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "Оацени" - оценит приклепленное вложение.';
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
