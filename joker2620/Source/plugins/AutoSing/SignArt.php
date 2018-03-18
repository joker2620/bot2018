<?php

/**
 * Проект: joker2620/bot2018
 * Author: Joker2620;
 * Date: 12.01.2018;
 * Time: 7:55;
 * PHP version 7.1;
 *
 * @category AutoSing
 * @package  Joker2620\Source\Plugins\AutoSing
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */

namespace joker2620\Source\Plugins\AutoSing;

use joker2620\Source\Exception\BotError;
use joker2620\Source\Setting\SustemConfig;

/**
 * Class signart
 *
 * @category AutoSing
 * @package  Joker2620\Source\Plugins\AutoSing
 * @author   Joker2620 <joker2000joker@list.ru>
 * @license  https://github.com/joker2620/bot2018/blob/master/LICENSE MIT
 * @link     https://github.com/joker2620/bot2018 #VKCHATBOT
 */
final class SignArt
{
    /**
     * Папка с картинками
     */
    private $imgDir;
    /**
     * Картинка
     */
    private $image;
    /**
     * Данные
     */
    private $data;

    /**
     * SignArt constructor.
     */
    public function __construct()
    {
        $this->imgDir = SustemConfig::getConfig()['DIR_IMAGES'] . '/sign/';
        $this->image  = null;
    }


    /**
     * Функция нанесения текста на изображение.
     *
     * @param string $text  Текст
     * @param array  $color Цвет текста
     * @param string $fonts Шрифт
     *
     * @return string
     * @throws BotError
     */
    public function generate(
        $text,
        $color = [0, 0, 0],
        $fonts = 'PFKidsPro-GradeOne.ttf'
    ) {
        if (!is_string($text) || !is_array($color) || !is_string($fonts)) {
            throw new BotError('Ошибка при вызове модуля SignArt');
        }
        $fonts = $this->imgDir . $fonts;
        $this->getRandImg();
        $color = $this->colors($color[0], $color[1], $color[2]);
        $this->setText(
            [$text, $fonts, $color],
            $this->data[5],
            [$this->data[3], $this->data[4]],
            [$this->data[1], $this->data[2]]
        );
        $fileimage = SustemConfig::getConfig()['DIR_IMAGES'] . '/image' . date('his') . '.png';
        imagepng($this->image, $fileimage);
        imagedestroy($this->image);
        return $fileimage;
    }

    /**
     * Функция получения случайного изображения
     *
     * @param $fileimage
     *
     * @return void
     */
    public function imageDestroy($file_image)
    {
      if (file_exists($file_image)) {
            unlink($file_image);
        }
    }

    /**
     * Функция получения случайного изображения
     *
     * @return void
     */
    public function getRandImg()
    {
        $base_art    = include 'Config.php';
        $datas       = $base_art[array_rand($base_art)];
        $files       = $this->imgDir . $datas[0];
        $this->image = imagecreatefrompng($files);
        $this->data  = $datas;
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
        return imagecolorallocate($this->image, $r, $g, $b);
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
            $this->image,
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
