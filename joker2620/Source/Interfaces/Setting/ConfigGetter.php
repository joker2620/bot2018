<?php
declare(strict_types = 1);
/**
 * File: ConfigFeatures.php;
 * Author: Joker2620;
 * Date: 15.04.2018;
 * Time: 16:45;
 */

namespace joker2620\Source\Interfaces\Setting;


/**
 * Interface ConfigFeatures
 *
 * @package joker2620\Source\Interfaces\Setting
 */
abstract class ConfigGetter
{
    abstract public static function getConfig();
}