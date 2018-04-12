<?php
declare(strict_types = 1);

namespace joker2620\Source\Modules;

use joker2620\Source\Interfaces\ModuleInterface;
use joker2620\Source\ModulesClasses\CommandList;
use joker2620\Source\Setting\SustemConfig;


/**
 * Class HTCommands
 *
 * @package joker2620\Source\ModuleCommand
 */
class HModuleCommands extends CommandList implements ModuleInterface

{


    /**
     * getAnwser()
     *
     * @return bool
     */
    public
    function getAnwser()
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
