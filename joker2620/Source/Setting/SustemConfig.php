<?php
declare(strict_types = 1);

namespace joker2620\Source\Setting;

use joker2620\Source\Functions\BotFunction;


/**
 * Class SustemConfig
 *
 * @package joker2620\Source\Setting
 */
class SustemConfig
{

    private static $instance;


    /**
     * SustemConfig constructor.
     */
    private function __construct()
    {
    }


    /**
     * getConfig()
     *
     * @return mixed
     */
    public static function getConfig()
    {
        if (self::$instance == null) {
            $function                = new BotFunction();
            $config_dir              = dirname(dirname(__DIR__));
            $conf_file               = $function->buildPath($config_dir, '/Configuration/SustemConfig.php');
            $config                  = include $conf_file;
            $config['DIR_DATA']      = $function->buildPath($config_dir, 'data');
            $config['DIR_LOG']       = $function->buildPath($config['DIR_DATA'], 'log');
            $config['DIR_IMAGES']    = $function->buildPath($config['DIR_DATA'], 'images');
            $config['DIR_AUDIO']     = $function->buildPath($config['DIR_DATA'], 'audio');
            $config['DIR_DOC']       = $function->buildPath($config['DIR_DATA'], 'docs');
            $config['DIR_BASE']      = $function->buildPath($config['DIR_DATA'], 'base');
            $config['DIR_USER']      = $function->buildPath($config['DIR_DATA'], 'user');
            $config['FILE_BASE']     = $function->buildPath($config['DIR_BASE'], 'base.bin');
            $config['FILE_TRAINING'] = $function->buildPath($config['DIR_BASE'], 'UserMessages.json');
            self::$instance          = $config;
        }
        return self::$instance;
    }
}