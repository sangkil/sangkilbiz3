<?php

namespace biz\master;

/**
 * Module master.
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'biz\master\controllers';

    public function init()
    {
        parent::init();
        if (!isset($this->controllerMap['default'])) {
            $this->controllerMap['default'] = 'biz\app\base\DefaultController';
        }
    }
}
