<?php
declare(strict_types = 1);

setlocale(LC_CTYPE, "ru_RU");
ini_set('date.timezone', 'Europe/Moscow');

use nazbav\Source\Engine\DataFlow;
use nazbav\Source\Engine\Loger;
use nazbav\Source\Exception\BotError;

if (!file_exists('vendor/autoload.php'))
    throw new Exception('Composer not installed.');
else
    require 'vendor/autoload.php';

$data_flow = new DataFlow();
try {
    $handler = new \nazbav\Source\Engine\Core();
    $handler->parse(
        $data_flow->readData(
//            [
//                'type' => 'message_new', 'object' =>
//                [
//                    'id' => 4520,
//                    'date' => 1521303747,
//                    'out' => 0,
//                    'user_id' => 211984675,
//                    'read_state' => 0,
//                    'title' => '',
//                    'body' => 'update'
//                ], 'group_id' => \nazbav\Source\Setting\Config::getConfig()['GROUP_ID'], 'secret' => \nazbav\Source\Setting\Config::getConfig()['SECRET_KEY']
//            ]
        )
    );
} catch (BotError $exception) {
    $loger = new Loger();
    $loger->logger($exception);
    $data_flow->putData();
}
