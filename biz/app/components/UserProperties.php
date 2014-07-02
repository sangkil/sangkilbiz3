<?php

namespace biz\app\components;

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
    
    protected function getUserProperties()
    {
        
    }

    private function initProperties()
    {
        if ($this->_properties === null) {
            $this->_properties = $this->getUserProperties();
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