<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
    }

    public function generateCode()
    {
        \Yii::$app->session->set('email', $this->email);
        \Yii::$app->cache->set($this->email, \Yii::$app->security->generateRandomString(), 3600);
    }


}
