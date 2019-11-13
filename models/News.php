<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $shop_id
 * @property string $title
 * @property string $body
 * @property string $image
 * @property string $thumb_128
 * @property string $thumb_255
 * @property string $thumb_1024
 * @property int $view
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Shop $shop
 */
class News extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::className()]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shop_id', 'view', 'created_at', 'updated_at'], 'integer'],
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['title', 'image', 'thumb_128', 'thumb_255', 'thumb_1024'], 'string', 'max' => 255],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Shop ID',
            'title' => 'Title',
            'body' => 'Body',
            'image' => 'Image',
            'thumb_128' => 'Thumb 128',
            'thumb_255' => 'Thumb 255',
            'thumb_1024' => 'Thumb 1024',
            'view' => 'View',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }
}
