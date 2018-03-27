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
 * Class CKurs
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class CKurs extends CommandsTemplate
{
    /**
     * Команда запуска
     */
    protected $regexp = 'курс';
    /**
     * Отображение команды в списке
     */
    protected $display = ' - "курс" - показывает курс валют.';
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
        $filekurs = $this->vkapi
            ->curl('http://www.cbr.ru/scripts/XML_daily.asp');
        preg_match(
            '/\<Valute ID=\"R01235\".*?\>(.*?)\<\/Valute\>/is',
            $filekurs,
            $array
        );
        preg_match('/<Value>(.*?)<\/Value>/is', $array[1], $rouble);
        preg_match(
            '/\<Valute ID=\"R01239\".*?\>(.*?)\<\/Valute\>/is',
            $filekurs,
            $euros
        );
        preg_match('/<Value>(.*?)<\/Value>/is', $euros[1], $euroc);
        preg_match(
            '/\<Valute ID=\"R01720\".*?\>(.*?)\<\/Valute\>/is',
            $filekurs,
            $ukraines
        );
        preg_match('/<Value>(.*?)<\/Value>/is', $ukraines[1], $ukraine);
        $message = [
            '💰Курс валют💰',
            '💵 Доллар $ - ' . str_replace(',', '.', $rouble[1]) . ' 💵',
            '💶 Евро € - ' . str_replace(',', '.', $euroc[1]) . ' 💶',
            '🔰 Гривна - ' . str_replace(',', '.', $ukraine[1]) . ' 🔰'
        ];
        return implode("\n", $message);
    }
}
