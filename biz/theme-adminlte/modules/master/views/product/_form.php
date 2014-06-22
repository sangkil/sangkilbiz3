<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use biz\models\Category;
use biz\models\ProductGroup;
use yii\bootstrap\Modal;
use biz\models\Uom;
use biz\models\ProductUom;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var biz\models\Product $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="product col-lg-7">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Product</h3>
        </div>

        <div class="box-body">

            <?= $form->field($model, 'cd_product')->textInput(['maxlength' => 13, 'style' => 'width:160px;']) ?>

            <?= $form->field($model, 'nm_product')->textInput(['maxlength' => 64]) ?>

            <?= $form->field($model, 'id_category')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id_category', 'nm_category'), ['style' => 'width:200px;']); ?>

            <?= $form->field($model, 'id_group')->dropDownList(ArrayHelper::map(ProductGroup::find()->all(), 'id_group', 'nm_group'), ['style' => 'width:200px;']); ?>

        </div>   

    </div>

</div>

<div class="col-lg-5">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active btn-finish"><a href="#uoms" data-toggle="tab">Uoms</a></li>
            <li><a href="#aliases" data-toggle="tab">Aliases</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="uoms">
                <?php echo $this->render('_isi',['model'=>$model]);?>                
            </div>
            <div class="tab-pane" id="aliases">                
                <?php echo $this->render('_alias',['model'=>$model]);?> 
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php
ActiveForm::end();

Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Product Uoms</h4>@' . $model->nm_product
]);
$umodel = new ProductUom;
?>
<?php $form2 = ActiveForm::begin(); ?>
<div class="modal-body">
    <?= $form2->field($umodel, 'id_product')->hiddenInput(['value' => $model->id_product])->label(false) ?>    
    <?= $form2->field($umodel, 'id_uom')->dropDownList(ArrayHelper::map(Uom::find()->all(), 'id_uom', 'nm_uom'), ['style' => 'width:200px;']); ?>
    <?= $form2->field($umodel, 'isi')->textInput(['style' => 'width:120px;']) ?>
</div>    
<div class="form-group modal-footer" style="text-align: right; padding-bottom: 0px;">
    <?= Html::submitButton($umodel->isNewRecord ? 'Create' : 'Update', ['class' => $umodel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php
ActiveForm::end();
Modal::end();

//=========================
Modal::begin([
    'id' => 'aliasModal',
    'header' => '<h4 class="modal-title">Product Alias</h4>@parent:' . $model->nm_product
]);
$amodel = new \biz\models\ProductChild;
?>

<?php $form3 = ActiveForm::begin(); ?>
<div class="modal-body">
    <?= $form3->field($amodel, 'id_product')->hiddenInput(['value' => $model->id_product])->label(false) ?>    
    <?= $form3->field($amodel, 'barcode')->textInput(['style' => 'width:120px;']); ?>
    <?= $form3->field($amodel, 'nm_product')->textInput() ?>
</div>    
<div class="form-group modal-footer" style="text-align: right; padding-bottom: 0px;">
    <?= Html::submitButton($amodel->isNewRecord ? 'Create' : 'Update', ['class' => $amodel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php
ActiveForm::end();
Modal::end();
