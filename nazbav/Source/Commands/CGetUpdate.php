<?php
declare(strict_types = 1);

namespace nazbav\Source\Commands;


use nazbav\Source\Modules\CommandsTemplate;
use nazbav\Source\Setting\Config;


/**
 * Class CPhprun
 *
 * @package nazbav\Source\Commands
 */
class CGetUpdate extends CommandsTemplate
{

    protected $regexp = 'update';

    protected $display = 'update - проверет наличие обновления';

    protected $permission = 1;


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return string
     */
    public function runCommand(array $matches)
    {
        $message = 'Обновлений нет';
        $result  = $this->vkapi->curlGet('https://raw.githubusercontent.com/nazbav/bot2018/master/update.json');
        if (isset($result['status']) && $result['status'] == 'done'
            && isset($result)
            && isset($result["nazbav/bot2018"])
        ) {
            $this_bot = $result["nazbav/bot2018"];
            $version  = $this_bot['version'];
            if ($this->scanVersion($version)
            ) {
                $message = "Новая версия: $version\nСкачать: {$this_bot['source']}";
            } else {
                $message .= "\nВаша версия:" . Config::getConfig()['VERSION'] . ', на сервере: ' . $version;
            }
        }
        return $message;
    }

    /**
     * scanVersion()
     *
     * @param $version
     *
     * @return bool
     */
    public function scanVersion(string $version)
    {
        return version_compare(Config::getConfig()['VERSION'], $version, '<');
    }
}
