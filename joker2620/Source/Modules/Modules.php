<?php

declare(strict_types=1);

namespace joker2620\Source\Modules;

/**
 * Class Modules.
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
     * commands().
     *
     * @return array
     */
    protected function modules(): array
    {
        $iterator = new \FilesystemIterator('joker2620/Source/Modules');
        $filter = new \RegexIterator($iterator, '/HModule.*\.php$/');
        $classes = [];
        foreach ($filter as $entry) {
            $patch = $entry->getPathName();
            $class = strtr($patch, ['.php' => '', '/' => '\\']);
            $classes[] = new $class();
        }

        return $classes;
    }
}
