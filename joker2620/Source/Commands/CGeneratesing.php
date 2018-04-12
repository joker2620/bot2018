<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\ModulesClasses\CommandsTemplate;
use joker2620\Source\Plugins\AutoSing\SignArt;


/**
 * Class CGeneratesing
 *
 * @package joker2620\Source\Commands
 */
class CGeneratesing extends CommandsTemplate
{

    protected $regexp = 'вбумажку (.{1,20})';

    protected $display = ' - "вбумажку (текст < 20 символ)" - создаст сигну.';

    protected $permission = 0;


    /**
     * runCommand()
     *
     * @param array $matches
     *
     * @return array
     */
    public function runCommand(array $matches)
    {
        $content  = new SignArt();
        $autosign = $content->generate($matches[1][0], [0, 34, 56]);
        $photo    = $this->vkapi->uploadPhoto($this->user->getId(), $autosign);
        $content->imageDestroy($autosign);
        return [
            $matches[1][0], [
                'photo' . $photo['owner_id'] . '_' . $photo['id']
            ]
        ];
    }
}
