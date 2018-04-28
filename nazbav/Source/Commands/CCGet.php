<?php
declare(strict_types = 1);

namespace nazbav\Source\Commands;

use nazbav\Source\Modules\CommandsTemplate;


/**
 * Class Cball
 *
 * @package nazbav\Source\Commands
 */
class CCGet extends CommandsTemplate
{
    protected $regexp = 'вспомни';

    protected $display = ' - "вспомни" - вспомнит текст.';

    protected $permission = 0;


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return mixed
     */
    public function runCommand(array $matches)
    {
        $reads = $this->dataBase->read('var0');
        return 'Ты говорил: ' . $reads;
    }
}
