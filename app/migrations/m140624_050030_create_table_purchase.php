<?php

use yii\db\Schema;

class m140624_050030_create_table_purchase extends \yii\db\Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%purchase}}', [
            'id_purchase' => Schema::TYPE_PK,
            'purchase_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'id_supplier' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_branch' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_warehouse' => Schema::TYPE_INTEGER . ' NOT NULL',
            'purchase_date' => Schema::TYPE_DATE . ' NOT NULL',
            'purchase_value' => Schema::TYPE_FLOAT . ' NOT NULL',
            'item_discount' => Schema::TYPE_FLOAT . ' NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%purchase_dtl}}', [
            'id_purchase_dtl' => Schema::TYPE_PK,
            'id_purchase' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_warehouse' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'purch_qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            'purch_price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'sales_price' => Schema::TYPE_FLOAT . ' NOT NULL',
            // constrain
            'FOREIGN KEY (id_purchase) REFERENCES {{%purchase}} (id_purchase) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%purchase_sales_price}}', [
            'id_purchase_dtl' => Schema::TYPE_PK,
            'id_price_category' => Schema::TYPE_INTEGER . ' NOT NULL',
            'price' => Schema::TYPE_FLOAT,
            // constrain
            'FOREIGN KEY (id_purchase_dtl) REFERENCES {{%purchase_dtl}} (id_purchase_dtl) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%purchase_sales_price}}');
        $this->dropTable('{{%purchase_dtl}}');
        $this->dropTable('{{%purchase}}');
    }
}
