<?php

/* @var $model biz\models\GlHeader */
/* @var $this yii\web\View */
/* @var $details biz\models\GlDetails[] */

$this->title = 'Create Gl Header';
$this->params['breadcrumbs'][] = ['label' => 'Gl Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gl-header-create col-lg-8">

    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'dcoas'=>$dcoas
    ]) ?>

</div>
