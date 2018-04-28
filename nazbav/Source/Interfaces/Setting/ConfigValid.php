<?php
declare(strict_types = 1);
/**
 * File: ConfigValid.php;
 * Author: nazbav;
 * Date: 15.04.2018;
 * Time: 16:50;
 */

namespace nazbav\Source\Interfaces\Setting;


/**
 * Class ConfigValid
 *
 * @package nazbav\Source\Interfaces\Setting
 */

interface ConfigValid
{
    /**
     * validationConfig()
     */
    public function validationConfig(): void;
}