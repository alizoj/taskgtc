<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use frontend\models\SignupForm;
use common\models\Application;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['login', 'validate', 'index'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['login', 'validate',],
                        'roles'   => ['?'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['index',],
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => null,
            ],
        ];
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->generateCode();

            return $this->render('validate');
        }
        else
        {
            $model->email = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs in a user.
     *
     * @param null $code
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionValidate($code = null)
    {
        $email = Yii::$app->session->get('email');
        if (!$email || Yii::$app->cache->get($email) !== $code)
        {
            return $this->goHome();
        }

        $model        = new SignupForm();
        $model->email = $email;

        $user = User::findOne(['email' => $email]);
        if (!$user)
        {
            $user         = new User();
            $user->status = User::STATUS_ACTIVE;
            $user->email  = $email;
            $user->setPassword('1q2w3e4r');
            $user->generateAuthKey();
            if ($user->save())
            {
                Yii::$app->user->login($user);
            }
        }
        else
        {
            Yii::$app->user->login($user);
        }

        Yii::$app->session->remove('email');
        Yii::$app->cache->delete($email);

        return $this->goHome();
    }

    /**
     * Lists all Application models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model          = new Application();
        $model->user_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->user->logout();

            return $this->goHome();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

}
