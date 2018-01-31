<?php
/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Joker2620
 * @package  Joker2620
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
ini_set('date.timezone', 'Europe/Moscow');

require_once 'vendor/autoload.php';

use joker2620\Source\Engine\DataOperations;
use joker2620\Source\Engine\Loger;
use joker2620\Source\Exception\BotError;

/*
 * Папка бота
 */
try {
    (new joker2620\Source\Engine\Core())->scan();
} catch (BotError $exception) {
    Loger::getInstance()->logger($exception);
    DataOperations::putData();
}