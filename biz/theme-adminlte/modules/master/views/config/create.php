<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\master\models\GlobalConfig $model
 */

$this->title = 'Create Global Config';
$this->params['breadcrumbs'][] = ['label' => 'Global Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="global-config-create col-lg-8">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
