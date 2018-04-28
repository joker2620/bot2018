<?php
declare(strict_types = 1);

namespace nazbav\Source\Setting;

use nazbav\Source\Engine\BotFunction;
use nazbav\Source\Exception\BotError;
use nazbav\Source\Interfaces\Setting\ConfigGetter;


/**
 * Class Config
 *
 * @package nazbav\Source\Setting
 */
class Config extends ConfigGetter
{
    private static $instance;

    /**
     * Config constructor.
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
            $function       = new BotFunction();
            $config_dir     = dirname(dirname(__DIR__));
            $class_config   = ['SustemConfig', 'UserConfig', 'FeaturesConfig'];
            $config         = self::getPath($config_dir, $function);
            self::$instance = self::loadArrays($class_config, $config_dir, $function, $config);
        }
        return self::$instance;
    }

    /**
     * getPath()
     *
     * @param       $config_dir
     * @param       $function
     * @param array $config
     *
     * @return array
     */
    private static function getPath(&$config_dir, &$function, &$config = [])
    {
        $config['VERSION']       = '1.1.0';
        $config['DIR_DATA']      = $function->buildPath(
            $config_dir,
            'data'
        );
        $config['DIR_LOG']       = $function->buildPath(
            $config['DIR_DATA'],
            'log'
        );
        $config['DIR_IMAGES']    = $function->buildPath(
            $config['DIR_DATA'],
            'images'
        );
        $config['DIR_AUDIO']     = $function->buildPath(
            $config['DIR_DATA'],
            'audio'
        );
        $config['DIR_DOC']       = $function->buildPath(
            $config['DIR_DATA'],
            'docs'
        );
        $config['DIR_BASE']      = $function->buildPath(
            $config['DIR_DATA'],
            'base'
        );
        $config['DIR_USER']      = $function->buildPath(
            $config['DIR_DATA'],
            'user'
        );
        $config['FILE_BASE']     = $function->buildPath(
            $config['DIR_BASE'],
            'base.bin'
        );
        $config['FILE_TRAINING'] = $function->buildPath(
            $config['DIR_BASE'],
            'UserMessages.json'
        );
        return $config;
    }

    /**
     * loadArrays()
     *
     * @param       $class
     * @param       $config_dir
     * @param       $function
     *
     * @param array $conf_arr
     *
     * @return array
     * @throws BotError
     */
    private static function loadArrays(&$class, &$config_dir, &$function, &$conf_arr = [])
    {
        if (is_array($class)) {
            foreach ($class as $value) {
                $config   = include $function->buildPath(
                    $config_dir,
                    '/Configuration/' . $value . '.php'
                );
                $conf_arr = array_merge($config, $conf_arr);
            }
        }
        return $conf_arr;
    }
}