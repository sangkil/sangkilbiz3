<?php

namespace biz\app\assets;

use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Description of BizDataAsset
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class BizDataAsset
{

    /**
     *
     * @param View  $view
     * @param array $data
     */
    public static function register($view, $data = [], $position = View::POS_BEGIN)
    {
        $default = [
            'config' => [
                'delay' => 1000,
                'limit' => 20,
                'checkStock' => false,
                'debug' => YII_ENV == 'dev'
            ]
        ];
        $js = "\n biz = " . Json::encode(ArrayHelper::merge($default, $data)) . ";\n";
        $view->registerJs($js, $position);
    }
}
