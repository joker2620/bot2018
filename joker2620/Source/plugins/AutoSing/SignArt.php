<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 5.6;
 *
 * @category AutoSing
 * @package  Joker2620SourcepluginsAutoSing
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */

namespace joker2620\Source\plugins\AutoSing;

use joker2620\Source\Crutch\ObjectFile;
use joker2620\Source\Engine\Setting\SustemConfig;

/**
 * Class signart
 *
 * @category AutoSing
 * @package  Joker2620SourcepluginsAutoSing
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class SignArt
{
    /**
     * Папка с картинками
     */
    private $_imgDir;
    /**
     * Картинка
     */
    private $_image;
    /**
     * Данные
     */
    private $_data;

    /**
     * SignArt constructor.
     */
    public function __construct()
    {
        $this->_imgDir = SustemConfig::getConfig()['DIR_IMAGES'] . '/sign/';
        $this->_image  = null;
    }


    /**
     * Функция нанесения текста на изображение.
     *
     * @param string $text  Текст
     * @param array  $color Цвет текста
     * @param string $fonts Шрифт
     *
     * @return string
     */
    public function generate(
        $text,
        $color = [0, 0, 0],
        $fonts = 'PFKidsPro-GradeOne.ttf'
    ) {

        $fonts = $this->_imgDir . $fonts;
        $this->getRandImg();
        $color = $this->colors($color[0], $color[1], $color[2]);
        $this->setText(
            [$text, $fonts, $color],
            $this->_data[5],
            [$this->_data[3], $this->_data[4]],
            [$this->_data[1], $this->_data[2]]
        );
        ob_start();
        imagepng($this->_image, null, 6);
        $result = ob_get_clean();
        $result = new ObjectFile(
            'image' . rand(0, 1000) . '.png', 'image/png', $result
        );
        return $result;
    }

    /**
     * Функция получения случайного изображения
     *
     * @return void
     */
    public function getRandImg()
    {
        $base_art     = include 'Config.php';
        $datas        = $base_art[rand(0, count($base_art) - 1)];
        $files        = $this->_imgDir . $datas[0];
        $this->_image = imagecreatefrompng($files);
        $this->_data  = $datas;
    }

    /**
     * Функция установки цвета текста изображения
     *
     * @param int $r Крассный
     * @param int $g Зеленый
     * @param int $b Синий
     *
     * @return int
     */
    public function colors($r, $g, $b)
    {
        return imagecolorallocate($this->_image, $r, $g, $b);
    }

    /**
     * Функция нанесения текста
     *
     * @param string $text    Текст
     * @param int    $rota    Угол наклона  текста
     * @param array  $pos     Позиция текста
     * @param array  $maxsize Размер картинки
     *
     * @return void
     */
    public function setText($text, $rota = 0, $pos = [0, 0], $maxsize = [500, 40])
    {
        $sizof = round($maxsize[0] / mb_strlen($text[0]));
        imagettftext(
            $this->_image,
            $sizof > $maxsize[0] ? $maxsize[1] : $sizof,
            $rota,
            $pos[0],
            $pos[1],
            $text[2],
            $text[1],
            $text[0]
        );
    }
}
