<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "advertise".
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string $image
 * @property string $thumb_128
 * @property string $thumb_255
 * @property string $thumb_1024
 * @property int $created_at
 * @property int $updated_at
 */
class Advertise extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertise';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'image', 'thumb_128', 'thumb_255', 'thumb_1024'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'Body',
            'image' => 'Image',
            'thumb_128' => 'Thumb 128',
            'thumb_255' => 'Thumb 255',
            'thumb_1024' => 'Thumb 1024',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
