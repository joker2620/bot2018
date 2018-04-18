<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\Modules\CommandsTemplate;


/**
 * Class Cball
 *
 * @package joker2620\Source\Commands
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
