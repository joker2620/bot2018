<?php
declare(strict_types = 1);


ini_set('date.timezone', 'Europe/Moscow');

if (!file_exists('vendor/autoload.php')) {
    die('Composer not installed.');
}

require 'vendor/autoload.php';

use joker2620\Source\DataFlow\DataFlow;
use joker2620\Source\Exception\BotError;
use joker2620\Source\Loger\Loger;

try {
    $handler   = new \joker2620\Source\Core();
    $data_flow = new DataFlow();
    $handler->parse(
        $data_flow->readData(
//            [
//            'type' => 'message_new', 'object' =>
//                [
//                    'id' => 4520,
//                    'date' => 1521303747,
//                    'out' => 0,
//                    'user_id' => 211984675,
//                    'read_state' => 0,
//                    'title' => '',
//                    'body' => 'времяя'
//                ], 'group_id' => 324, 'secret' => 432
//            ]
        )
    );
} catch (BotError $exception) {
    $loger = new Loger();
    $loger->logger($exception);
    $data_flow->putData();
}