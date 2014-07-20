<?php

namespace biz\sales\assets;

/**
 * Description of Asset
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class DrawerAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@biz/sales/assets/dist';
    public $js = [
        'js/sales.storage.js',
        'js/sales.drawer.js',
    ];
    public $depends = [
        'biz\app\assets\BizAsset'
    ];

}
