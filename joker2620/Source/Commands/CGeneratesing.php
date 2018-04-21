<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\SingArt\SignArt;
use joker2620\Source\Modules\CommandsTemplate;
use joker2620\Source\Setting\Config;


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
        $content = new SignArt();
        $content->setDirectory(Config::getConfig()['DIR_IMAGES'] . '/sign');
        $image_base = [
            ['0.png', 320, 247, 383, 709, 24],
            ['1.png', 201, 111, 383, 190, 19],
            ['2.png', 409, 177, 396, 508, -10],
            ['3.png', 606, 310, 165, 653, 7],
            ['4.png', 281, 121, 659, 342, 10],
            ['5.png', 386, 202, 261, 562, -9],
            ['6.png', 284, 188, 675, 507, 25],
            ['7.png', 191, 90, 253, 128, -9],
            ['8.png', 328, 75, 209, 325, -1]
        ];
        $content->addImageBase($image_base);
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
