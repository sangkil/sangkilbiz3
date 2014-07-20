<?php

/**
 * @var yii\web\View $this
 * @var biz\master\models\Category $model
 */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create col-lg-8">

	<?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
