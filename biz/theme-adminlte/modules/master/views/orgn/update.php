<?php

/**
 * @var yii\web\View $this
 * @var biz\models\Orgn $model
 */

$this->title = 'Update Orgn: ' . $model->id_orgn;
$this->params['breadcrumbs'][] = ['label' => 'Orgns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_orgn, 'url' => ['view', 'id' => $model->id_orgn]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="orgn-update col-lg-8">
	<?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
