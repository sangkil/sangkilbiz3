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
    const KEY_BRANCH = '_branch_active';

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
        }

        return $properties;
    }
    private $_branch;

    public function setBranch($value)
    {
        $this->_branch = $value;
        \Yii::$app->getSession()->set(self::KEY_BRANCH, $value);
    }

    public function getBranch()
    {
        if ($this->_branch === null) {
            $branchs = $this->branchs;
            $this->_branch = \Yii::$app->getSession()->get(self::KEY_BRANCH, reset($branchs));
            \Yii::$app->getSession()->set(self::KEY_BRANCH, $this->_branch);
        }
        return $this->_branch;
    }
}