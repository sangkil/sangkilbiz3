<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\BranchSearch $searchModel
 */
$this->title = 'Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-index">
    <div class="col-lg-4" style="float: right;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?> 
    </div>
    <div class="col-lg-12">
        <div class="box box-danger">
            <div class="box-body no-padding">
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id_branch',
                        'cd_branch',
                        'nm_branch',
                        ['class' => 'yii\grid\ActionColumn']
                    ]
                ]);
                ?>
            </div>
        </div>
    </div> 
</div>
<?php
$js = "\$('#kecilin').click();";
$this->registerJs($js);
