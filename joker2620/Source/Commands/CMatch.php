<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use FormulaParser\FormulaParser;
use joker2620\Source\ModulesClasses\CommandsTemplate;


/**
 * Class CToMorse
 *
 * @package joker2620\Source\Commands
 */
class CMatch extends CommandsTemplate
{
    protected $regexp     = 'вч (.*)';
    protected $display    = ' - "вч (выражение)" - Вычислит выражение.';
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
        $parser = new FormulaParser($matches[1][0]);//'3+4*2/(1-5)^8');
        $result = $parser->getResult(); // [0 => 'done', 1 => 3.0001]
        if ($result[0] == 'done')
            return 'Ответ: ' . $result[1];
        else
            return 'Возникла ошибка: ' . $result[1];
    }
}
