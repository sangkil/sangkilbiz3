<?php

namespace biz\app\rest;

use yii\base\InvalidConfigException;
use biz\app\base\ApiHelper;

/**
 * Description of Action
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Action extends \yii\base\Action
{
    /**
     *
     * @var ApiHelper 
     */
    public $helperClass;

    public function init()
    {
        if ($this->helperClass === null) {
            throw new InvalidConfigException(get_class($this) . '::$helperClass must be set.');
        }
    }
}