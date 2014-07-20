<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model biz\accounting\models\GlHeader */

$this->title = $model->gl_num;
$this->params['breadcrumbs'][] = ['label' => 'Gl Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gl-header-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'glDate',
            'gl_num',
            'id_branch',
            'idPeriode.nm_periode',
            'description',
        ],
    ]) ?>
    <?= GridView::widget([
        'dataProvider' => Yii::createObject([
            'class'=>'yii\data\ActiveDataProvider',
            'query'=>$model->getGlDetails()]),
        'layout'=>'{items}',
        'columns'=>[
            'idCoa.cd_account',
            'idCoa.nm_account',
            'debit',
            'kredit'
        ]
    ]) ?>
</div>
