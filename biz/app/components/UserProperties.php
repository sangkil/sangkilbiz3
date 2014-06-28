<?php

namespace biz\app\components;

use biz\master\models\UserToBranch;

/**
 * Description of UserBehavior
 *
 * @property \yii\web\User $owner
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class UserProperties extends \yii\base\Behavior
{
    /**
     *
     * @var array 
     */
    private $_properties;

    private function initProperties()
    {
        if ($this->_properties === null) {
            $userId = $this->owner->getId();
            if ($userId !== null) {
                $this->_properties = [
                    'branchs' => UserToBranch::find()
                        ->select('id_branch')
                        ->where(['id_user' => $userId])
                        ->column(),
                ];

                $this->_properties['branch'] = \Yii::$app->getSession()->get('_branch_active');
                $this->_properties['branch'] = 1;
            } else {
                $this->_properties = [];
            }
        }
    }

    public function __get($name)
    {
        $this->initProperties();
        if (array_key_exists($name, $this->_properties)) {
            return $this->_properties[$name];
        } else {
            return parent::__get($name);
        }
    }

    public function canGetProperty($name, $checkVars = true)
    {
        $this->initProperties();
        return array_key_exists($name, $this->_properties) || parent::canGetProperty($name, $checkVars);
    }
}