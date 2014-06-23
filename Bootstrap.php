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
            'biz\master\Bootstrap',
        ];

        foreach ($bootstraps as $class) {
            /* @var $obj \yii\base\BootstrapInterface */
            $obj = Yii::createObject($class);
            $obj->bootstrap($app);
        }
    }
}