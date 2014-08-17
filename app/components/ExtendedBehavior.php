<?php

namespace app\components;

use Yii;
use yii\db\BaseActiveRecord;
use yii\validators\Validator;
use yii\base\InvalidConfigException;

/**
 * Description of ExtendedBehavior
 *
 * @property \yii\db\BaseActiveRecord $owner
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class ExtendedBehavior extends \yii\base\Behavior
{
    /**
     *
     * @var \yii\db\BaseActiveRecord
     */
    private $_relation;

    /**
     *
     * @var string
     */
    public $relationClass;

    /**
     *
     * @var array
     */
    public $relationKey;

    public function events()
    {
        return[
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    public function attach($owner)
    {
        parent::attach($owner);
        $this->loadRelation();
        $validators = $owner->validators;
        foreach ($this->_relation->rules() as $rule) {
            if ($rule instanceof Validator) {
                $validators->append($rule);
            } elseif (is_array($rule) && isset($rule[0], $rule[1])) { // attributes, validator type
                $validator = Validator::createValidator($rule[1], $owner, (array) $rule[0], array_slice($rule, 2));
                $validators->append($validator);
            } else {
                throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
            }
        }
    }

    public function canGetProperty($name, $checkVars = true)
    {
        return $this->_relation->canGetProperty($name, $checkVars) || parent::canGetProperty($name, $checkVars);
    }

    public function canSetProperty($name, $checkVars = true)
    {
        return $this->_relation->canSetProperty($name, $checkVars) || parent::canSetProperty($name, $checkVars);
    }

    public function __get($name)
    {
        if ($this->_relation->canGetProperty($name)) {
            return $this->_relation->$name;
        } else {
            return parent::__get($name);
        }
    }

    public function __set($name, $value)
    {
        if ($this->_relation->canGetProperty($name)) {
            $this->_relation->$name = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    private function loadRelation()
    {
        if ($this->relationKey === null) {
            $this->relationKey = [];
            foreach ($this->owner->primaryKey() as $name) {
                $this->relationKey[$name] = $name;
            }
        }
        /* @var $class \yii\db\BaseActiveRecord */
        $class = $this->relationClass;
        if ($this->owner->isNewRecord) {
            $this->_relation = Yii::createObject($class);
        } else {
            $conditions = [];
            foreach ($this->relationKey as $from => $to) {
                $conditions[$to] = $this->owner[$from];
            }

            if (($this->_relation = $class::findOne($conditions)) === null) {
                $conditions['class'] = $class;
                $this->_relation = Yii::createObject($conditions);
            }
        }
    }

    /**
     *
     * @param \yii\base\Event $event
     */
    public function afterSave($event)
    {
        foreach ($this->relationKey as $from => $to) {
            $this->_relation[$to] = $this->owner[$from];
        }
        $this->_relation->save();
    }

    public function afterDelete($event)
    {
        $this->_relation->delete();
    }
}
