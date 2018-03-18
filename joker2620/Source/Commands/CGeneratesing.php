<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 7.1;
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Commands;

use joker2620\Source\API\VKAPI;
use joker2620\Source\ModuleCommand\CommandsTemplate;
use joker2620\Source\Plugins\AutoSing\SignArt;

/**
 * Class CGeneratesing
 *
 * @category Commands
 * @package  Joker2620\Source\Commands
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class CGeneratesing extends CommandsTemplate
{
    /**
     * Функция для запуска выполнения комманды
     *
     * @param array $item Данные пользователя.
     *
     * @return mixed
     */
    public function runCom($item)
    {
        $content  = new SignArt();
        $autosing = $content->generate($item['matches'][2][0], [0, 34, 56]);
        $photo    = VKAPI::getInstance()->uploadPhoto($item['user_id'], $autosing);
        $content->imageDestroy($autosing);
        return [
            $item['matches'][2][0], [
                'photo' . $photo['owner_id'] . '_' . $photo['id']
            ]
        ];
    }
}
