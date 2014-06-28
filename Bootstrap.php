<?php

namespace biz\dev;

use Yii;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap implements \yii\base\BootstrapInterface
{

    public function bootstrap($app)
    {
        $bootstraps = [
            'biz\app\Bootstrap',
            'biz\master\Bootstrap',
            'biz\purchase\Bootstrap',
            'biz\inventory\Bootstrap',
            'biz\sales\Bootstrap',
            'biz\accounting\Bootstrap',
        ];

        foreach ($bootstraps as $class) {
            /* @var $obj \yii\base\BootstrapInterface */
            $obj = Yii::createObject($class);
            if ($obj instanceof \yii\base\BootstrapInterface) {
                $obj->bootstrap($app);
            }
        }
    }
}