<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property int $user_id
 * @property string $FIO ФИО
 * @property string $phone_number Контактный телефон
 * @property string $message
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class Application extends \yii\db\ActiveRecord
{
    public $email;
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {

        return [
            [['user_id', 'status'], 'integer'],
            [['FIO', 'phone_number', 'message'], 'required'],
            [['created_at', 'updated_at', 'verifyCode'], 'safe'],
            ['email', 'emailValidate'],
            ['email', 'email'],
            [['FIO', 'phone_number', 'email'], 'string', 'max' => 255],
            ['phone_number', 'match', 'pattern' => '/^((\+?7|8)(?!95[4-79]|99[08]|907|94[^0]|336)([348]\d|9[0-6789]|7[0247])\d{8}|\+?(99[^4568]\d{7,11}|994\d{9}|9955\d{8}|996[57]\d{8}|9989\d{8}|380[34569]\d{8}|375[234]\d{8}|372\d{7,8}|37[0-4]\d{8}))$/', 'message' => 'Неправильный формат телефона'],
            [['message'], 'string', 'max' => 1000],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function emailValidate($attribute, $params, $validator)
    {
        if ($this->$attribute !== Yii::$app->user->identity->email)
        {
            $this->addError($attribute, 'Данный email не совпадает с Вашим email-ом');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'user_id'      => 'User ID',
            'email'        => 'Email',
            'FIO'          => 'ФИО',
            'phone_number' => 'Контактный телефон',
            'message'      => 'Текст',
            'status'       => 'Status',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ApplicationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApplicationQuery(get_called_class());
    }
}