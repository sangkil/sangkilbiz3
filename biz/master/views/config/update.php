<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\master\models\GlobalConfig $model
 */

$this->title = 'Update Global Config: ' . $model->group;
$this->params['breadcrumbs'][] = ['label' => 'Global Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->group, 'url' => ['view', 'group' => $model->group, 'name' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="global-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
