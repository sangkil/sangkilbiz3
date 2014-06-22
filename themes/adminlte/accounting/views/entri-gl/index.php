<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\searchs\GlHeader $searchModel
 */
$this->title = 'Gl Headers';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="gl-header-index">
    <div class="col-lg-4" style="float: right;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?> 
    </div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body no-padding">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Code</th>
                            <th>Nm Account</th>
                            <th style="width: 15%;">Debit</th>
                            <th style="width: 15%;">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        echo ListView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => '{items}',
                            'itemOptions' => ['class' => 'item'],
                            'itemView' => '_detailView',
                        ]);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
// display pagination
        echo LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination pagination-sm no-margin']
        ]);
        ?>
    </div>
</div>
<?php //Pjax::end(); ?>
<?php
$js = "\$('#kecilin').click();";
$this->registerJs($js);
