<?php
declare(strict_types = 1);

namespace nazbav\Source\Commands;

use nazbav\Source\Modules\CommandsTemplate;


/**
 * Class CSovet
 *
 * @package nazbav\Source\Commands
 */
class CSovet extends CommandsTemplate
{

    protected $regexp = 'совет';

    protected $display = ' - "совет" - дает совет.';

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
        $datas    = $this->vkapi->curlGet('http://fucking-great-advice.ru/api/random');
        $jsondata = $datas;
        return strip_tags(strtr($jsondata['text'], ['&nbsp;' => ' ']));
    }
}
