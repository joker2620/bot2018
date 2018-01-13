<?php
/**
 *  Файл для тестовой отправки запроса.
 *
 * PHP version 5.6
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
ini_set('date.timezone', 'Europe/Moscow');//Установка времени
/**
 * Айдт группы
 */
const GROUP_ID = '';//Айди группы
/**
 * Секретный ключ
 */
const SECRET = '';//Секретный ключ
/**
 * Адрс к файлу index.php бота
 */

$request = [
    [
        'type' => 'message_new',//Тип события
        'object' => [
            'id' => 1,//Айди сообщения.
            'date' => 1510167414,//Дата и время в Unixtime
            'out' => 0,//
            'user_id' => 211984675,//Айди отправителя
            'read_state' => 0,//
            'title' => '',//Заголовок
            'body' => '!команды'
        ],//Основная часть сообщения
    ],
    [
        'type' => 'message_new',//Тип события
        'object' => [
            'id' => 1,//Айди сообщения.
            'date' => 1510167414,//Дата и время в Unixtime
            'out' => 0,//
            'user_id' => 211984675,//Айди отправителя
            'read_state' => 0,//
            'title' => '',//Заголовок
            'body' => '!время'
        ],//Основная часть сообщения
    ],
    [
        'type' => 'message_new',//Тип события
        'object' => [
            'id' => 1,//Айди сообщения.
            'date' => 1510167414,//Дата и время в Unixtime
            'out' => 0,//
            'user_id' => 211984675,//Айди отправителя
            'read_state' => 0,//
            'title' => '',//Заголовок
            'body' => '!курс'
        ],//Основная часть сообщения
    ],
    [
        'type' => 'message_new',//Тип события
        'object' => [
            'id' => 1,//Айди сообщения.
            'date' => 1510167414,//Дата и время в Unixtime
            'out' => 0,//
            'user_id' => 211984675,//Айди отправителя
            'read_state' => 0,//
            'title' => '',//Заголовок
            'body' => '!совет'
        ],//Основная часть сообщения
    ],
    [
        'type' => 'message_new',//Тип события
        'object' => [
            'id' => 1,//Айди сообщения.
            'date' => 1510167414,//Дата и время в Unixtime
            'out' => 0,//
            'user_id' => 211984675,//Айди отправителя
            'read_state' => 0,//
            'title' => '',//Заголовок
            'body' => '!вголос С наступающим Новым 2018 годом!'
        ],
    ],
    [
        'type' => 'message_new',//Тип события
        'object' => [
            'id' => 1,//Айди сообщения.
            'date' => 1510167414,//Дата и время в Unixtime
            'out' => 0,//
            'user_id' => 211984675,//Айди отправителя
            'read_state' => 0,//
            'title' => '',//Заголовок
            'body' => '!вбумажку С НГ 2к18!'
        ],//Основная часть сообщения
    ],
    [
        'type' => 'message_new',//Тип события
        'object' => [
            'id' => 1,//Айди сообщения.
            'date' => 1510167414,//Дата и время в Unixtime
            'out' => 0,//
            'user_id' => 211984675,//Айди отправителя
            'read_state' => 0,//
            'title' => '',//Заголовок
            'body' => 'номера'
        ],//Основная часть сообщения
    ],
    [
        'type' => 'message_new',//Тип события
        'object' => [
            'id' => 1,//Айди сообщения.
            'date' => 1510167414,//Дата и время в Unixtime
            'out' => 0,//
            'user_id' => 211984675,//Айди отправителя
            'read_state' => 0,//
            'title' => '',//Заголовок
            'body' => 'смс С наступающим Новым Годом!'
        ],//Основная часть сообщения
    ],
    [
        'type' => 'message_new',//Тип события
        'object' => [
            'id' => 1,//Айди сообщения.
            'date' => 1510167414,//Дата и время в Unixtime
            'out' => 0,//
            'user_id' => 211984675,//Айди отправителя
            'read_state' => 0,//
            'title' => '',//Заголовок
            'body' => 'С наступающим Новым Годом!'
        ],//Основная часть сообщения
    ]
];


// НИЖЕ РАБОТА.


/**
 * Функция для тестовой отправки запроса.
 *
 * @param string $url     Адрес сайта
 * @param string $reqType Тип запроса
 * @param array  $obj     Объект запроса
 *
 * @link https://github.com/joker2620/bot2018 #VKCHATBOT
 *
 * @return mixed
 */
function sendrequest($url, $reqType = 'message_new', $obj = [])
{
    $jsondataencoded = [
        'type' => $reqType,//Тип события
        'object' => $obj,//Основная часть сообщения
        'group_id' => GROUP_ID,//Айди группы
        'secret' => SECRET//Секретный ключ
    ];
    /*
     * Отправка
     */
    $curlh = curl_init($url);
    curl_setopt($curlh, CURLOPT_POST, 1);
    curl_setopt($curlh, CURLOPT_POSTFIELDS, json_encode($jsondataencoded));
    curl_setopt($curlh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlh, CURLOPT_SSL_VERIFYPEER, false);
    $getresponce = curl_exec($curlh);
    curl_close($curlh);
    return $getresponce;
}

foreach ($request as $datax) {
    echo "<br/>{$datax['object']['body']}:<br/>";
    var_dump(sendrequest(URLADR, $datax['type'], $datax['object']));
}
/*
 * Запрос файла лога за текущее время, для отображения.
 */
$readlog = '../data/log/ErrorLog/log_' . date('j-m-Y') . '.log';
echo '<br/><br/>LOG:<br/>';
if (file_exists($readlog)) {
    echo file_get_contents($readlog);
} else {
    echo 'no errors';
}