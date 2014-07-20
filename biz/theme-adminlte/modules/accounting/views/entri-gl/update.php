<?php

/**
 * @var yii\web\View $this
 * @var biz\models\GlHeader $model
 */
$this->title = 'Update GL: ' . ' ' . $model->id_gl;
$this->params['breadcrumbs'][] = ['label' => 'Gl Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_gl, 'url' => ['view', 'id' => $model->id_gl]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gl-header-update col-lg-8">

    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'dcoas'=>$dcoas
    ])
    ?>

</div>
