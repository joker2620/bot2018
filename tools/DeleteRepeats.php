<?php
/**
 * Скрипт удаления повторов в базе, и сортировки базы.
 *
 * PHP version 5.6
 *
 * @category Engine
 * @package  Joker2620\Source\Engine
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
$endstring = [];
$return = false;
$filebase = '../joker2620/data/base/base.bin';
$filebase = file($filebase);
sort($filebase);
foreach ($filebase as $value) {
    $parameters = explode('\\', $value);
    if (!empty($parameters[0]) && !empty($parameters[0]) && !empty($parameters[2])) {
        $endstring[$parameters[0]] = $parameters[1];
    }
}
$endstring = array_unique($endstring);
foreach ($endstring as $keysx => $value) {
    $return .= $keysx . '\\' . $value . "\\0\r\n";
}
$output = fopen(__DIR__ . '/base.bin', 'w');
fwrite($output, $return);
fclose($output);