<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\Functions\BotFunction;
use joker2620\Source\Modules\CommandList;
use joker2620\Source\Modules\CommandsTemplate;


/**
 * Class CCommands
 *
 * @package joker2620\Source\Commands
 */
class CCommands extends CommandsTemplate
{

    protected $regexp = 'команды(\s([1-9]||[0-9]{2,})|)';

    protected $display = ' - "команды (страница)" - этот список.';

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
        $page_list    = empty($matches[1][0]) ? 1 : (int)$matches[2][0];
        $admin        = $admin->scanAdm($this->user->getId());
        if ($admin == true) {
            $items = $command_list->getCommandList(3, $page_list);
        } else {
            $items = $command_list->getCommandList(1, $page_list);
        }
        return implode("\n", $items);
    }
}
