<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DAO\StudentsDAO */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Students');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="students-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p class="btn-create">
        <?= Html::a(Yii::t('app', 'Create Students'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            //'id',
        'name',
        'birthday:date',
            //'schedule',
        [
            'attribute' => 'schedule',
            'value' => function($model){
                return $model->getShedules()->shedules;
            },    
        ],
        [
            'attribute' => 'reports',
            'format' => 'html',
            'value' => function($model){    
                return $model -> getHtmlBotaoEscreverRelatorio();
            }
        ],
        [
            'attribute' => 'pdf',
            'format' => 'html',
            'value' => function($model){    
                return $model -> getHtmlBotaoGerarRelatorio();
            }
        ],
        
        [
            'class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>
    </div>
