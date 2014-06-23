<?php

namespace biz\sales\assets;

/**
 * Description of Asset
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class StandartAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@biz/sales/assets/dist';
    public $js = [
        'js/sales.standart.js'
    ];
    public $depends = [
        'biz\master\assets\BizAsset'
    ];

}