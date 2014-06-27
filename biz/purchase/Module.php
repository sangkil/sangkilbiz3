<?php

namespace biz\purchase;


class Module extends \yii\base\Module
{
	public $controllerNamespace = 'biz\purchase\controllers';

	public function init()
	{
		parent::init();
        if(!isset($this->controllerMap['default'])){
            $this->controllerMap['default'] = 'biz\master\components\DefaultController';
        }

		// custom initialization code goes here
	}
}
