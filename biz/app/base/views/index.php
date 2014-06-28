<?php

use yii\helpers\Html;
use yii\helpers\Inflector;

/* @var $this \yii\web\View */
/* @var $generators \yii\gii\Generator[] */
/* @var $content string */

$this->title = Yii::$app->controller->module->uniqueId;
?>
<div class="default-index">
    <div class="page-header">
        <h1>Welcome to module <?= $this->title; ?> <small><?= $moduleDescription; ?></small></h1>
    </div>

    <div class="row">
        <?php foreach ($controllers as $id => $description): ?>
            <div class="generator col-lg-4">
                <h3><?= Html::encode(Inflector::camel2words($id, true)) ?></h3>
                <p><?= $description ?></p>
                <p><?= Html::a('Start »', [$prefixRoute . $id], ['class' => 'btn btn-default']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</div>
