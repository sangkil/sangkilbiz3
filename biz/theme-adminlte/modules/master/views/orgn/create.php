<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\Orgn $model
 */

$this->title = 'Create Orgn';
$this->params['breadcrumbs'][] = ['label' => 'Orgns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orgn-create col-lg-8">

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
