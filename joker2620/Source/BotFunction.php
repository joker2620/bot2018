<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source;

use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;

/**
 * Class BotFunction
 *
 * @category Engine
 * @package  Joker2620\Source
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class BotFunction
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
     * Можно использовать падеж для склонения имени и фамилии пользователя.
     * Используется как приставка в теге, пример: #first_name_gen#
     * Возможные значения:
     * именительный – по умолчанию,
     * родительный – "_gen",
     * дательный – "_dat",
     * винительный – "_acc",
     * творительный – "_ins",
     * предложный – "_abl".
     *
     * @param string $message Строка сообщения
     *
     * @return string
     *
     * @see      \ConfigCore::BOT_NAME Имя бота
     * @see      \ConfigCore::VERSION Версия бота
     * @see      \ConfigCore::BUILD Сборка бота
     *
     */
    public function replace($message)
    {
        $user_data = User::getInfo();
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
            '#uid#' => User::getId(),
            '#first_name#' => User::getFirstName(),
            '#last_name#' => User::getLastName(),
            //Склонение имени
            '#first_name_abl#' => $user_data['first_name_abl'],
            '#first_name_ins#' => $user_data['first_name_ins'],
            '#first_name_acc#' => $user_data['first_name_acc'],
            '#first_name_dat#' => $user_data['first_name_dat'],
            '#first_name_gen#' => $user_data['first_name_gen'],
            //Склонение фамилии
            '#last_name_abl#' => $user_data['last_name_abl'],
            '#last_name_ins#' => $user_data['last_name_ins'],
            '#last_name_acc#' => $user_data['last_name_acc'],
            '#last_name_dat#' => $user_data['last_name_dat'],
            '#last_name_gen#' => $user_data['last_name_gen'],

            '#sex_dis#' => $sex_description,
            '#name_bot#' => UserConfig::getConfig()['BOT_NAME'],
            '#what_day#' => date('d.m.Y'),
            '#what_time#' => date('H:i:s'),
            '#version#' => SustemConfig::getConfig()['VERSION'],
            '#build#' => SustemConfig::getConfig()['BUILD']
        ];
        return strtr($message, $trans);
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

    /**
     * buildPath()
     *
     * @param array ...$segments
     *
     * @return string
     */
    public function buildPath(...$segments)
    {
        return join(DIRECTORY_SEPARATOR, $segments);
    }
}
