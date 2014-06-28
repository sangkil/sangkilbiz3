<?php

namespace biz\accounting\assets;

/**
 * Description of EntryGlAsset
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class EntryGlAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@biz/accounting/assets/dist';
    public $js = [
        'js/accounting.entrygl.js'
    ];
    public $depends = [
        'biz\master\assets\BizAsset',
    ];

}