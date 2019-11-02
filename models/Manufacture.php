<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "manufacture".
 *
 * @property int $id
 * @property string $name
 * @property string $ico
 *
 * @property Product[] $products
 */
class Manufacture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manufacture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'] ,'required'],
            [['name', 'ico'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ico' => 'Ico',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['manufacture_id' => 'id']);
    }
}
