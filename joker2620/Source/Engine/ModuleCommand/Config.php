<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category ModuleCommand
 * @package  Joker2620SourceEngineModuleCommand
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
use joker2620\Source\Engine\Commands\Cball;
use joker2620\Source\Engine\Commands\CCommands;
use joker2620\Source\Engine\Commands\CDecode;
use joker2620\Source\Engine\Commands\CEncode;
use joker2620\Source\Engine\Commands\CGeneratesing;
use joker2620\Source\Engine\Commands\CGetvote;
use joker2620\Source\Engine\Commands\CKurs;
use joker2620\Source\Engine\Commands\CPhonenumbers;
use joker2620\Source\Engine\Commands\CPhprun;
use joker2620\Source\Engine\Commands\CSendSMS;
use joker2620\Source\Engine\Commands\CSmiler;
use joker2620\Source\Engine\Commands\CSovet;
use joker2620\Source\Engine\Commands\CTimed;
use joker2620\Source\Engine\Commands\CTovoice;

/**
 * Список команд комманд (загрузчик)
 *
 * В данном списке можно увидеть список комманд бота в формате:
 * 0 => регулярное выражение
 * 1 => название класса комманды (из директории joker2620\Source/Engine/Commands)
 * 2 => права доступа к команде, 0 - всем, 1 - только администрации
 * 3 => то как будет отображаться коммада в списке комманд
 */
return [
    [
        '(\!время)',
        new CTimed,
        0,
        ' - "!время" - Показывает время.'
    ], [
        '(\!команды|команды)',
        new CCommands,
        0,
        ' - "!команды" - этот список.'
    ], [
        '(\!совет)',
        new CSovet,
        0,
        ' - "!совет" - дает совет.'
    ], [
        '(\!зацени)',
        new CGetvote,
        0,
        ' - "!зацени" - оценит приклепленное вложение.'
    ], [
        '(\!закодируй) (.{1,1000})',
        new CEncode,
        0,
        ' - "!закодируй (текст < 1 тыс. символ)" - закодирует сообщение.'
    ], [
        '(\!раскодируй) (.{1,3000})',
        new CDecode,
        0,
        ' - "!раскодируй (до 3 тыс. символ)" - раскодирует сообщение.'
    ], [
        '(\!курс)',
        new CKurs,
        0,
        ' - "!курс" - показывает курс валют.'
    ], [
        '(!см|смайл) (.{1,})',
        new CSmiler,
        0,
        ' - "!см (текст)" или "смайл (текст)" - заменит смайлы на текcт.'
    ], [
        '(\!вбумажку) (.{1,20})',
        new CGeneratesing,
        0,
        ' - "!вбумажку (текст < 20 символ)" - создаст сигну.'
    ], [
        '(\!вголос) (.{1,500})',
        new CTovoice,
        0,
        ' - "!вголос (текст < 500 символ)" - произнесет сообщение.'
    ], [
        '(\!скомпиль) (.{1,3000})',
        new CPhprun,
        1,
        false
    ], [
        '(смс) (.{1,120})',
        new CSendSMS,
        1,
        ' - "смс (до 120 символ)" - отправиит всем смс с краткой информацией.'
    ], [
        'номера',
        new CPhonenumbers,
        1,
        ' - "номера" - мобильные номера (тех кто их сказал).'
    ], [
        '(\!шар) (.{1,})',
        new Cball(),
        0,
        ' - "!шар (вопрос)" - даст предсказание.'
    ]
];
