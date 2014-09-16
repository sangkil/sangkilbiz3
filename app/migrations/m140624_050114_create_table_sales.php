<?php

use yii\db\Schema;

class m140624_050114_create_table_sales extends \yii\db\Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

//        $this->createTable('{{%cashdrawer}}', [
//            'id_cashdrawer' => Schema::TYPE_PK,
//            'client_machine' => Schema::TYPE_STRING . '(32) NOT NULL',
//            'id_branch' => Schema::TYPE_INTEGER . ' NOT NULL',
//            'id_user' => Schema::TYPE_INTEGER . ' NOT NULL',
//            'cashier_no' => Schema::TYPE_INTEGER . ' NOT NULL',
//            'init_cash' => Schema::TYPE_FLOAT . ' NOT NULL',
//            'close_cash' => Schema::TYPE_FLOAT,
//            'variant' => Schema::TYPE_FLOAT,
//            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
//            // history column
//            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
//            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
//            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
//            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
//        ], $tableOptions);

        $this->createTable('{{%sales}}', [
            'id_sales' => Schema::TYPE_PK,
            'sales_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'id_branch' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_customer' => Schema::TYPE_INTEGER,
            'sales_date' => Schema::TYPE_DATE . ' NOT NULL',
            'sales_value' => Schema::TYPE_FLOAT . ' NOT NULL',
            'discount' => Schema::TYPE_FLOAT . ' NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'FOREIGN KEY (id_cashdrawer) REFERENCES {{%cashdrawer}} (id_cashdrawer) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%sales_dtl}}', [
            'id_sales' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'sales_qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            'sales_price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'cogs' => Schema::TYPE_FLOAT . ' NOT NULL',
            'discount' => Schema::TYPE_FLOAT,
            'tax' => Schema::TYPE_FLOAT,
            // constrain
            'PRIMARY KEY (id_sales , id_product )',
            'FOREIGN KEY (id_sales) REFERENCES {{%sales}} (id_sales) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%sales_dtl}}');
        $this->dropTable('{{%sales}}');
//        $this->dropTable('{{%cashdrawer}}');
    }
}
