<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\Modules\CommandsTemplate;


/**
 * Class Cball
 *
 * @package joker2620\Source\Commands
 */
class CCSave extends CommandsTemplate
{
    protected $regexp = 'запомни (.{1,})';

    protected $display = ' - "запомни (текст)" - запомнит текст.';

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
        if ($this->dataBase->write('var0',$matches[1][0]))
            return 'Запомниль!';
        return 'Не запомниль';
    }
}
