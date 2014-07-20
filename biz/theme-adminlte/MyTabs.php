<?php

namespace biz\adminlte;

/**
 * Description of AdminlteTheme
 *
 * @author Mujib Masyhudi (masyhudi) <mujib.masyhudi@gmail.com>
 */
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Tabs;

class MyTabs extends Tabs
{
    /**
     *
     * @var type array list of ul option
     */
    public $contentOption = ['class' => 'tab-content'];

    /**
     * Renders tab items as specified on [[items]].
     * @return string                  the rendering result.
     * @throws InvalidConfigException.
     */
    protected function renderItems()
    {
        $headers = [];
        $panes = [];

        if (!$this->hasActiveTab() && !empty($this->items)) {
            $this->items[0]['active'] = true;
        }

        foreach ($this->items as $n => $item) {
            if (!isset($item['label'])) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($item, 'headerOptions', []));
            $linkOptions = array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));

            if (isset($item['items'])) {
                $label .= ' <b class="caret"></b>';
                Html::addCssClass($headerOptions, 'dropdown');

                if ($this->renderDropdown($item['items'], $panes)) {
                    Html::addCssClass($headerOptions, 'active');
                }

                Html::addCssClass($linkOptions, 'dropdown-toggle');
                $linkOptions['data-toggle'] = 'dropdown';
                $header = Html::a($label, "#", $linkOptions) . "\n"
                        . Dropdown::widget(['items' => $item['items'], 'clientOptions' => false, 'view' => $this->getView()]);
            } elseif (isset($item['content'])) {
                $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
                $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-tab' . $n);

                Html::addCssClass($options, 'tab-pane');
                if (ArrayHelper::remove($item, 'active')) {
                    Html::addCssClass($options, 'active');
                    Html::addCssClass($headerOptions, 'active');
                }
                $linkOptions['data-toggle'] = 'tab';
                $header = Html::a($label, '#' . $options['id'], $linkOptions);
                $panes[] = Html::tag('div', $item['content'], $options);
            } else {
                throw new InvalidConfigException("Either the 'content' or 'items' option must be set.");
            }

            $headers[] = Html::tag('li', $header, $headerOptions);
        }

        return Html::tag('ul', implode("\n", $headers), $this->options) . "\n"
                . Html::tag('div', implode("\n", $panes), $this->contentOption);
    }

}
