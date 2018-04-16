<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;


use joker2620\Source\Modules\CommandsTemplate;


/**
 * Class CPhprun
 *
 * @package joker2620\Source\Commands
 */
class CPhprun extends CommandsTemplate
{

    protected $regexp = 'скомпиль (.{1,3000})';

    protected $display = 'скомпиль (PHP CODE)" - компилирует программу';

    protected $permission = 1;


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return string
     */
    public function runCommand(array $matches)
    {
        ob_start();
        eval($matches[1][0]);
        $message = ob_get_clean();
        return $message;
    }
}
