<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\ModulesClasses\CommandsTemplate;


/**
 * Class CEncode
 *
 * @package joker2620\Source\Commands
 */
class CEncode extends CommandsTemplate
{

    protected $regexp = 'закодируй (.{1,1000})';

    protected $display = ' - "закодируй (текст < 1 тыс. символ)" - закодирует сообщение.';

    protected $permission = 0;


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return string
     */
    public function runCommand(array $matches)
    {
        $message = base64_encode($matches[1][0]);
        return $message;
    }
}
