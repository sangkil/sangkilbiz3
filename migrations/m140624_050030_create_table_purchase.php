<?php

use yii\db\Schema;

class m140624_050030_create_table_purchase extends \yii\db\Migration
{

    public function safeUp()
    {
        $history_columns = [
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ];

        $this->createTable('{{%purchase}}', array_merge([
            'id_purchase' => Schema::TYPE_PK,
            'purchase_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'id_supplier' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_branch' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_warehouse' => Schema::TYPE_INTEGER . ' NOT NULL',
            'purchase_date' => Schema::TYPE_DATE . ' NOT NULL',
            'purchase_value' => Schema::TYPE_FLOAT . ' NOT NULL',
            'item_discount' => Schema::TYPE_FLOAT . ' NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
                ], $history_columns));

        $this->createTable('{{%purchase_dtl}}', array_merge([
            'id_purchase_dtl' => Schema::TYPE_PK,
            'id_purchase' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_warehouse' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'purch_qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            'purch_price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'sales_price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'FOREIGN KEY (id_purchase) REFERENCES {{%purchase}} (id_purchase) ON DELETE CASCADE ON UPDATE CASCADE',
        ]));
    }

    public function safeDown()
    {
        echo "m140624_050030_create_table_purchase cannot be reverted.\n";

        return false;
    }
}