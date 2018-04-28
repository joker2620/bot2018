<?php
declare(strict_types = 1);
/**
 * Проект: nazbav/bot2018
 * Author: nazbav;
 * PHP version 7.1;
 */
return [
    /**
     * Разрешить генерацию голосовых сообщений
     *
     * ДЛЯ ГЕНЕРАЦИИ ГОЛОСОВЫХ СООБЩЕНИЙ, ТРЕБУЕТСЯ УКАЗАТЬ 'SPEECH_KEY',
     * в UserConfig.php
     */
    'YANDEX_SPEECH' => true,
    /**
     * Разрешить проверять файл UserConfig.php
     *
     * ДЛЯ КОРРЕКТНОЙ РАБОТЫ ЛУЧШЕ ОСТАВИТЬ ВКЛЮЧЕННЫМ
     */
    'CONFIG_CHECKER' => true
];
