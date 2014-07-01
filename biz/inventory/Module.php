<?php

namespace biz\inventory;

/**
 * Module inventory. 
 */
class Module extends \yii\base\Module
{
	public $controllerNamespace = 'biz\inventory\controllers';

	public function init()
	{
		parent::init();
        if(!isset($this->controllerMap['default'])){
            $this->controllerMap['default'] = 'biz\app\base\DefaultController';
        }
	}
}
