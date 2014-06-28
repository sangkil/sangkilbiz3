<?php

namespace biz\master\tools;

use yii\base\UserException;
use biz\master\models\ProductStock;
use biz\master\models\Cogs;
use biz\master\models\Price;
use biz\master\models\PriceCategory;
use biz\master\models\GlobalConfig;
use biz\master\models\Warehouse;
use biz\master\models\Branch;
use biz\master\models\ProductUom;
use biz\master\models\UserToBranch;
use yii\helpers\ArrayHelper;
use yii\db\Query;

/**
 * Description of Helper
 *
 * @author MDMunir
 */
class Helper
{

    public static function getCurrentStock($id_whse, $id_product)
    {
        $stock = ProductStock::findOne(['id_warehouse' => $id_whse, 'id_product' => $id_product]);
        return $stock ? $stock->qty_stock : 0;
    }

    public static function getCurrentStockAll($id_product)
    {
        return ProductStock::find()->where(['id_product' => $id_product])->sum('qty_stock');
    }

    public static function updateStock($params, $logs = [])
    {
        $stock = ProductStock::findOne([
                'id_warehouse' => $params['id_warehouse'],
                'id_product' => $params['id_product'],
        ]);
        if (!$stock) {
            $stock = new ProductStock();

            $stock->setAttributes([
                'id_warehouse' => $params['id_warehouse'],
                'id_product' => $params['id_product'],
                'id_uom' => $params['id_uom'],
                'qty_stock' => 0,
            ]);
        }

        $stock->qty_stock = $stock->qty_stock + $params['qty'];
        if (!empty($logs) && $stock->canSetProperty('logParams')) {
            $stock->logParams = $logs;
        }
        if (!$stock->save()) {
            throw new UserException(implode(",\n", $stock->firstErrors));
        }

        return true;
    }

    public static function updateCogs($params, $logs = [])
    {
        $cogs = Cogs::findOne(['id_product' => $params['id_product']]);
        if (!$cogs) {
            $cogs = new Cogs();
            $cogs->setAttributes([
                'id_product' => $params['id_product'],
                'id_uom' => $params['id_uom'],
                'cogs' => 0.0
            ]);
        }
        $cogs->cogs = 1.0 * ($cogs->cogs * $params['old_stock'] + $params['price'] * $params['added_stock']) / ($params['old_stock'] + $params['added_stock']);
        if (!empty($logs) && $cogs->canSetProperty('logParams')) {
            $cogs->logParams = $logs;
        }
        if (!$cogs->save()) {
            throw new UserException(implode(",\n", $cogs->firstErrors));
        }
        return true;
    }

    private static function executePriceFormula($_formula_, $price)
    {
        if (empty($_formula_)) {
            return $price;
        }
        $_formula_ = preg_replace('/price/i', '$price', $_formula_);
        return empty($_formula_) ? $price : eval("return $_formula_;");
    }

    public static function updatePrice($params, $logs = [])
    {
        $categories = PriceCategory::find()->all();
        foreach ($categories as $category) {
            $price = Price::findOne([
                    'id_product' => $params['id_product'],
                    'id_price_category' => $category->id_price_category
            ]);

            if (!$price) {
                $price = new Price();
                $price->setAttributes([
                    'id_product' => $params['id_product'],
                    'id_price_category' => $category->id_price_category,
                    'id_uom' => $params['id_uom'],
                    'price' => 0
                ]);
            }

            if (!empty($logs) && $price->canSetProperty('logParams')) {
                $price->logParams = $logs;
            }
            $price->price = self::executePriceFormula($category->formula, $params['price']);
            if (!$price->save()) {
                throw new UserException(implode(",\n", $price->firstErrors));
            }
        }

        return true;
    }

    public static function getProductUomList($id_product)
    {
        $uoms = ProductUom::find()->with('idUom')->where(['id_product' => $id_product])->all();
        return ArrayHelper::map($uoms, 'id_uom', 'idUom.nm_uom');
    }

    /**
     * @return integer
     */
    public static function getSmallestProductUom($id_product)
    {
        $uom = ProductUom::findOne(['id_product' => $id_product, 'isi' => 1]);
        return $uom ? $uom->id_uom : false;
    }

    /**
     * @return integer
     */
    public static function getQtyProductUom($id_product, $id_uom)
    {
        $pu = ProductUom::findOne(['id_product' => $id_product, 'id_uom' => $id_uom]);
        return $pu ? $pu->isi : false;
    }

    public static function getConfigValue($group, $name, $default = null)
    {
        $model = GlobalConfig::findOne(['config_group' => $group, 'config_name' => $name]);
        return $model ? $model->config_value : $default;
    }

