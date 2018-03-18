<?php
/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 7.1;
 *
 * @category Joker2620
 * @package  Joker2620
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
ini_set('date.timezone', 'Europe/Moscow');

if (!file_exists('vendor/autoload.php')) {
    die('Composer not installed.');
}

require 'vendor/autoload.php';

use joker2620\Source\DataOperations;
use joker2620\Source\Exception\BotError;
use joker2620\Source\Loger;

try {
    $handler = new \joker2620\Source\Core();
    $handler->parse(DataOperations::getData(
// This is test request:
//        [
//        'type' => 'message_new',
//        'object' =>
//            [
//                'id' => 4520,
//                'date' => 1521303747,
//                'out' => 0,
//                'user_id' => 211984675,
//                'read_state' => 0,
//                'title' => '',
//                'body' => 'ТЕКСТ',
//            ],
//        'group_id' => '",
//        'secret' => '',
//        ]
    ));
} catch (BotError $exception) {
    Loger::getInstance()->logger($exception);
    DataOperations::putData();
}