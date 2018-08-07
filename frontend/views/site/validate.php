<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Проверка';
$code        = Yii::$app->cache->get(Yii::$app->session->get('email'));
$url         = Url::to('/site/validate?code=' . $code);
?>
<div class="site-validate" align="center">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Перейдите по ссылке: </p>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <?php echo Html::a($code, $url) ?>
        </div>
    </div>
</div>
