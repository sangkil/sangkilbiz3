<?php

namespace biz;

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
            'biz\tools\Bootstrap'
        ];

        foreach ($bootstraps as $class) {
            /* @var $obj \yii\base\BootstrapInterface */
            $obj = new $class;
            $obj->bootstrap($app);
        }
    }
}