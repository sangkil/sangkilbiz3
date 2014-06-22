<?php

namespace biz\adminlte;

/**
 * Description of AdminlteTheme
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Theme extends \yii\base\Theme
{
    public $pathMap = [
        '@backend/views' => '@biz/adminlte/views',
        '@biz/sales/views' => '@biz/adminlte/sales-views',
        '@biz/inventory/views' => '@biz/adminlte/inventory-views',
        '@biz/accounting/views' => '@biz/adminlte/accounting-views',
        '@biz/master/views' => '@biz/adminlte/master-views',
        '@biz/purchase/views' => '@biz/adminlte/purchase-views'
    ];

}