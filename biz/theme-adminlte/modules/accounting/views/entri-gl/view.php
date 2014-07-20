<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use biz\models\GlDetail;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\models\GlHeader $model
 */
$this->title = 'GL Detail #'.$model->id_gl;
$this->params['breadcrumbs'][] = ['label' => 'Gl Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gl-header-view col-lg-8">
    <div class="box box-info">
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-condensed'],
                'template' => '<tr><th style="width:25%;">{label}</th><td>{value}</td></tr>',
                'attributes' => [
//                    'id_gl',
                    'gl_num',
                    'glDate',
//                    'gl_memo',
                    'idBranch.nm_branch',
                    'idPeriode.nm_periode',
//                    'type_reff',
//                    'id_reff',
                    'description',
//                    'status',
//                    'create_at',
//                    'create_by',
//                    'update_at',
//                    'update_by',
                ],
            ])
            ?>
        </div>
        <div class="clearfix" style="border-bottom: 1px whitesmoke solid;"><br></div>
        <?php
        $form = ActiveForm::begin();
        ?>
        <table class ="table table-striped" id="tbl-gldetail">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Account</th>
                    <th style="text-align: right;">Debit</th>
                    <th style="text-align: right;">Credit</th>
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
                            <?= \yii\helpers\ArrayHelper::getValue($model, 'idCoa.cd_account'); ?>&nbsp;&nbsp;
                            <?= \yii\helpers\ArrayHelper::getValue($model, 'idCoa.nm_account'); ?>
                        </td>
                        <td style="text-align: right;">
                            <?= ''//\yii\helpers\ArrayHelper::getValue($model, 'debit'); ?>
                            <?= (\yii\helpers\ArrayHelper::getValue($model, 'debit')!=='')?  number_format((double) \yii\helpers\ArrayHelper::getValue($model, 'debit')):''; ?>
                        </td>
                        <td style="text-align: right;">
                            <?= ''//\yii\helpers\ArrayHelper::getValue($model, 'kredit'); ?>
                            <?= (\yii\helpers\ArrayHelper::getValue($model, 'kredit')!=='')?  number_format((double) \yii\helpers\ArrayHelper::getValue($model, 'kredit')):''; ?>
                        </td>
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
        <?php ActiveForm::end(); ?>
        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id' => $model->id_gl], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id_gl], [
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
<?php
\biz\accounting\components\EntryGlAsset::register($this);
