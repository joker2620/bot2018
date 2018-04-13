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
    protected $regexp     = 'ВМ(ЗА|З) (.{1,})';
    protected $display    = ' - "ВМЗ(А) (текст)" - зашифрует сообщение. (А- Анг. Таблица)';
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
        if ($matches[1][0] != 'ЗА')
            $russian = new TableRU();
        $morse = new Text($russian);
        return $morse->toMorse($matches[2][0]);
    }
}
