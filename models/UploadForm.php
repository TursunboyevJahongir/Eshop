<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $img;

    public function rules()
    {
        return [
            [['img'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg,jpeg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $imgpath = 'uploads/';
            $imgname =  $this->img->baseName . time().'.' . $this->img->extension;
            $this->img->saveAs($imgpath.$imgname);
            return ['path' => $imgpath, 'name' => $imgname];
        } else {
            return false;
        }

    }
}