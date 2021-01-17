<?php

declare(strict_types=1);

namespace joker2620\Source\Commands;

use joker2620\Source\Modules\CommandsTemplate;

/**
 * Class CKurs.
 */
class CKurs extends CommandsTemplate
{
    protected $regexp = 'курс';

    protected $display = ' - "курс" - показывает курс валют.';

    protected $permission = 0;

    /**
     * runCommand().
     *
     * @param array $matches
     *
     * @return string
     */
    public function runCommand(array $matches)
    {
        $filekurs = $this->vkapi->curlGet('http://www.cbr.ru/scripts/XML_daily.asp');
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
            '💵 Доллар $ - '.str_replace(',', '.', $rouble[1]).' 💵',
            '💶 Евро € - '.str_replace(',', '.', $euroc[1]).' 💶',
            '🔰 Гривна - '.str_replace(',', '.', $ukraine[1]).' 🔰',
        ];

        return implode("\n", $message);
    }
}
