<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Setting
 * @package  Joker2620\Source\Engine\Setting
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */

namespace joker2620\Source\Engine\Setting;

use joker2620\Source\Engine\Loger;
use joker2620\Source\Exception\BotError;

/**
 * Class ConfigValidation
 *
 * @category Setting
 * @package  Joker2620\Source\Engine\Setting
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class ConfigValidation
{
    /**
     * ValidationConfig()
     *
     * @return void
     */
    protected function validationConfig()
    {
        $config_feat = ConfgFeatures::getConfig();
        if ($config_feat['CONFIG_CHECKER']) {
            $this->checkUserConfig($config_feat);
        }
    }

    /**
     * CheckUserConfig()
     *
     * @param array|ConfgFeatures $config_feat Конфигурация
     *
     * @return void
     */
    private function checkUserConfig($config_feat)
    {
        foreach ($config_feat as $feats_name => $feats) {
            if ($feats === true) {
                switch ($feats_name) {
                    case 'ENABLE_SMS':
                        $this->noSettings('command', 'SMSRU_API', 'string')
                            ->noSettings('command', 'PHONE_NUMBER', 'array', true);
                        break;
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
        //Check User configuration.
        $this->noSettings('user', 'BOT_NAME', 'string')
            ->noSettings('user', 'ADMINISTRATORS', 'array')
            ->noSettings('user', 'CONFIRMATION_TOKEN', 'string')
            ->noSettings('user', 'ACCESS_TOKEN', 'string')
            ->noSettings('user', 'USER_TRAINING', 'bool')
            ->noSettings('user', 'SAVE_TRAINING_FALSE', 'bool')
            ->noSettings('user', 'MIN_PERCENT', 'int')
            //Check Sustem configuration.
            ->noSettings('sustem', 'VERSION', '0.2.0')
            ->noSettings('sustem', 'BUILD', '17.01.18');
    }

    /**
     * NoSettings()
     *
     * @param string $config     Конфигурация
     * @param string $param_name Имя параметра
     * @param string $type       Тип параметра (bool,
     *                           string, int, array, "любой текст" -
     *                           проверит соответствие значению)
     * @param bool   $level      Уравень
     *                           ошибки (false -
     *                           жесткий, true -
     *                           мягкий)
     *
     * @return $this
     * @throws BotError
     */
    private function noSettings($config, $param_name, $type, $level = false)
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
                $requirements = 'Целое число';
                break;
            case 'string':
                $result       = is_string($user_config[$param_name]) &&
                $user_config[$param_name] != '' ? true : false;
                $requirements = 'Не пустая переменная';
                break;
            case 'array':
                $result       = is_array($user_config[$param_name]) &&
                1 <= count($user_config[$param_name]) ? true : false;
                $requirements = 'Массив с >= 1 элементом';
                break;
            case 'bool':
                $result       = is_bool($user_config[$param_name]) ? true : false;
                $requirements = 'Не целочисленное';
                break;
            default:
                $result       = $user_config[$param_name] == $type ? true : false;
                $requirements = 'Соответствие значению "' . $type . '"';
                break;
        }
        if (!$result) {
            if ($level === false) {
                throw new BotError(
                    'Параметр "' . $param_name .
                    '" не отвечает требованиям:' . $requirements
                );
            } else {
                Loger::getInstance()->logger(
                    'Параметр "' . $param_name .
                    '" не отвечает требованиям:' . $requirements
                );
            }
        }
        return $this;
    }

    /**
     * GetUserConfig()
     *
     * @return UserConfig
     */
    private function userConfig()
    {
        return UserConfig::getConfig();
    }

    /**
     * GetCommandConfig()
     *
     * @return ConfigCommands
     */
    private function commandConfig()
    {
        return ConfigCommands::getConfig();
    }

    /**
     * GetCommandConfig()
     *
     * @return SustemConfig
     */
    private function sustemConfig()
    {
        return SustemConfig::getConfig();
    }
}
