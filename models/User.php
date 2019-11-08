<?php

namespace app\models;

use Yii;
use yii\base\Behavior;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property integer $created_at
 * @property integer $updated_at
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
            [['first_name', 'last_name', 'password', 'phone'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 40],
            [['created_at', 'updated_at'], 'number'],
            [['address_id'], 'number'],
            [['password'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 12],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address_id' => 'AddressId',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'password' => 'Password',
            'phone' => 'Phone',
            'email' => 'Email'
        ];
    }


}
