<?php

namespace biz\inventory\components;

use biz\inventory\models\Transfer;
use biz\inventory\models\TransferNotice;

/**
 * Description of AccessHandler
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class AccessHandler extends \biz\app\base\AccessHandler {

    protected function checkAction($user, $action, $model) {
        $class = get_class($model);
        switch ($class) {
            case Transfer::className():
                switch ($action) {
                    case 'issue':
                        if ($model->status < Transfer::STATUS_ISSUE) {
                            return true;
                        }
                        break;
                    default:
                        return true;
                        break;
                }
                break;

            default:
                break;
        }
        return true;
    }

}
