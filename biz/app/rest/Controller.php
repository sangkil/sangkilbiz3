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
     * @var string|array the configuration for creating the serializer that formats the response data.
     */
    public $serializer = 'biz\app\rest\Serializer';

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

        return[
            'index' => [
                'class' => 'biz\app\rest\IndexAction',
                'helperClass' => $helperClass,
            ],
            'view' => [
                'class' => 'biz\app\rest\ViewAction',
                'helperClass' => $helperClass,
            ],
            'create' => [
                'class' => 'biz\app\rest\CreateAction',
                'helperClass' => $helperClass,
            ],
            'update' => [
                'class' => 'biz\app\rest\UpdateAction',
                'helperClass' => $helperClass,
            ],
            'delete' => [
                'class' => 'biz\app\rest\DeleteAction',
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