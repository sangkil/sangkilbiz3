<?php

namespace biz\sales\components;

use biz\sales\models\Sales;
use biz\sales\models\Cashdrawer;

/**
 * Description of AccessHandler
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class AccessHandler extends \biz\app\base\AccessHandler
{

    protected function checkAction($user, $action, $model)
    {
        return true;
    }
}