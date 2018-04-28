<?php
declare(strict_types = 1);
/**
 * File: ConfigFeatures.php;
 * Author: nazbav;
 * Date: 15.04.2018;
 * Time: 16:45;
 */

namespace nazbav\Source\Interfaces\Setting;


/**
 * Interface ConfigFeatures
 *
 * @package nazbav\Source\Interfaces\Setting
 */
abstract class ConfigGetter
{
    abstract public static function getConfig();
}