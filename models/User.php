<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $address_id
 * @property string $first_name
 * @property string $last_name
 * @property string $image
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Favourite[] $favourites
 * @property Follower[] $followers
 * @property Order[] $orders
 * @property OrderHistory[] $orderHistories
 * @property Address $address
 */
class User extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

//    public function behaviors()
//    {
//        return [
//            ['class' => TimestampBehavior::className()]
//        ];
//    }

    public function afterValidate()
    {
        parent::afterValidate();
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
        if ($this->isNewRecord) {
            $this->created_at = time();
            $this->updated_at = time();
        } else {
            $this->updated_at = time();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address_id', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'email', 'phone', 'password'], 'required'],
            [['first_name', 'last_name', 'image', 'email', 'password'], 'string', 'max' => 255],
            [['email'],'email'],
            [['phone'], 'string', 'max' => 20],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['image'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address_id' => 'Address ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'image' => 'Image',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourite::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowers()
    {
        return $this->hasMany(Follower::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHistories()
    {
        return $this->hasMany(OrderHistory::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }
}
