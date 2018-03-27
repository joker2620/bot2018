<?php
declare(strict_types = 1);
/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * PHP version 7.1;
 *
 * @category Setting
 * @package  Joker2620\Source\Setting
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
namespace joker2620\Source\Setting;

use joker2620\Source\Functions\BotFunction;

/**
 * Class SustemConfig
 *
 * @category Setting
 * @package  Joker2620\Source\Setting
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
class SustemConfig
{
    /**
     * Копия класса
     */
    private static $instance;

    /**
     * SustemConfig constructor.
     *
     * @ignore
     */
    private function __construct()
    {
    }

    /**
     * GetConfig()
     *
     * @return SustemConfig
     */
    public static function getConfig()
    {
        if (self::$instance == null) {
            $function                = new BotFunction();
            $config_dir              = dirname(dirname(__DIR__));
            $conf_file               = $function->buildPath($config_dir, '/Configuration/SustemConfig.php');
            $config                  = include $conf_file;
            $config['DIR_DATA']      = $function->buildPath($config_dir, 'data');//Корень
            $config['DIR_LOG']       = $function->buildPath($config['DIR_DATA'], 'log');//Файлы
            $config['DIR_IMAGES']    = $function->buildPath($config['DIR_DATA'], 'images');//Логи
            $config['DIR_AUDIO']     = $function->buildPath($config['DIR_DATA'], 'audio');//Картинки
            $config['DIR_DOC']       = $function->buildPath($config['DIR_DATA'], 'docs');//Аудио
            $config['DIR_BASE']      = $function->buildPath($config['DIR_DATA'], 'base');//базы
            $config['DIR_USER']      = $function->buildPath($config['DIR_DATA'], 'user');//базы
            $config['FILE_BASE']     = $function->buildPath($config['DIR_BASE'], 'base.bin');//База слов
            $config['FILE_TRAINING'] = $function->buildPath($config['DIR_BASE'], 'UserMessages.json');//База обучений
            self::$instance          = $config;
        }
        return self::$instance;
    }
}