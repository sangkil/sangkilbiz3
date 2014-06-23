<?php

namespace biz\purchase;

use biz\master\tools\Helper;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap extends \biz\master\base\Bootstrap
{

    protected function autoDefineModule($app)
    {
        $app->setModule('purchase', Module::className());
    }

    protected function initialize($app, $config)
    {
        Helper::registerAccessHandler(components\AccessHandler::className());
    }
}