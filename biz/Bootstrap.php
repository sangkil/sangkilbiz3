<?php

namespace biz;

use Yii;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap implements \yii\base\BootstrapInterface
{
    private static $_bootstrap = [
        'biz\app\Bootstrap',
        'biz\master\Bootstrap',
        'biz\purchase\Bootstrap',
        'biz\inventory\Bootstrap',
        'biz\sales\Bootstrap',
        'biz\accounting\Bootstrap',
    ];

    /**
     *
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $bizPath = __DIR__;
        Yii::setAlias('biz/app', $bizPath . '/app');
        Yii::setAlias('biz/master', $bizPath . '/master');
        Yii::setAlias('biz/purchase', $bizPath . '/purchase');
        Yii::setAlias('biz/inventory', $bizPath . '/inventory');
        Yii::setAlias('biz/sales', $bizPath . '/sales');
        Yii::setAlias('biz/accounting', $bizPath . '/accounting');
        Yii::setAlias('biz/adminlte', $bizPath . '/theme-adminlte');

        foreach (static::$_bootstrap as $class) {
            $component = Yii::createObject($class);
            if ($component instanceof \yii\base\BootstrapInterface) {
                Yii::trace("Bootstrap with " . get_class($component) . '::bootstrap()', __METHOD__);
                $component->bootstrap($app);
            } else {
                Yii::trace("Bootstrap with " . get_class($component), __METHOD__);
            }
        }
    }
}
