<?php
declare(strict_types = 1);


namespace nazbav\Source\Modules;

use nazbav\Source\Engine\BotFunction;
use nazbav\Source\Setting\Config;
use nazbav\Source\User\User;


/**
 * Class CommandList
 *
 * @package nazbav\Source\ModuleCommand
 */
class CommandList
{

    private static $commands;
    public         $user;
    public         $botFunction;

    /**
     * CommandList constructor.
     */
    public function __construct()
    {
        $this->user        = new User();
        $this->botFunction = new BotFunction();
    }


    /**
     * getCommandList()
     *
     * @param int $mode
     *
     * @param int $page_list
     *
     * @return array
     */
    public function getCommandList(int $mode, int $page_list = 1): array
    {
        $commans_limit = Config::getConfig()['COMMANDS_LIST_LIMIT'];
        $max_page      = round(count(self::$commands) / $commans_limit);
        $command       = [];
        for ($inter = 0; $inter <= count(self::$commands); $inter++) {
            if ($inter >= $commans_limit) {
                continue;
            } elseif ($page_list > 1 && $inter + $commans_limit) {
                $inter += $commans_limit;
            }
            $commands          = new self::$commands[$inter];
            $items             = $commands->getPermission() ? 2 : 1;
            $command[$items][] = $commands->getDisplay();
        }
        $ucomm  = isset($command[1]) ? array_merge(["--- Команды бота ---\n"], $command[1]) : [];
        $acomm  = isset($command[2]) ? array_merge(
            ["\n---- Команды для администрации ---\n"],
            $command[2]
        ) : [];
        $comman = ["Страница: $page_list из " . $max_page];
        if ($max_page >= $page_list) {
            switch ($mode) {
                case 1:
                    $comman = array_merge($comman, $ucomm);
                    break;
                case 2:
                    $comman = array_merge($comman, $acomm);
                    break;
                case 3:
                    $comman = array_merge($comman, $ucomm, $acomm);
                    break;
            }
        } else {
            $comman = [Config::getConfig()['MESSAGE']['PageNotFound']];
        }
        return $comman;
    }


    protected function loadCommand(): void
    {
        if (self::$commands == null) {
            self::$commands = $this->commands();
        }
    }


    /**
     * commands()
     *
     * @return array
     */
    protected function commands(): array
    {

        $iterator = new \FilesystemIterator("nazbav/Source/Commands");
        $filter   = new \RegexIterator($iterator, '/.*\.php$/');
        $classes  = [];
        foreach ($filter as $entry) {
            $patch     = $entry->getPathName();
            $class     = strtr($patch, ['.php' => '', '/' => '\\']);
            $classes[] = new $class();
        }
        return $classes;
    }


    protected function getCommand()
    {
        return self::$commands;
    }
}
