<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "shop".
 *
 * @property int $id
 * @property string $name
 * @property int $phone
 * @property string $password
 * @property string $description
 * @property string $longitude
 * @property string $latitude
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Follower[] $followers
 * @property News[] $news
 * @property Product[] $products
 */
class Shop extends ActiveRecord
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
        return 'shop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'password', 'description'], 'required'],
            [['phone', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'longitude', 'latitude'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 40],
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
            'phone' => 'Phone',
            'password' => 'Password',
            'description' => 'Description',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowers()
    {
        return $this->hasMany(Follower::className(), ['shop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['shop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['shop_id' => 'id']);
    }
}
