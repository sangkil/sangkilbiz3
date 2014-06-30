<?php

use yii\db\Schema;

class m140624_050114_create_table_sales extends \yii\db\Migration
{
    public function safeUp()
    {
        $history_columns = [
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ];

        $this->createTable('{{%sales}}', array_merge([
            'id_sales' => Schema::TYPE_PK,
            'sales_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'id_customer' => Schema::TYPE_INTEGER,
            'id_branch' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_warehouse' => Schema::TYPE_INTEGER . ' NOT NULL',
            'purchase_date' => Schema::TYPE_DATE . ' NOT NULL',
            'purchase_value' => Schema::TYPE_FLOAT . ' NOT NULL',
            'item_discount' => Schema::TYPE_FLOAT . ' NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
                ], $history_columns));

        $this->createTable('{{%sales_dtl}}', array_merge([
            'id_sales_dtl' => Schema::TYPE_PK,
            'id_sales' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_warehouse' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'sales_qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            'sales_price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'cogs' => Schema::TYPE_FLOAT . ' NOT NULL',
            'discount' => Schema::TYPE_FLOAT,
            'tax' => Schema::TYPE_FLOAT,
            'FOREIGN KEY (id_sales) REFERENCES {{%sales}} (id_sales) ON DELETE CASCADE ON UPDATE CASCADE',
        ]));
    }

    public function safeDown()
    {
        echo "m140624_050114_create_table_sales cannot be reverted.\n";

        return false;
    }
}
