<?php
declare(strict_types = 1);
/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category ModuleCommand
 * @package  Joker2620\Source\ModuleCommand
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\ModuleCommand;

use joker2620\Source\Interfaces\ModuleInterface;
use joker2620\Source\Setting\SustemConfig;

/**
 * Class HTCommands
 *
 * @category ModuleCommand
 * @package  Joker2620\Source\ModuleCommand
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class HTCommands extends CommandList implements ModuleInterface
{
    /**
     * Функция поиска команды
     *
     * В случай если сообщение попадет под регулярное выражение,
     * будет активирована соответствующая команда.
     *
     * @return array|bool
     *
     */
    public function getAnwser()
    {
        $ansver = false;
        $this->loadCommand();
        $commands = $this->getCommand();
        if (is_array($commands)) {
            foreach ($commands as $value) {
                $command = new $value;
                if (preg_match(
                    '/^' . $command->getRegexp() . '$/iu',
                    $this->user->getMessageData()['body'],
                    $matches,
                    PREG_OFFSET_CAPTURE,
                    0
                )
                ) {
                    if (!$this->botFunction->scanAdm($this->user->getId())
                        && $command->getPermission() == 1
                    ) {
                        return
                            SustemConfig::getConfig()['MESSAGE']['TextCommand'][1];
                    }
                    $ansver = $command->runCommand($matches);
                }
            }
        }
        return $ansver;

    }
}
