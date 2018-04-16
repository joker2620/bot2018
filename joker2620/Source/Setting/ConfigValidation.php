<?php
declare(strict_types = 1);


namespace joker2620\Source\Setting;

use joker2620\Source\Exception\BotError;
use joker2620\Source\Interfaces\Setting\ConfigValid;
use joker2620\Source\Loger\Loger;


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
        $config_feat = ConfgFeatures::getConfig();
        if ($config_feat['CONFIG_CHECKER']) {
            $this->checkUserConfig($config_feat);
        }
    }


    /**
     * checkUserConfig()
     *
     * @param array $config_feat
     */
    private function checkUserConfig(array $config_feat)
    {
        if (key_exists('YANDEX_SPEECH', $config_feat) && $config_feat['YANDEX_SPEECH'] == true) {
            $this->noSettings('user', 'SPEECH_KEY', 'string');
        }
        $this->noSettings('user', 'BOT_NAME', 'string')
            ->noSettings('user', 'ADMINISTRATORS', 'array')
            ->noSettings('user', 'CONFIRMATION_TOKEN', 'string')
            ->noSettings('user', 'USER_TRAINING', 'bool')
            ->noSettings('user', 'MIN_PERCENT', 'int')
            ->noSettings('sustem', 'VERSION', '0.2.1-alpha2')
            ->noSettings('sustem', 'BUILD', '17.04.18');
    }


    /**
     * noSettings()
     *
     * @param string $config
     * @param string $param_name
     * @param string $type
     *
     * @return $this
     * @throws BotError
     *
     */
    private function noSettings(string $config, string $param_name, string $type)
    {
        $user_config = [];
        switch ($config) {
            case 'user':
                $user_config = UserConfig::getConfig();
                break;
            case 'sustem':
                $user_config = SustemConfig::getConfig();
                break;
        }
        switch ($type) {
            case 'int':
                $result       = is_int($user_config[$param_name]) ? true : false;
                $requirements = 'целое число';
                break;
            case 'string':
                $result       = is_string($user_config[$param_name]) &&
                $user_config[$param_name] != '' ? true : false;
                $requirements = 'не пустая переменная';
                break;
            case 'array':
                $result       = is_array($user_config[$param_name]) &&
                1 <= count($user_config[$param_name]) ? true : false;
                $requirements = 'массив с >= 1 элементом';
                break;
            case 'bool':
                $result       = is_bool($user_config[$param_name]) ? true : false;
                $requirements = 'не целочисленное';
                break;
            default:
                $result       = $user_config[$param_name] === $type ? true : false;
                $requirements = 'соответствие значению "' . $type . '"';
                break;
        }
        if (!$result) {
            throw new BotError(
                'Параметр "' . $param_name .
                '" не отвечает требованиям: ' . $requirements
            );
        }
        return $this;
    }
}
