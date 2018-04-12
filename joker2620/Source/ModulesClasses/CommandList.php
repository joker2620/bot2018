<?php
declare(strict_types = 1);


namespace joker2620\Source\ModulesClasses;

use joker2620\Source\Functions\BotFunction;
use joker2620\Source\User\User;


/**
 * Class CommandList
 *
 * @package joker2620\Source\ModuleCommand
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
     * @return array
     */
    public function getCommandList(int $mode): array
    {

        $command = [];
        foreach (self::$commands as $commands) {
            $commands                                   = new $commands;
            $command[$commands->getPermission() ?: 0][] = $commands->getDisplay();
        }
        $ucomm = array_merge(["--- Команды бота ---\n"], $command[0]);
        $acomm = array_merge(
            ["\n---- Команды для администрации ---\n"],
            $command[1]
        );
        switch ($mode) {
            case 0:
                $command = $ucomm;
                break;
            case 1:
                $command = $acomm;
                break;
            case 2:
                $command = array_merge($ucomm, $acomm);
                break;
        }
        return $command;
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

        $iterator = new \FilesystemIterator("joker2620/Source/Commands");
        $filter   = new \RegexIterator($iterator, '/.*\.php$/');
        $classes  = [];
        foreach ($filter as $entry) {
            $patch = $entry->getPathName();
            $class = strtr($patch, ['.php' => '', '/' => '\\']);
            $classes[] = new $class();
        }
        return $classes;
    }


    protected function getCommand()
    {
        return self::$commands;
    }
}
