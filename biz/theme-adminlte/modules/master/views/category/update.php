<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\master\models\Category $model
 */

$this->title = 'Update Category: ' . $model->id_category;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_category, 'url' => ['view', 'id' => $model->id_category]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update col-lg-8">


	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
