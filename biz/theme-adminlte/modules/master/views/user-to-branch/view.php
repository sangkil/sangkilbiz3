<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\master\models\User2Branch $model
 */

$this->title = $model->idBranch->nm_branch.' vs '. $model->idUser->username;
$this->params['breadcrumbs'][] = ['label' => 'User2 Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user2-branch-view col-lg-8">
    <div class="box box-body">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_branch',
            'idBranch.nm_branch',
            'id_user',
            'idUser.username',
            'create_at',
            'create_by',
            'update_at',
            'update_by',
        ],
    ]) ?>
    </div>
    <div class="box-footer">
        <?= Html::a('Update', ['update', 'id_branch' => $model->id_branch, 'id_user' => $model->id_user], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_branch' => $model->id_branch, 'id_user' => $model->id_user], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
