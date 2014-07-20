<?php

use biz\master\components\Helper;
use yii\widgets\ActiveForm;
use biz\models\GlDetail;
use yii\helpers\Html;

/* @var $model biz\models\GlHeader */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $details biz\models\GlDetails[] */
?>
<div class="gl-header-form">
    <?php
    $form = ActiveForm::begin();
    echo $form->errorSummary($model);
    ?>
    <div class="box box-info no-padding">
        <div class="box-body">
            <div class="col-lg-5">
                <?php
                echo $form->field($model, 'glDate')
                        ->widget('yii\jui\DatePicker', [
                            'options' => ['class' => 'form-control', 'style' => 'width:50%'],
                            'clientOptions' => [
                                'dateFormat' => 'dd-mm-yy'
                            ],
                ]);
                ?>
                <?= $form->field($model, 'id_branch')->dropDownList(Helper::getBranchList()); ?>
            </div>
            <div class="col-lg-7">
                <?= $form->field($model, 'id_periode')->textInput(['style' => 'width:30%']) ?>
                <?= $form->field($model, 'description')->textarea() ?>
            </div>
        </div>
        <table class ="table table-striped" id="tbl-gldetail">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Account</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th><a class="fa fa-plus-square" href="#"></a></th>
                </tr>
                <?php

                /**
                 *
                 * @param biz\models\GlDetail $model
                 * @param integer $index
                 * @return string
                 */
                function renderRow($model, $index)
                {
                    ob_start();
                    ob_implicit_flush(false);
                    ?>
                    <tr>
                        <?= Html::activeHiddenInput($model, "[$index]id_gl_detail") ?>
                        <td class="serial"><?= $index ?></td>
                        <td>
                            <?= Html::activeHiddenInput($model, "[$index]id_coa",['class'=>'id_account']) ?>
                            <?= Html::activeTextInput($model, "[$index]idCoa[nm_account]", ['class' => 'nm_account', 'style' => 'width:260px']) ?>&nbsp;
                            <span class="cd_account"><?= \yii\helpers\ArrayHelper::getValue($model, 'idCoa.cd_account'); ?></span>
                        </td>
                        <td><?= Html::activeTextInput($model, "[$index]debit", ['style' => 'width:90px']) ?></td>
                        <td><?= Html::activeTextInput($model, "[$index]kredit", ['style' => 'width:90px']) ?></td>
                        <td class="action"><a class="fa fa-minus-square-o" href="#"></a></td>
                    </tr>
                    <?php

                    return trim(preg_replace('/>\s+</', '><', ob_get_clean()));
                }
                ?>
            </thead>
            <?php
            $rows = [];

            foreach ($details as $index => $detail) {
                $rows[] = renderRow($detail, $index);
            }
            echo Html::tag('tbody', implode("\n", $rows), ['data-template' => renderRow(new GlDetail(), '_index_')])
            ?>

        </table>

        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
\yii\jui\AutoCompleteAsset::register($this);
\yii\jui\ThemeAsset::register($this);
\biz\accounting\components\EntryGlAsset::register($this);
biz\tools\BizDataAsset::register($this, [
    'master' => ['coas' => $dcoas]]);
