<?php
declare(strict_types = 1);


namespace joker2620\Source\Setting;

use joker2620\Source\Exception\BotError;
use joker2620\Source\Loger\Loger;


/**
 * Class ConfigValidation
 *
 * @package joker2620\Source\Setting
 */
class ConfigValidation
{


    /**
     * ConfigValidation constructor.
     */
    public function __construct()
    {
        $this->loger = new Loger();
    }


    public function validationConfig()
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
        foreach ($config_feat as $feats_name => $feats) {
            if ($feats === true) {
                switch ($feats_name) {
                    case 'ENABLE_ADMIN_TOKEN':
                        $this->noSettings('user', 'SPEECH_KEY', 'string');
                        break;
                    case 'YANDEX_SPEECH':
                        $this->noSettings('user', 'SPEECH_KEY', 'string');
                        break;
                    case 'AG_API_KEY':
                        $this->noSettings('user', 'AG_API_KEY', 'string');
                        break;
                }
            }
        }

        $this->noSettings('user', 'BOT_NAME', 'string')
            ->noSettings('user', 'ADMINISTRATORS', 'array')
            ->noSettings('user', 'CONFIRMATION_TOKEN', 'string')
            ->noSettings('user', 'ACCESS_TOKEN', 'string')
            ->noSettings('user', 'USER_TRAINING', 'bool')
            ->noSettings('user', 'SAVE_TRAINING_FALSE', 'bool')
            ->noSettings('user', 'MIN_PERCENT', 'int')
            ->noSettings('sustem', 'VERSION', '0.2.0')
            ->noSettings('sustem', 'BUILD', '11.04.18');
    }


    /**
     * noSettings()
     *
     * @param string $config
     * @param string $param_name
     * @param string $type
     * @param bool   $level
     *
     * @return $this
     * @throws BotError
     */
    private function noSettings(string $config, string $param_name, string $type, bool $level = false)
    {
        $user_config = [];
        switch ($config) {
            case 'user':
                $user_config = $this->userConfig();
                break;
            case 'command':
                $user_config = $this->commandConfig();
                break;
            case 'sustem':
                $user_config = $this->sustemConfig();
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
                $result       = $user_config[$param_name] == $type ? true : false;
                $requirements = 'соответствие значению "' . $type . '"';
                break;
        }
        if (!$result) {
            if ($level === false) {
                throw new BotError(
                    'Параметр "' . $param_name .
                    '" не отвечает требованиям: ' . $requirements
                );
            } else {
                $this->loger->logger(
                    'Параметр "' . $param_name .
                    '" не отвечает требованиям: ' . $requirements
                );
            }
        }
        return $this;
    }


    /**
     * userConfig()
     *
     * @return mixed
     */
    private function userConfig()
    {
        return UserConfig::getConfig();
    }


    /**
     * sustemConfig()
     *
     * @return mixed
     */
    private function sustemConfig()
    {
        return SustemConfig::getConfig();
    }
}
