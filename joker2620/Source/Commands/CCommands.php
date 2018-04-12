<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\Functions\BotFunction;
use joker2620\Source\ModulesClasses\CommandList;
use joker2620\Source\ModulesClasses\CommandsTemplate;


/**
 * Class CCommands
 *
 * @package joker2620\Source\Commands
 */
class CCommands extends CommandsTemplate
{

    protected $regexp = 'команды';

    protected $display = ' - "команды" - этот список.';

    protected $permission = 0;


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return string
     */
    public function runCommand(array $matches)
    {

        $command_list = new CommandList();
        $admin        = new BotFunction();

        $admin = $admin->scanAdm($this->user->getId());
        if ($admin == true) {
            $items = $command_list->getCommandList(2);
        } else {
            $items = $command_list->getCommandList(0);
        }
        return implode("\n", $items);
    }
}
