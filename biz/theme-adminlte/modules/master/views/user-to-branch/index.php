<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\grid\DataColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\searchs\User2Branch $searchModel
 */
$this->title = 'User2 Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-to-branch-index">
    <div class="col-lg-12" style="text-align: right; padding-bottom: 10px;">
        <?= Html::a('', ['create'], ['class' => 'btn btn-warning btn-sm fa fa-plus', 'title' => 'New User to Branch']) ?>
    </div>
    <div class="col-lg-12">
        <?php Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
        <div class="box box-danger">
            <div class="box-body no-padding">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'idBranch.nm_branch',
                        'idUser.username',
                        'idUser.email',
                        [
                            'class' => DataColumn::className(),
                            'label' => 'Is Active',
                            'value' => function ($model) {
                        switch ($model->is_active) {
                            case 0:
                                $dret = '<div class="icheckbox_flat-red disabled" style="position: relative;" aria-checked="false" aria-disabled="true">
                                        <input class="flat-red" type="checkbox" disabled="" style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins>
                                        </div>';
                                break;
                            case 1:
                                $dret = '<div class="icheckbox_flat-green checked" style="position: relative;" aria-checked="true" aria-disabled="false">
                                        <input class="flat-green" type="checkbox" checked="" style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins>
                                        </div>';
                                break;
                        }
                        return $dret;
                    },
                            'format' => 'raw'
                        ],
                        //'is_active',
                        'create_date',
                        'create_by',
                        //'update_date',
                        // 'update_by',
                        ['class' => 'biz\master\components\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>
        <?php
        // display pagination
        echo LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination pagination-sm no-margin']
        ]);
        Pjax::end();
        ?>
    </div>
</div>
