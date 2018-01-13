<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category ModuleCommand
 * @package  Joker2620\Source\Engine\ModuleCommand
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Engine\ModuleCommand;

use joker2620\Source\Engine\BotFunction;
use joker2620\Source\Engine\Interfaces\ModuleInterface;
use joker2620\Source\Engine\Setting\SustemConfig;

/**
 * Class HTCommands
 *
 * @category ModuleCommand
 * @package  Joker2620\Source\Engine\ModuleCommand
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class HTCommands extends CommandList implements ModuleInterface
{
    /**
     * Функция поиска команды
     *
     * В случай если сообщение попадет под регулярное выражение,
     * будет активирована соответствующая команда.
     *
     * @param array $item Данные пользователя.
     *
     * @return array|bool
     */
    public function getAnwser($item)
    {
        $ansver = false;
        $this->loadCommand();
        $commands = $this->getCommand();
        if (is_array($commands)) {
            foreach ($commands as $value) {
                if (preg_match(
                    '/^' . $value[0] . '$/iu',
                    $item['body'], $matches, PREG_OFFSET_CAPTURE, 0
                )
                ) {
                    if (!BotFunction::getInstance()->scanAdm($item['user_id'])
                        && $value[2] == 1
                    ) {
                        return
                            SustemConfig::getConfig()['MESSAGE']['TextCommand'][1];
                    }
                    $userdata = $item + ['matches' => $matches];
                    $ansver   = $value[1]->runCom($userdata);
                }
            }
        }
        return $ansver;
    }
}
