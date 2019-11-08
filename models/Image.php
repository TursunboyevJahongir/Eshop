<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property int $product_id
 * @property string $path
 * @property string $thumb_1024
 * @property string $thumb_256
 *
 * @property Product $product
 * @property Product[] $products
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id'], 'integer'],
            [['path', 'thumb_1024', 'thumb_256'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'path' => 'Path',
            'thumb_1024' => 'Thumb 1024',
            'thumb_256' => 'Thumb 256',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['defoult_image' => 'id']);
    }
}
