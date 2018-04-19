<?php
declare(strict_types = 1);


namespace joker2620\Source\Setting;

use joker2620\Source\Engine\Loger;
use joker2620\Source\Exception\BotError;
use joker2620\Source\Interfaces\Setting\ConfigValid;


/**
 * Class ConfigValidation
 *
 * @package joker2620\Source\Setting
 */
class ConfigValidation implements ConfigValid
{

    private $loger;

    /**
     * ConfigValidation constructor.
     */
    public function __construct()
    {
        $this->loger = new Loger();
    }


    /**
     * validationConfig()
     */
    public function validationConfig(): void
    {
        if (Config::getConfig()['CONFIG_CHECKER']) {
            $this->checkConfig();
        }
    }


    /**
     * checkConfig()
     *
     * @internal param array $config_feat
     */
    private function checkConfig()
    {
        if (key_exists('YANDEX_SPEECH', Config::getConfig()) && Config::getConfig()['YANDEX_SPEECH'] == true) {
            $this->noSettings('SPEECH_KEY', 'string');
        }
        $this->noSettings('BOT_NAME', 'string')
            ->noSettings('ADMINISTRATORS', 'array')
            ->noSettings('CONFIRMATION_TOKEN', 'string')
            ->noSettings('USER_TRAINING', 'bool')
            ->noSettings('DEFAULT_USER_VARS', 'array')
            ->noSettings('MESSAGE', 'array')
            ->noSettings('SAVE_MESSAGE', 'bool')
            ->noSettings('COMMANDS_LIST_LIMIT', 'int')
            ->noSettings('GROUP_ID', 'int')
            ->noSettings('SECRET_KEY', 'int')
            ->noSettings('MIN_PERCENT', 'int');
    }


    /**
     * noSettings()
     *
     * @param string $param_name
     * @param string $type
     *
     * @return $this
     * @throws BotError
     */
    private function noSettings(string $param_name, string $type)
    {
        $requirements = $type;
        switch ($type) {
            case 'int':
                $result = is_int(Config::getConfig()[$param_name]) ? true : false;
                break;
            case 'string':
                $result = is_string(Config::getConfig()[$param_name]) &&
                0 < strlen(Config::getConfig()[$param_name]) ? true : false;
                break;
            case 'array':
                $result = is_array(Config::getConfig()[$param_name]) &&
                1 <= count(Config::getConfig()[$param_name]) ? true : false;
                break;
            case 'bool':
                $result = is_bool(Config::getConfig()[$param_name]) ? true : false;
                break;
            default:
                $result       = Config::getConfig()[$param_name] === $type ? true : false;
                $requirements = 'compliance';
                break;
        }
        if (!$result) {
            $requirements = sprintf(
                Config::getConfig()['MESSAGE'][$requirements],
                $type
            );
            throw new BotError(
                'Параметр "' . $param_name .
                '" не отвечает требованиям: ' . $requirements
            );
        }
        return $this;
    }
}
