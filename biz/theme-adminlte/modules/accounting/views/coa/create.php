<?php

/**
 * @var yii\web\View $this
 * @var biz\models\Coa $model
 */
$this->title = 'Create Coa';
$this->params['breadcrumbs'][] = ['label' => 'Coas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coa-create col-lg-6">
    <?=
    $this->render('_form', [
        'model' => $model
    ])
    ?>
</div>
