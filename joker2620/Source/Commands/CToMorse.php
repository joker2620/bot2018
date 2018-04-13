<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\ModulesClasses\CommandsTemplate;
use joker2620\Source\Plugins\Morse\TableRU;
use Morse\Text;


/**
 * Class CToMorse
 *
 * @package joker2620\Source\Commands
 */
class CToMorse extends CommandsTemplate
{
    protected $regexp     = 'вмз(1|) (.{1,})';
    protected $display    = ' - "вмз(1) (текст)" - зашифрует сообщение. (1- Анг. Таблица)';
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
        $russian = false;
        if ($matches[1][0] != '1')
            $russian = new TableRU();
        $morse = new Text($russian);
        return $morse->toMorse($matches[2][0]);
    }
}
