<?php

namespace biz\app\base;

/**
 * Description of Event
 *
 * @author MDMunir
 */
class Event extends \yii\base\Event
{
    public $params;

    public function __construct($params = [], $config = [])
    {
        $this->params = $params;
        parent::__construct($config);
    }
}
