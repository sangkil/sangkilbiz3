<?php
namespace biz\master\assets;

/**
 * Description of BarcodeCreatorAsset
 *
 * @author Mujib Masyhudi (sangkilsoft) <mujib.masyhudi@gmail.com>
 */
class MasterAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@biz/master/assets/dist';
    public $js = [
        'js/master.product.js',
        'js/jquery-barcode.min.js',
    ];
    
    public $css = [
        'css/biz.detail.css'
    ];
    
    public $depends = [
        'biz\app\assets\BizAsset'
    ];

}
