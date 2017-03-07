<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Shedules */

$this->title = Yii::t('app', 'Create Shedules');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shedules-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