    public static function getWarehouseList($branch = false)
    {
        $query = Warehouse::find();
        if ($branch !== false) {
            $query->where(['id_branch' => $branch]);
        }
        return ArrayHelper::map($query->asArray()->all(), 'id_warehouse', 'nm_whse');
    }

    public static function getBranchList($id_user = null)
    {
        if ($id_user === null) {
            return ArrayHelper::map(Branch::find()->all(), 'id_branch', 'nm_branch');
        } else {
            $query = UserToBranch::find()->with('idBranch')->where(['user_id' => $id_user]);
            return ArrayHelper::map($query->all(), 'id_branch', 'idBranch.nm_branch');
        }
    }
    
    public static function getMasters($masters)
    {
        if (!is_array($masters)) {
            $masters = preg_split('/\s*,\s*/', trim($masters), -1, PREG_SPLIT_NO_EMPTY);
        }
        $masters = array_flip($masters);
        $result = [];

        // master product
        if (isset($masters['product'])) {
            $products = [];
            $query_master = (new Query())
                ->select(['id' => 'p.id_product', 'cd' => 'p.cd_product', 'nm' => 'p.nm_product', 'u.id_uom', 'u.nm_uom', 'pu.isi'])
                ->from(['p' => '{{%product}}'])
                ->innerJoin(['pu' => '{{%product_uom}}'], 'pu.id_product=p.id_product')
                ->innerJoin(['u' => '{{%uom}}'], 'u.id_uom=pu.id_uom')
                ->orderBy(['p.id_product' => SORT_ASC, 'pu.isi' => SORT_ASC]);
            foreach ($query_master->all() as $row) {
                $id = $row['id'];
                if (!isset($products[$id])) {
                    $products[$id] = [
                        'id' => $row['id'],
                        'cd' => $row['cd'],
                        'text' => $row['nm'],
                        'id_uom' => $row['id_uom'],
                        'nm_uom' => $row['nm_uom'],
                    ];
                }
                $products[$id]['uoms'][$row['id_uom']] = [
                    'id' => $row['id_uom'],
                    'nm' => $row['nm_uom'],
                    'isi' => $row['isi']
                ];
            }
            $result['products'] = $products;
        }

        // barcodes
        if (isset($masters['barcode'])) {
            $barcodes = [];
            $query_barcode = (new Query())
                ->select(['barcode' => 'lower(barcode)', 'id' => 'id_product'])
                ->from('{{%product_child}}')
                ->union((new Query())
                ->select(['lower(cd_product)', 'id_product'])
                ->from('{{%product}}'));
            foreach ($query_barcode->all() as $row) {
                $barcodes[$row['barcode']] = $row['id'];
            }
            $result['barcodes'] = $barcodes;
        }

        // prices
        if (isset($masters['price'])) {
            $prices = [];
            $query_prices = (new Query())
                ->select(['id_product', 'id_price_category', 'price'])
                ->from('{{%price}}');
            foreach ($query_prices->all() as $row) {
                $prices[$row['id_product']][$row['id_price_category']] = $row['price'];
            }
            $result['prices'] = $prices;
        }

        // customer
        if (isset($masters['customer'])) {
            $result['customers'] = (new Query())
                ->select(['id' => 'id_customer', 'label' => 'nm_cust'])
                ->from('{{%customer}}')
                ->all();
        }

        // supplier
        if (isset($masters['supplier'])) {
            $result['suppliers'] = (new Query())
                ->select(['id' => 'id_supplier', 'label' => 'nm_supplier'])
                ->from('{{%supplier}}')
                ->all();
        }

        // product_supplier
        if (isset($masters['product_supplier'])) {
            $prod_supp = [];
            $query_prod_supp = (new Query())
                ->select(['id_supplier', 'id_product'])
                ->from('{{%product_supplier}}');
            foreach ($query_prod_supp->all() as $row) {
                $prod_supp[$row['id_supplier']][] = $row['id_product'];
            }
            $result['product_supplier'] = $prod_supp;
        }

        // product_stock
        if (isset($masters['product_stock'])) {
            $prod_stock = [];
            $query_prod_stock = (new Query())
                ->select(['id_whse', 'id_product', 'qty_stock'])
                ->from('{{%product_stock}}');
            foreach ($query_prod_stock->all() as $row) {
                $prod_stock[$row['id_whse']][$row['id_product']] = $row['qty_stock'];
            }
            $result['product_stock'] = $prod_stock;
        }

        return $result;
    }
}