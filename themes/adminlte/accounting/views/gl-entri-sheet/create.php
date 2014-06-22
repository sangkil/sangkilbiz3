<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\GlHeader $model
 */

$this->title = 'Create Gl Header';
$this->params['breadcrumbs'][] = ['label' => 'Gl Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gl-header-create col-lg-8">
    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'es'=>$es,
        'sheets'=>$sheets
    ]) ?>

</div>
