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
 * Class Cball
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class Cball extends CommandsTemplate
{
    /**
     * База ответов бота
     *
     * Из них выбираеться случайный м отправляеться
     */
    public $ansver
        = [
            'Бесспорно',
            'Предрешено',
            'Никаких сомнений',
            'Определённо да',
            'Можешь быть уверен в этом',

            'Мне кажется — «да»',
            'Вероятнее всего',
            'Хорошие перспективы',
            'Знаки говорят — «да»',
            'Да',

            'Пока не ясно, попробуй снова',
            'Спроси позже',
            'Лучше не рассказывать',
            'Сейчас нельзя предсказать',
            'Сконцентрируйся и спроси опять',

            'Даже не думай',
            'Мой ответ — «нет»',
            'По моим данным — «нет»',
            'Перспективы не очень хорошие',
            'Весьма сомнительно'
        ];
    /**
     * Команда запуска
     */
    protected $regexp = 'шар (.{1,})';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "шар (вопрос)" - даст предсказание.';
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
        return $this->ansver[array_rand($this->ansver)];
    }
}
