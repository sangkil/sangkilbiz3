<?php

namespace biz\app\rest;

use Yii;
use biz\app\base\Event;
use yii\data\ActiveDataProvider;

/**
 * Description of ViewAction
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class IndexAction extends Action
{
    public $prepareDataProvider;
    
    public function run()
    {
        $helperClass = $this->helperClass;
        $e_name = $helperClass::prefixEventName();
        Yii::$app->trigger($e_name . '_list', new Event());
        return $this->prepareDataProvider();
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $helperClass = $this->helperClass;
        $modelClass = $helperClass::modelClass();

        return new ActiveDataProvider([
            'query' => $modelClass::find(),
        ]);
    }    
}