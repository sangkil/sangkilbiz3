<?php

namespace biz\sales\components;

use biz\sales\models\SalesHdr;
use biz\sales\models\Cashdrawer;

/**
 * Description of AccessHandler
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class AccessHandler extends \biz\master\base\AccessHandler
{

    protected function checkAction($user, $action, $model)
    {
        return true;
    }

    public function modelClasses()
    {
        return[
            SalesHdr::className(),
            Cashdrawer::className(),
        ];
    }
}