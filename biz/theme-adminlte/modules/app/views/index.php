<?php

use yii\helpers\Html;
use yii\helpers\Inflector;

/* @var $this \yii\web\View */
/* @var $generators \yii\gii\Generator[] */
/* @var $content string */

$this->title = Yii::$app->controller->module->uniqueId;
?>

<?php foreach ($controllers as $id => $description): ?>
    <div class="col-md-4">
        <div class="generator box box-solid">
            <div class="box-header">
                <i class="fa fa-check"></i>
                <h3 class="box-title"><?= Html::encode(Inflector::camel2words($id, true)) ?></h3>                
            </div>
            <div class="box-body">
                <?= $description ?>
            </div>
            <div class="box-footer">
                <?= Html::a('Start »', [$prefixRoute . $id], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>