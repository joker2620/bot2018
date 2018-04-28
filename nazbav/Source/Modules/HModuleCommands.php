<?php
declare(strict_types = 1);

namespace nazbav\Source\Modules;

use nazbav\Source\Interfaces\Modules\ModuleInterface;
use nazbav\Source\Setting\Config;


/**
 * Class HTCommands
 *
 * @package nazbav\Source\ModuleCommand
 */
class HModuleCommands extends CommandList implements ModuleInterface

{


    /**
     * getAnwser()
     *
     * @return bool
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
                            Config::getConfig()['MESSAGE']['TextCommand'][1];
                    }
                    $ansver = $command->runCommand($matches);
                }
            }
        }
        return $ansver;

    }
}
