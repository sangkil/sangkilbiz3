<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model biz\accounting\models\Payment */

$this->title = 'Create Payment';
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'type' => $type,
        'jmlInv' => $jmlInv,
        'jmlPaid' => $jmlPaid,
        'jmlRemain' => $jmlRemain,
    ])
    ?>

</div>
