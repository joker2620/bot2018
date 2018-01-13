<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version  5.6;
 *
 * @category Cructh
 * @package  JokerSourceCrutch
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://habrahabr.ru/sandbox/103022/ Взято от сюда
 */
namespace joker2620\Source\Crutch;

use joker2620\Source\Exception\BotError;

/**
 * Class PostConstructor
 *
 * @category Cructh
 * @package  JokerSourceCrutch
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://habrahabr.ru/sandbox/103022/ Взято от сюда
 */
class PostConstructor
{
    /**
     * Функция генерации POST-тела
     *
     * @param array  $post      Данные
     * @param string $delimiter Разделитель
     *
     * @return string
     * @throws BotError
     */
    public static function getBody(
        array $post,
        $delimiter = '-------------0123456789'
    ) {
        if (is_array($post) && !empty($post)) {
            $boolean = false;
            foreach ($post as $value) {
                if ($value instanceof ObjectFile) {
                    $boolean = true;
                    break;
                }
            }
            if ($boolean) {
                $return = '';
                foreach ($post as $named => $value) {
                    $return .= '--' . $delimiter . "\r\n" .
                        self::partPost($named, $value);
                    $return .= "--" . $delimiter . "--\r\n";
                }
            } else {
                $return = http_build_query($post);
            }
        } else {
            throw new BotError('Error input param!');
        }
        return $return;
    }

    /**
     * Генератор содержимого post
     *
     * @param string $name  Имя файла
     * @param object $value Объект файла
     *
     * @return string Post Файла
     */
    public static function partPost($name, $value)
    {
        $data_body = 'Content-Disposition: form-data; name="' . $name . '"';
        if ($value instanceof ObjectFile) {
            $data_file    = $value->name();
            $data_mime    = $value->mime();
            $data_content = $value->content();

            $data_body .= '; filename="' . $data_file . '"' . "\r\n";
            $data_body .= 'Content-Type: ' . $data_mime . "\r\n\r\n";
            $data_body .= $data_content . "\r\n";
        } else {
            $data_body .= "\r\n\r\n" . urlencode($value) . "\r\n";
        }
        return $data_body;
    }
}
