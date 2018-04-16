<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\Modules\CommandsTemplate;


/**
 * Class CDecode
 *
 * @package joker2620\Source\Commands
 */
class CDecode extends CommandsTemplate
{

    protected $regexp = 'раскодируй (.{1,3000})';

    protected $display = ' - "раскодируй (до 3 тыс. символ)" - раскодирует сообщение.';

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
        $message = base64_decode($matches[1][0]);
        return $message;
    }
}
