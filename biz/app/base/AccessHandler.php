<?php

namespace biz\app\base;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author misbahul d munir <misbahuldmunir@gmail.com>
 */
class AccessHandler extends \yii\base\Object
{
    /**
     *
     * @var \Closure 
     */
    public $callback;

    /**
     * @return array names of class
     */
    public function modelClasses()
    {
        return [];
    }

    /**
     * 
     * @param \yii\web\User $user
     * @param string $action
     * @param mixed|\yii\db\ActiveRecord $model
     * @return boolean
     */
    public function check($user, $action, $model)
    {
        if ($this->callback !== null) {
            return call_user_func($this->callback, $user, $action, $model);
        } else {
            return $this->checkAction($user, $action, $model);
        }
    }

    protected function checkAction($user, $action, $model)
    {
        return true;
    }
}