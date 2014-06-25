<?php

namespace biz\dev\ext\widgets;

/**
 * Description of RelationBehavior
 *
 * @property \yii\db\ActiveRecord $owner Description
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class RelationBehavior extends \yii\base\Behavior
{
    private $_relations = [];

    public function __call($name, $params)
    {
        if (strpos($name, 'save') === 0) {
            $relation = lcfirst(substr($name, 4));
            if (!array_key_exists($relation, $this->_relations)) {
                $this->_relations[$relation] = $this->owner->getRelation($relation, false);
            }
            if ($this->_relations[$relation] !== null) {
                array_unshift($params, $relation);
                return call_user_func_array([$this, 'doSaveRelation'], $params);
            }
        } else {
            return parent::__call($name, $params);
        }
    }

    public function hasMethod($name)
    {
        if (strpos($name, 'save') === 0) {
            $relation = lcfirst(substr($name, 4));
            if (!array_key_exists($relation, $this->_relations)) {
                $this->_relations[$relation] = $this->owner->getRelation($relation, false);
            }
            if ($this->_relations[$relation] !== null) {
                return true;
            }
        }
        return parent::hasMethod($name);
    }

    public function doSaveRelation($relation, $options = [])
    {
        $model = $this->owner;
        $relation = $this->_relations[$relation];
        /* @var $class \yii\db\ActiveRecord */
        $class = $relation->modelClass;
        $children = $relation->all();
        $saved = false;
        $message = false;

        if ($post = Yii::$app->request->post()) {
            $formName = (new $class)->formName();
            $postDetails = ArrayHelper::getValue($post, $formName, []);
            $modelDetails = [];
            /* @var $detail \yii\db\ActiveRecord */
            $error = false;
            foreach ($postDetails as $index => $data) {
                $detail = new $class();
                $data = array_merge(isset($options['extra']) ? $options['extra'] : [], $data);
                $detail->load($data, '');
                foreach ($relation->link as $from => $to) {
                    $detail->$from = $model->$to;
                }
                foreach ($children as $i => $child) {
                    if ($child !== false && $child->getPrimaryKey() === $detail->getPrimaryKey()) {
                        $detail = $child;
                        $detail->load($data, '');
                        $children[$i] = false;
                        break;
                    }
                }
                if (isset($options['beforeValidate'])) {
                    call_user_func($options['beforeValidate'], $detail, $index);
                }
                $error = !$detail->validate() || $error;
                $modelDetails[$index] = $detail;
            }
            if (!$error) {
                try {
                    // delete current children before inserting new
                    $linkFilter = [];
                    $columns = array_flip($class::primaryKey());
                    foreach ($relation->link as $from => $to) {
                        $linkFilter[$from] = $model->$to;
                        if (isset($columns[$from])) {
                            unset($columns[$from]);
                        }
                    }
                    $values = [];
                    if (!empty($columns)) {
                        $columns = array_keys($columns);
                        foreach ($children as $child) {
                            if ($child === false) {
                                continue;
                            }
                            $value = [];
                            foreach ($columns as $column) {
                                $value[$column] = $child->$column;
                            }
                            $values[] = $values;
                        }
                        if (!empty($values)) {
                            $class::deleteAll(['and', $linkFilter, ['in', [$columns, $values]]]);
                        }
                    } else {
                        $class::deleteAll($linkFilter);
                    }

                    foreach ($modelDetails as $index => $detail) {
                        if (isset($options['beforeSave'])) {
                            call_user_func($options['beforeSave'], $detail, $index);
                        }
                        $detail->save(false);
                        if (isset($options['afterSave'])) {
                            call_user_func($options['afterSave'], $detail, $index);
                        }
                    }

                    $saved = true;
                } catch (\Exception $exc) {
                    $message = $exc->getMessage();
                }
            }
            $children = array_values($modelDetails);
        }
        return [$saved, $children, $message];
    }
}