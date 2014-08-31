<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use biz\master\models\Branch;
use app\models\User;

/**
 * @var yii\web\View $this
 * @var biz\master\models\User2Branch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="box box-primary">
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= ''//$form->field($model, 'id_branch')->textInput() ?>
        <?= $form->field($model, 'id_branch')->dropDownList(ArrayHelper::map(Branch::find()->all(), 'id_branch', 'nm_branch')) ?>

        <?= ''//$form->field($model, 'id_user')->textInput() ?>
        <?php
            $listUser = User::find()->select('username')->asArray()->column();
            $dUser = [];
//            foreach ($listUser as $row) {
//                $dUser[]=$row['username'];
//            }
            echo $form->field($model, 'nmUser')
                ->widget('yii\jui\AutoComplete', [
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                        'source' => $listUser,
                    ]
        ]);
        ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
