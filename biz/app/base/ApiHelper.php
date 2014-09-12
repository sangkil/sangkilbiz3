<?php

namespace biz\app\base;

use yii\web\NotFoundHttpException;
use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;
use yii\base\Model;
use biz\app\base\Event;
use Yii;

/**
 * Description of ApiHelper
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class ApiHelper
{

    /**
     * @return ActiveRecordInterface
     */
    public static function modelClass()
    {
        $class = get_called_class();
        return str_replace('components', 'models', $class);
    }

    public static function prefixEventName()
    {
        $class = get_called_class();
        if (($pos = strrpos($class, '\\')) !== false) {
            $class = substr($class, $pos);
        }
        return 'e_' . Inflector::camel2id($class);
    }

    public static function create($data)
    {
        $modelClass = static::modelClass();
        /* @var $model \yii\db\ActiveRecord */
        $model = new $modelClass([
            'scenario' => Model::SCENARIO_DEFAULT,
        ]);
        $e_name = static::prefixEventName();
        Yii::$app->trigger($e_name . '_create', new Event([$model]));
        $model->load($data, '');
        if ($model->save()) {
            Yii::$app->trigger($e_name . '_created', new Event([$model]));
        }
        return $model;
    }

    public static function update($id, $data)
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = static::findModel($id);
        $e_name = static::prefixEventName();
        Yii::$app->trigger($e_name . '_update', new Event([$model]));
        $model->load($data, '');
        if ($model->save()) {
            Yii::$app->trigger($e_name . '_updated', new Event([$model]));
        }
        return $model;
    }

    public static function delete($id)
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = static::findModel($id);
        $e_name = static::prefixEventName();
        Yii::$app->trigger($e_name . '_delete', new Event([$model]));
        if ($model->delete()) {
            Yii::$app->trigger($e_name . '_deleted', new Event([$model]));
            return true;
        }
        return false;
    }

    /**
     * Returns the data model based on the primary key given.
     * If the data model is not found, a 404 HTTP exception will be raised.
     * @param string $id the ID of the model to be loaded. If the model has a composite primary key,
     * the ID must be a string of the primary key values separated by commas.
     * The order of the primary key values should follow that returned by the `primaryKey()` method
     * of the model.
     * @return ActiveRecordInterface the model found
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        /* @var $modelClass ActiveRecordInterface */
        $modelClass = static::modelClass();
        $keys = $modelClass::primaryKey();
        if (count($keys) > 1) {
            $values = explode(',', $id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($id !== null) {
            $model = $modelClass::findOne($id);
        }

        if (isset($model)) {
            Yii::$app->trigger(static::prefixEventName() . '_find', new Event([$model]));
            return $model;
        } else {
            throw new NotFoundHttpException("Object not found: $id");
        }
    }
}