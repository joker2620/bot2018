<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category Cructh
 * @package  Joker2620\Source\Crutch
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://habrahabr.ru/sandbox/103022/ Взято от сюда
 */

namespace joker2620\Source\Crutch;

use Exception;

/**
 * Исходный код взят из интернета и модифицирован
 *
 * @category Cructh
 * @package  Joker2620\Source\Crutch
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://habrahabr.ru/sandbox/103022/ Взято от сюда
 */
class ObjectFile
{
    /**
     * Имя файла или путь к файлу
     */
    private $name;
    /**
     * Тип содержимого
     */
    private $mime;
    /**
     * Содержимое файла
     */
    private $content;

    /**
     * ObjectFile constructor.
     *
     * @param string $name     Имя файла
     * @param string $mimetype Тип содеожимого
     * @param string $content  Содержимое
     *
     * @throws   Exception
     */
    public function __construct($name, $mimetype = null, $content = null)
    {
        if (is_null($content)) {
            $information = pathinfo($name);
            if (!empty($information['basename']) && is_readable($name)) {
                $this->name = $information['basename'];
                $this->mime = mime_content_type($name);
                $content    = file_get_contents($name);
                if ($content !== false) {
                    $this->content = $content;
                } else {
                    throw new Exception('Don`t get content - "' . $name . '"');
                }
            } else {
                throw new Exception('Error param');
            }
        } else {
            $this->name = $name;
            if (is_null($mimetype)) {
                $mimetype = mime_content_type($name);
            }
            $this->mime    = $mimetype;
            $this->content = $content;
        };
    }

    /**
     * Name()
     *
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Mime()
     *
     * @return null|string
     */
    public function mime()
    {
        return $this->mime;
    }

    /**
     * Content()
     *
     * @return null
     */
    public function content()
    {
        return $this->content;
    }
}
