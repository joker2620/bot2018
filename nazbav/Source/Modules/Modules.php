<?php
declare(strict_types = 1);


namespace nazbav\Source\Modules;


/**
 * Class Modules
 *
 * @package nazbav\Source\Modules
 */
class Modules
{

    private static $modules;


    public function getModule()
    {
        return self::$modules;
    }

    public function loadModules(): void
    {
        if (self::$modules == null) {
            self::$modules = $this->modules();
        }
    }


    /**
     * commands()
     *
     * @return array
     */
    protected function modules(): array
    {
        $iterator = new \FilesystemIterator("nazbav/Source/Modules");
        $filter   = new \RegexIterator($iterator, '/HModule.*\.php$/');
        $classes  = [];
        foreach ($filter as $entry) {
            $patch     = $entry->getPathName();
            $class     = strtr($patch, ['.php' => '', '/' => '\\']);
            $classes[] = new $class();
        }
        return $classes;
    }
}
