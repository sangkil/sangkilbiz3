<?php

namespace biz\sales;

/**
 * Module sales.
 */
class Module extends \yii\base\Module
{
	public $controllerNamespace = 'biz\sales\controllers';

	public function init()
	{
		parent::init();
        if(!isset($this->controllerMap['default'])){
            $this->controllerMap['default'] = 'biz\app\base\DefaultController';
        }
	}
}
