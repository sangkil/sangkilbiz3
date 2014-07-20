<?php

/**
 * @var yii\web\View $this
 * @var biz\accounting\models\EntriSheet $model
 */
$this->title = 'Create Entri Sheet';
$this->params['breadcrumbs'][] = ['label' => 'Entri Sheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entri-sheet-create col-lg-8">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
