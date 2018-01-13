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
    private $_name;
    /**
     * Тип содержимого
     */
    private $_mime;
    /**
     * Содержимое файла
     */
    private $_content;

    /**
     * ObjectFile constructor.
     *
     * @param string $name     Имя файла
     * @param string $mimetype Тип содеожимого
     * @param string $content  Содержимое
     *
     * @throws   Exception
     * @internal param null $mime
     */
    public function __construct($name, $mimetype = null, $content = null)
    {
        if (is_null($content)) {
            $information = pathinfo($name);
            if (!empty($information['basename']) && is_readable($name)) {
                $this->_name = $information['basename'];
                $this->_mime = mime_content_type($name);
                $content     = file_get_contents($name);
                if ($content !== false) {
                    $this->_content = $content;
                } else {
                    throw new Exception('Don`t get content - "' . $name . '"');
                }
            } else {
                throw new Exception('Error param');
            }
        } else {
            $this->_name = $name;
            if (is_null($mimetype)) {
                $mimetype = mime_content_type($name);
            }
            $this->_mime    = $mimetype;
            $this->_content = $content;
        };
    }

    /**
     * Name()
     *
     * @return mixed
     */
    public function name()
    {
        return $this->_name;
    }

    /**
     * Mime()
     *
     * @return null|string
     */
    public function mime()
    {
        return $this->_mime;
    }

    /**
     * Content()
     *
     * @return null
     */
    public function content()
    {
        return $this->_content;
    }

}
