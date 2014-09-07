<?php

namespace biz\master\components;

use biz\master\models\UserToBranch;

/**
 * Description of UserProperties
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class UserProperties extends \yii\base\Behavior
{
    const KEY_BRANCH = '_branch_active';

    private $_branchs;

    public function getBranchs()
    {
        if ($this->_branchs === null) {
            $this->_branchs = UserToBranch::find()
                ->select('id_branch')
                ->where(['id_user' => $this->owner->getId()])
                ->column();
        }
        return $this->_branchs;
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
            $branchs = $this->getBranchs();
            $this->_branch = \Yii::$app->getSession()->get(self::KEY_BRANCH, reset($branchs));
            if (!empty($this->_branch)) {
                \Yii::$app->getSession()->set(self::KEY_BRANCH, $this->_branch);
            }
        }
        return $this->_branch;
    }
}