<?php

declare(strict_types=1);

namespace joker2620\Source\Commands;

use joker2620\Source\Modules\CommandsTemplate;
use joker2620\Source\Setting\Config;

/**
 * Class CPhprun.
 */
class CGetUpdate extends CommandsTemplate
{
    protected $regexp = 'update';

    protected $display = 'update - проверет наличие обновления';

    protected $permission = 1;

    /**
     * runCommand().
     *
     * @param array $matches
     *
     * @return string
     */
    public function runCommand(array $matches)
    {
        $message = 'Обновлений нет';
        $result = $this->vkapi->curlGet('https://raw.githubusercontent.com/joker2620/bot2018/master/update.json');
        if ($result['status'] == 'done'
            && isset($result)
            && isset($result['joker2620/bot2018'])
        ) {
            $this_bot = $result['joker2620/bot2018'];
            $version = $this_bot['version'];
            $build = $this_bot['build'];
            if ($this->scanVersion($version) ||
                $this->scanBuild($build)
            ) {
                $message = "Новая версия: $version; Сборка: $build\nСкачать: {$this_bot['source']}";
            } else {
                $message .= "\nВаша версия: $version; Сборка: $build";
            }
        }

        return $message;
    }

    /**
     * scanVersion().
     *
     * @param $version
     *
     * @return bool
     */
    public function scanVersion(string $version)
    {
        return version_compare(Config::getConfig()['VERSION'], $version, '<');
    }

    /**
     * scanBuild().
     *
     * @param $build
     *
     * @return bool
     */
    public function scanBuild(string $build)
    {
        return version_compare(Config::getConfig()['BUILD'], $build, '<');
    }
}
