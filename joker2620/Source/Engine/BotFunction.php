<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine;

use joker2620\Source\Engine\Setting\SustemConfig;
use joker2620\Source\Engine\Setting\UserConfig;

/**
 * Class BotFunction
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class BotFunction
{
    /**
     * Копия класса
     */
    private static $instance;

    /**
     * BotFunction constructor.
     */
    private function __construct()
    {
    }

    /**
     * GetInstance()
     *
     * @return BotFunction
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new BotFunction();
        }

        return self::$instance;
    }

    /**
     * Слияние строк
     *
     * @param string $string Строка для очитски от переносов
     *
     * @return string
     */
    public function filterString($string)
    {
        return strtr($string, ["\n" => '']);
    }

    /**
     * Функция замены специальных тегов на соответствующую информацию
     *
     * @param string $message   Строка сообщения
     * @param int    $user_data Данные пользователя
     *
     * @see \ConfigCore::BOT_NAME Имя бота
     * @see \ConfigCore::VERSION Версия бота
     * @see \ConfigCore::BUILD Сборка бота
     *
     * @return string
     */
    public function replace($message, $user_data)
    {
        switch ($user_data['sex']) {
            case '1':
                $sex_description = 'девушка';
                break;
            case '2':
                $sex_description = 'парень';
                break;
            default:
                $sex_description = 'WTF?';
                break;
        }

        $trans = [
            '#uid#' => $user_data['user_id'],
            '#name_one#' => $user_data['first_name'],
            '#name_two#' => $user_data['last_name'],
            '#sex#' => $user_data['sex'],
            '#sex_dis#' => $sex_description,
            '#neme_bot#' => UserConfig::getConfig()['BOT_NAME'],
            '#version#' => SustemConfig::getConfig()['VERSION'],
            '#build#' => SustemConfig::getConfig()['BUILD']
        ];
        return strtr($message, $trans);
    }

    /**
     * Функция перевода символов в нижний регистр
     *
     * @param string $string Строка
     *
     * @return string
     */
    public function lower(
        $string
    ) {
        $chars  = [
            'A' => 'a', 'B' => 'b', 'C' => 'c', 'D' => 'd',
            'E' => 'e', 'F' => 'f', 'G' => 'g',
            'H' => 'h', 'I' => 'i', 'J' => 'j', 'K' => 'k',
            'L' => 'l', 'M' => 'm', 'N' => 'n',
            'O' => 'o', 'P' => 'p', 'Q' => 'q', 'R' => 'r',
            'S' => 's', 'T' => 't', 'U' => 'u',
            'V' => 'v', 'W' => 'w', 'X' => 'x', 'Y' => 'y',
            'Z' => 'z', 'А' => 'а', 'Б' => 'б',
            'В' => 'в', 'Г' => 'г', 'Д' => 'д', 'Е' => 'е',
            'Ё' => 'ё', 'Ж' => 'ж', 'З' => 'з',
            'И' => 'и', 'Й' => 'й', 'К' => 'к', 'Л' => 'л',
            'М' => 'м', 'Н' => 'н', 'О' => 'о',
            'П' => 'п', 'Р' => 'р', 'С' => 'с', 'Т' => 'т',
            'У' => 'у', 'Ф' => 'ф', 'Х' => 'х',
            'Ц' => 'ц', 'Ч' => 'ч', 'Ш' => 'ш', 'Щ' => 'щ',
            'Ъ' => 'ъ', 'Ы' => 'ы', 'Ь' => 'ь',
            'Э' => 'э', 'Ю' => 'ю', 'Я' => 'я'
        ];
        $string = strtr($string, $chars);
        return $string;
    }

    /**
     * Функция проверки прав
     *
     * Проверяет являеться ли пользователь администратором бота.
     *
     * @param int $uid Айди пользователя
     *
     * @see ConfigCore::ADMINISTRATORS Список администраторов бота
     *
     * @return bool
     */
    public function scanAdm($uid)
    {
        return array_search(
            $uid,
            UserConfig::getConfig()['ADMINISTRATORS']
        ) !== false ? true : false;
    }

    /**
     * UcFirst()
     *
     * Делает первую букву заглавной.
     *
     * @param string $string Строка
     *
     * @return string
     */
    public function ucFirst($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }
}
