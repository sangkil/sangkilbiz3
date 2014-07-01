<?php

namespace biz\accounting;

/**
 * Module accounting
 */
class Module extends \yii\base\Module
{
	public $controllerNamespace = 'biz\accounting\controllers';

	public function init()
	{
		parent::init();
        if(!isset($this->controllerMap['default'])){
            $this->controllerMap['default'] = 'biz\app\base\DefaultController';
        }
	}
}
