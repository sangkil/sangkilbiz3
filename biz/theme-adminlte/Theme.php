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
        '@app/views' => '@biz/adminlte/app/views',
        '@biz/sales/views' => '@biz/adminlte/modules/sales/views',
        '@biz/inventory/views' => '@biz/adminlte/modules/inventory/views',
        '@biz/accounting/views' => '@biz/adminlte/modules/accounting/views',
        '@biz/master/views' => '@biz/adminlte/modules/master/views',
        '@biz/purchase/views' => '@biz/adminlte/modules/purchase/views'
    ];

}