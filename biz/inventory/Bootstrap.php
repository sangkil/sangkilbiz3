<?php

namespace biz\inventory;

use biz\master\tools\Helper;
use biz\inventory\components\AccessHandler;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap extends \biz\master\base\Bootstrap
{

    protected function autoDefineModule($app)
    {
        $app->setModule('inventory', Module::className());
    }

    protected function initialize($app, $config)
    {
        Helper::registerAccessHandler(AccessHandler::className());
    }
}