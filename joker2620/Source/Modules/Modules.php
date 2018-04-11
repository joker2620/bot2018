<?php
declare(strict_types = 1);


namespace joker2620\Source\Modules;


/**
 * Class Modules
 *
 * @package joker2620\Source\Modules
 */
class Modules
{

    private static $modules;


    public function getModule()
    {
        return self::$modules;
    }


    /**
     * addModule()
     *
     * @param $class
     *
     * @return $this
     */
    public function addModule($class)
    {
        $no_register = false;
        if (count(self::$modules) > 1) {
            foreach (self::$modules as $module) {
                if ($module instanceof $class) {
                    $no_register = true;
                }
            }
        }
        if (!$no_register) {
            self::$modules [] = $class;
        }
        return $this;
    }
}
