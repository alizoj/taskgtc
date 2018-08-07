<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Создать заявку';
?>
<div class="application-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
