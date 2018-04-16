<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\Modules\CommandsTemplate;


/**
 * Class Cball
 *
 * @package joker2620\Source\Commands
 */
class Cball extends CommandsTemplate
{

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

    protected $regexp = 'шар (.{1,})';

    protected $display = ' - "шар (вопрос)" - даст предсказание.';

    protected $permission = 0;


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return mixed
     */
    public function runCommand(array $matches)
    {
        return $this->ansver[array_rand($this->ansver)];
    }
}
