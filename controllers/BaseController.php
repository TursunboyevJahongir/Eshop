<?php
/**
 * Jahongir Tursunboyev
 * https://github.com/TursunboyevJahongir
 */

namespace app\controllers;


use yii\imagine\Image;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * function Thumb to return
     * @param $image
     * @param $size
     * @param $path
     */
    protected function Thumb($image,$size,$path)
    {
//        $path = '/uploads/';
        Image::thumbnail($_SERVER['DOCUMENT_ROOT'] . '/web' . $path . $image, $size, $size, 0)->save($_SERVER['DOCUMENT_ROOT'] . '/web/' . $path .$size .'_'. $image);
        return $path.$size.'_'.$image;
    }
}