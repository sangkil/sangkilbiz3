<?php

namespace biz\app\rest;

use biz\app\base\ApiHelper;
use yii\base\InvalidConfigException;

/**
 * Description of RestController
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Controller extends \yii\rest\Controller
{
    /**
     *
     * @var ApiHelper 
     */
    public $helperClass;
    public $prepareDataProvider;

    public function init()
    {
        if ($this->helperClass === null) {
            throw new InvalidConfigException(get_class($this) . '::$helperClass must be set.');
        }
    }

    public function actions()
    {
        $helperClass = $this->helperClass;
        $modelClass = $helperClass::modelClass();
        
        return[
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $modelClass,
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $modelClass,
            ],
            'create' => [
                'class' => 'biz\app\base\rest\CreateAction',
                'helperClass' => $helperClass,
            ],
            'update' => [
                'class' => 'biz\app\base\rest\UpdateAction',
                'helperClass' => $helperClass,
            ],
            'delete' => [
                'class' => 'biz\app\base\rest\DeleteAction',
                'helperClass' => $helperClass,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }
}