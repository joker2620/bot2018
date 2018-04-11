<?php
declare(strict_types = 1);

namespace joker2620\Source\Functions;

use joker2620\Source\Setting\SustemConfig;
use joker2620\Source\Setting\UserConfig;
use joker2620\Source\User\User;


/**
 * Class BotFunction
 *
 * @package joker2620\Source\Functions
 */
class BotFunction
{
    private $user;


    /**
     * BotFunction constructor.
     */
    public function __construct()
    {
        $this->user = new User();
    }


    /**
     * filterString()
     *
     * @param string $string
     *
     * @return string
     */
    public function filterString(string $string)
    {
        return strtr($string, ["\n" => '']);
    }


    /**
     * replace()
     *
     * @param string $message
     *
     * @return string
     */
    public function replace(string $message)
    {
        $user_data = $this->user->getInfo();
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
            '#uid#' => $this->user->getId(),
            '#first_name#' => $this->user->getFirstName(),
            '#last_name#' => $this->user->getLastName(),

            '#first_name_abl#' => $user_data['first_name_abl'],
            '#first_name_ins#' => $user_data['first_name_ins'],
            '#first_name_acc#' => $user_data['first_name_acc'],
            '#first_name_dat#' => $user_data['first_name_dat'],
            '#first_name_gen#' => $user_data['first_name_gen'],

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
     * scanAdm()
     *
     * @param int $uid
     *
     * @return bool
     */
    public function scanAdm(int $uid)
    {
        return array_search(
            $uid,
            UserConfig::getConfig()['ADMINISTRATORS']
        ) !== false ? true : false;
    }


    /**
     * ucFirst()
     *
     * @param string $string
     *
     * @return string
     */
    public function ucFirst(string $string)
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
