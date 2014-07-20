<?php

namespace biz\inventory\assets;

/**
 * Description of TransferAsset
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class ReceiveAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@biz/inventory/assets/dist';
    public $js = [
        'js/inventory.receive.js'
    ];
    public $depends = [
        'biz\app\assets\BizAsset'
    ];

}
