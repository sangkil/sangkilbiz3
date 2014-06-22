<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\models\User2Branch $model
 */
$this->title = 'User2 Branch #' . $model->id_branch;
$this->params['breadcrumbs'][] = ['label' => 'User2 Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user2-branch-view col-lg-6">
    <div class="box box-info no-padding">
        <?=
        DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-striped '],
            'template' => '<tr><th style="width:25%;">{label}</th><td>{value}</td></tr>',
            'attributes' => [
                'idBranch.nm_branch',
                'idUser.username',
                'idUser.email',
                'create_date',
                'create_by'
            ],
        ])
        ?>
        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id_branch' => $model->id_branch, 'id_user' => $model->id_user], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id_branch' => $model->id_branch, 'id_user' => $model->id_user], [
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
