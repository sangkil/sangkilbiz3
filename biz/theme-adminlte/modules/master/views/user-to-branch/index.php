<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\master\models\searchs\User2Branch $searchModel
 */
$this->title = 'User2 Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user2-branch-index">
    <div class="branch-index">
        <div class="col-lg-4" style="float: right;">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?> 
        </div>
        <div class="col-lg-12">
            <div class="box box-danger">
                <div class="box-body no-padding">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ['class' => 'table table-striped'],
                        'layout' => '{items}',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label'=>'Branch Name',
                                'attribute'=>'idBranch.nm_branch'
                                ],
                            'idUser.username',
                            'idUser.email',
                            'create_at',
                            'create_by',
                            //'update_at',
                            // 'update_by',
                            ['class' => 'biz\app\components\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$js = "\$('#kecilin').click();";
$this->registerJs($js);
