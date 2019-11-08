<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $region_id
 * @property int $category_id
 * @property int $shop_id
 * @property int $manufacture_id
 * @property string $name
 * @property double $price
 * @property int $defoult_image
 * @property string $description
 * @property int $discount
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Favourite[] $favourites
 * @property Image[] $images
 * @property OrderProduct[] $orderProducts
 * @property Popular[] $populars
 * @property Category $category
 * @property Manufacture $manufacture
 * @property Region $region
 * @property Shop $shop
 * @property Image $defoultImage
 * @property Recome[] $recomes
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id', 'category_id', 'shop_id', 'manufacture_id', 'defoult_image', 'discount', 'created_at', 'updated_at'], 'integer'],
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['manufacture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacture::className(), 'targetAttribute' => ['manufacture_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
            [['defoult_image'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['defoult_image' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'category_id' => 'Category ID',
            'shop_id' => 'Shop ID',
            'manufacture_id' => 'Manufacture ID',
            'name' => 'Name',
            'price' => 'Price',
            'defoult_image' => 'Defoult Image',
            'description' => 'Description',
            'discount' => 'Discount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourite::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPopulars()
    {
        return $this->hasMany(Popular::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacture()
    {
        return $this->hasOne(Manufacture::className(), ['id' => 'manufacture_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefoultImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'defoult_image']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecomes()
    {
        return $this->hasMany(Recome::className(), ['product_id' => 'id']);
    }
}
