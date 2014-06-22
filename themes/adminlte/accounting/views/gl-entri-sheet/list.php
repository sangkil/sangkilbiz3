<?php
use yii\helpers\Html;

/* @var $sheet biz\models\EntriSheet */

$links = [];
foreach ($sheets as $sheet) {
    $links[] = Html::tag('li', Html::a($sheet->nm_esheet, ['create','es'=>$sheet->id_esheet]));
}
echo Html::tag('ul', implode("\n", $links));