<?php

namespace biz\master\components;

use biz\master\models\UserToBranch;

/**
 * Description of UserProperties
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class UserProperties extends \biz\app\base\PropertiBehavior
{

    protected function getUserProperties()
    {
        $properties = [];
        $userId = $this->owner->getId();
        if ($userId !== null) {
            $properties = [
                'branchs' => UserToBranch::find()
                    ->select('id_branch')
                    ->where(['id_user' => $userId])
                    ->column(),
            ];

            $properties['branch'] = \Yii::$app->getSession()->get('_branch_active');
            $properties['branch'] = 1;
        }
        return $properties;
    }
}