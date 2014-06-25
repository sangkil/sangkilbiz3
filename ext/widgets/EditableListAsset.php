<?php

namespace biz\dev\ext\widgets;

/**
 * Description of DetailListViewAsset
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class EditableListAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@biz/dev/ext/widgets/assets';
    public $js = [
        'mdm.editableList.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}