<?php

namespace biz\purchase\components;

use biz\purchase\models\PurchaseHdr;

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

    public function modelClasses()
    {
        return[
            PurchaseHdr::className()
        ];
    }
}