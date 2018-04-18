<?php
declare(strict_types = 1);

namespace joker2620\Source\Commands;

use joker2620\Source\API\YandexTTS;
use joker2620\Source\Modules\CommandsTemplate;
use joker2620\Source\Setting\Config;


/**
 * Class CTovoice
 *
 * @package joker2620\Source\Commands
 */
class CTovoice extends CommandsTemplate
{

    protected $regexp = 'молви (.{1,500})';

    protected $display = ' - "молви (текст < 500 символ)" - произнесет сообщение.';

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
        if (Config::getConfig()['YANDEX_SPEECH']) {
            $yandex_tts      = new YandexTTS();
            $messagefilename = $yandex_tts->getVoice(
                $matches[1][0],
                'omazh'
            );
            $doccs           = $this->vkapi->uploadVoice(
                $this->user->getId(),
                $messagefilename
            );
            $return          = [
                $matches[1][0],
                ['doc' . $doccs['owner_id'] . '_' . $doccs['id']]
            ];
        } else {
            $return = Config::getConfig()['MESSAGE']['FunctionDisabled'];
        }
        return $return;
    }
}
