<?php

namespace biz\dev\ext\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Description of ListView
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class EditableList extends \yii\widgets\ListView
{
    public $emptyText = '';

    /**
     *
     * @var \yii\db\ActiveRecord[]
     */
    public $allModels;

    /**
     *
     * @var string 
     */
    public $modelClass;
    public $afterRow;

    public function init()
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException('The "modelClass" property must be set.');
        }
        if ($this->allModels === null) {
            throw new InvalidConfigException('The "allModels" property must be set.');
        }
        $this->dataProvider = Yii::createObject([
                'class' => 'yii\data\ArrayDataProvider',
                'allModels' => $this->allModels
        ]);
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    public function run()
    {
        $id = $this->options['id'];
        $options = Json::encode($this->getClientOptions());
        $view = $this->getView();
        DetailListViewAsset::register($view);
        $view->registerJs("jQuery('#$id').mdmEditableList($options);");
        parent::run();
    }

    protected function getClientOptions()
    {
        $result = [
            'counter' => $this->dataProvider->getCount(),
            'template' => $this->renderItem(new $class, '', '_index_'),
            'itemTag' => ArrayHelper::getValue($this->itemOptions, 'tag', 'div'),
        ];
        if ($this->afterRow !== null) {
            $result['afterRow'] = $this->afterRow;
        }
        return $result;
    }
}