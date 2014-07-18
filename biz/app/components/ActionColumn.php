<?php

namespace biz\app\components;

use Yii;

/**
 * Description of ActionColumn
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class ActionColumn extends \yii\grid\ActionColumn
{

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            if (isset($this->buttons[$name]) && Helper::checkAccess($name, $model)) {
                $url = $this->createUrl($name, $model, $key, $index);

                return call_user_func($this->buttons[$name], $url, $model);
            } else {
                return '';
            }
        }, $this->template);
    }
}