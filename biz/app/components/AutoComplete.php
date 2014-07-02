<?php
namespace biz\app\components;

use yii\helpers\Html;
/**
 * Description of AutoComplete
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class AutoComplete extends \yii\widgets\InputWidget
{
    public function run()
    {
        \yii\jui\AutoComplete::widget();
        parent::run();
    }
    
    public function renderWidget()
    {
        if($this->hasModel()){
            $result = Html::activeHiddenInput($this->model, $this->attribute);
        }  else {
            $result = Html::hiddenInput($this->name, $this->value);
        }
        
    }
}