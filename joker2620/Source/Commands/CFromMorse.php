<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\ModulesClasses\CommandsTemplate;
use joker2620\Source\Plugins\Morse\TableRU;
use Morse\Text;


/**
 * Class CFromMorse
 *
 * @package joker2620\Source\Commands
 */
class CFromMorse extends CommandsTemplate
{
    protected $regexp     = 'имз(1|) (.{1,})';
    protected $display    = ' - "имз(1) (текст)" - расшифрует сообщение. (1- Анг. Таблица)';
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
        return $morse->fromMorse($matches[2][0]);
    }
}
