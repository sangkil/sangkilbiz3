<?php
namespace biz\app\base;
/**
 * Description of PropertiBehavior
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class PropertiBehavior extends \yii\base\Behavior
{
    /**
     *
     * @var array 
     */
    private $_properties;
    
    protected function getUserProperties()
    {
        throw new \yii\base\NotSupportedException();
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