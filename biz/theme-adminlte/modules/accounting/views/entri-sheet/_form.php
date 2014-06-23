<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use biz\models\Coa;
use biz\models\EntriSheetDtl;
use yii\bootstrap\Modal;
use biz\tools\Helper;

/**
 * @var yii\web\View $this
 * @var biz\models\\EntriSheet $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="entri-sheet-form col-lg-4">
    <div class="box box-danger">
        <div class="box-body">
            <?= $form->field($model, 'cd_esheet')->textInput(['maxlength' => 4]) ?>
            <?= $form->field($model, 'nm_esheet')->textInput(['maxlength' => 32]) ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<!-- Tab panes -->
<div class="col-lg-8">
    <div class="box box-info">
        <div class="box-header">
            <i class="fa fa-cogs"></i>
            <h3 class="box-title">Detail Account</h3>
        </div>
        <div class="box-body no-padding">
            <?php
//            if ($model->isNewRecord):
//                echo 'Save header first..';
//            else:
            echo (!$model->isNewRecord) ? '<a class=" pull-right" data-toggle="modal" data-target="#myModal" style="padding:10px; padding-right:20px"><i class="glyphicon glyphicon-plus"></i></a>' : '';
            $dESheetD = new ActiveDataProvider([
                'query' => $model->getEntriSheetDtls(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            echo GridView::widget([
                'dataProvider' => $dESheetD,
                'tableOptions' => ['class' => 'table table-striped'],
                'layout' => '{items}',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nm_esheet_dtl',
                    //'idCoa.cd_account',
                    'idCoa.nm_account',
                    //'idCoa.normal_balance',
                //['class' => 'biz\master\components\ActionColumn'],
                ],
            ]);

//            endif;
            ?>
        </div>
    </div>
</div>
<?php
ActiveForm::end();

Modal::begin([
    'id' => 'myModal',
    'header' => '<h2 class="modal-title">Entri-Sheet Detail</h2>@' . $model->nm_esheet
]);

$esd_model = new EntriSheetDtl;
?>
<?php $form2 = ActiveForm::begin(); ?>
<div class="modal-body">
    <?= $form->field($esd_model, 'id_esheet')->hiddenInput(['value' => $model->id_esheet])->label(false) ?>
    <?php
    //$dcoa = new Coa;
    $list = Helper::getGroupedCoaList();
    //$list = ['Swedish Cars' => ['1' => 'volvo', '2' => 'Saab'], 'German Cars' => ['3' => 'Mercedes']]; 
    //$list = ArrayHelper::map(Coa::find()->orderBy('cd_account ASC')->all(), 'id_coa', 'nm_account');
    ?>
    <?= $form2->field($esd_model, 'id_coa')->dropDownList($list); ?>
    <?= $form2->field($esd_model, 'nm_esheet_dtl')->textInput(['style' => 'width:160px;']) ?>
</div>    
<div class="form-group modal-footer" style="text-align: right; padding-bottom: 0px;">
    <?= Html::submitButton($esd_model->isNewRecord ? 'Create' : 'Update', ['class' => $esd_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php
ActiveForm::end();
Modal::end();
