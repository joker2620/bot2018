<?php

declare(strict_types=1);

namespace joker2620\Source\Plugins\AutoSing;

use joker2620\Source\Setting\Config;

/**
 * Class SignArt.
 */
class SignArt
{
    private $imgDir;

    private $image;

    private $data;

    /**
     * SignArt constructor.
     */
    public function __construct()
    {
        $this->imgDir = Config::getConfig()['DIR_IMAGES'].'/sign/';
        $this->image = null;
    }

    /**
     * generate().
     *
     * @param string $text
     * @param array  $color
     * @param string $fonts
     *
     * @return string
     */
    public function generate(
        string $text,
        array $color = [0, 0, 0],
        string $fonts = 'PFKidsPro-GradeOne.ttf'
    ) {
        $fonts = $this->imgDir.$fonts;
        $this->getRandImg();
        $color = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
        $sizof = round($this->data[1] / mb_strlen($text));
        imagettftext(
            $this->image,
            $sizof > $this->data[1] ? $this->data[2] : $sizof,
            $this->data[5],
            $this->data[3],
            $this->data[4],
            $color,
            $fonts,
            $text
        );
        $fileimage = $this->imgDir.date('his').'.png';
        imagepng($this->image, $fileimage);
        imagedestroy($this->image);

        return $fileimage;
    }

    public function getRandImg()
    {
        $base_art = include 'Config.php';
        $datas = $base_art[array_rand($base_art)];
        $files = $this->imgDir.$datas[0];
        $this->image = imagecreatefrompng($files);
        $this->data = $datas;
    }

    /**
     * imageDestroy().
     *
     * @param string $file_image
     */
    public function imageDestroy(string $file_image)
    {
        if (file_exists($file_image)) {
            unlink($file_image);
        }
    }
}
