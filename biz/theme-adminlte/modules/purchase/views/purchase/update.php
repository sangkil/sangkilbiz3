<?php

/**
 * @var yii\web\View $this
 * @var biz\models\Purchase $model
 */

$this->title = 'Update Purchase: ' . $model->purchase_num;
$this->params['breadcrumbs'][] = ['label' => 'Purchase', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->purchase_num, 'url' => ['view', 'id' => $model->id_purchase]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchase-hdr-update">

	<?php echo $this->render('_form', [
        'model' => $model,
        'details'=>$details
    ]); ?>

</div>
