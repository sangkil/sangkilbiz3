<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\models\Coa $model
 */
$this->title = $model->id_coa;
$this->params['breadcrumbs'][] = ['label' => 'Coas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coa-view col-lg-6">
    <div class="box box-info">
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id_coa',
                    'id_parent',
                    'cd_account',
                    'nm_account',
                    'coa_type',
                    'normal_balance',
                    'create_at',
                    'create_by',
                    'update_at',
                    'update_by',
                ],
            ])
            ?>
        </div>
        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id' => $model->id_coa], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id_coa], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

</div>
