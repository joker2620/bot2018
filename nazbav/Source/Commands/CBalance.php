<?php
declare(strict_types = 1);

namespace nazbav\Source\Commands;

use nazbav\Source\Modules\CommandsTemplate;


/**
 * Class Cball
 *
 * @package nazbav\Source\Commands
 */
class CBalance extends CommandsTemplate
{
    protected $regexp = 'кошелек';

    protected $display = ' - "кошелек" - покашет сколько у вас средств.';

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
        $reads = $this->dataBase->read('balance');
        switch ($reads) {
            case 1:
                $dollar = 'пирожок';
                break;
            case 2:
            case 3:
            case 4:
                $dollar = 'пирожка';
                break;
            default:
                $dollar = 'пирожков';
                break;
        }
        return 'Вы взяли с полки ' . $reads . ' ' . $dollar;
    }
}
