<?php

use yii\db\Schema;

class m140624_050135_create_table_accounting extends \yii\db\Migration
{
    public function up()
    {
        $history_columns = [
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ];

        $this->createTable('{{%acc_periode}}', array_merge([
            'id_periode' => Schema::TYPE_PK,
            'nm_periode' => Schema::TYPE_STRING . '(32) NOT NULL',
            'date_from' => Schema::TYPE_DATE . ' NOT NULL',
            'date_to' => Schema::TYPE_DATE . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
                ], $history_columns));

        $this->createTable('{{%coa}}', array_merge([
            'id_coa' => Schema::TYPE_PK,
            'id_parent' => Schema::TYPE_INTEGER,
            'cd_account' => Schema::TYPE_STRING . '(16) NOT NULL',
            'nm_account' => Schema::TYPE_STRING . '(64) NOT NULL',
            'coa_type' => Schema::TYPE_INTEGER.' NOT NULL',
            'normal_balance' => Schema::TYPE_STRING . '(1) NOT NULL',
                ], $history_columns));

        $this->createTable('{{%warehouse}}', array_merge([
            'id_warehouse' => Schema::TYPE_PK,
            'id_branch' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cd_whse' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_whse' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $history_columns));

        $this->createTable('{{%product_group}}', array_merge([
            'id_group' => Schema::TYPE_PK,
            'cd_group' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_group' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $history_columns));

        $this->createTable('{{%category}}', array_merge([
            'id_category' => Schema::TYPE_PK,
            'cd_category' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_group' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $history_columns));


        $this->createTable('{{%product}}', array_merge([
            'id_product' => Schema::TYPE_PK,
            'id_group' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_category' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cd_product' => Schema::TYPE_STRING . '(13) NOT NULL',
            'nm_product' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $history_columns));

        $this->createTable('{{%product_child}}', array_merge([
            'barcode' => Schema::TYPE_STRING . '(13) PRIMARY KEY',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'nm_product' => Schema::TYPE_STRING . '(64) NOT NULL',
                ], $history_columns));

        $this->createTable('{{%uom}}', array_merge([
            'id_uom' => Schema::TYPE_PK,
            'cd_uom' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_uom' => Schema::TYPE_STRING . '(32) NOT NULL',
            'isi' => Schema::TYPE_INTEGER . ' NOT NULL',
                ], $history_columns));

        $this->createTable('{{%product_uom}}', array_merge([
            'id_puom' => Schema::TYPE_PK,
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'isi' => Schema::TYPE_INTEGER . ' NOT NULL',
                ], $history_columns));

        $this->createTable('{{%supplier}}', array_merge([
            'id_supplier' => Schema::TYPE_PK,
            'cd_supplier' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_supplier' => Schema::TYPE_STRING . '(64) NOT NULL',
                ], $history_columns));

        $this->createTable('{{%product_supplier}}', array_merge([
            'id_product' => Schema::TYPE_INTEGER,
            'id_supplier' => Schema::TYPE_INTEGER,
                ], $history_columns, [
            'PRIMARY KEY (id_product , id_supplier )'
        ]));

        $this->createTable('{{%customer}}', array_merge([
            'id_customer' => Schema::TYPE_PK,
            'cd_cust' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_cust' => Schema::TYPE_STRING . '(64) NOT NULL',
            'contact_name' => Schema::TYPE_STRING . '(64)',
            'contact_number' => Schema::TYPE_STRING . '(64)',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
                ], $history_columns));

        $this->createTable('{{%customer_detail}}', array_merge([
            'id_customer' => Schema::TYPE_INTEGER . ' PRIMARY KEY',
            'id_distric' => Schema::TYPE_INTEGER,
            'addr1' => Schema::TYPE_STRING . '(128)',
            'addr2' => Schema::TYPE_STRING . '(128)',
            'latitude' => Schema::TYPE_FLOAT,
            'longtitude' => Schema::TYPE_FLOAT,
            'id_kab' => Schema::TYPE_INTEGER,
            'id_kec' => Schema::TYPE_INTEGER,
            'id_kel' => Schema::TYPE_INTEGER,
                ], $history_columns));

        $this->createTable('{{%price_category}}', array_merge([
            'id_price_category' => Schema::TYPE_PK,
            'nm_price_category' => Schema::TYPE_STRING . '(64) NOT NULL',
            'formula' => Schema::TYPE_STRING . '(256)',
                ], $history_columns));

        $this->createTable('{{%price}}', array_merge([
            'id_product' => Schema::TYPE_INTEGER,
            'id_price_category' => Schema::TYPE_INTEGER,
            'id_uom' => Schema::TYPE_INTEGER,
            'price' => Schema::TYPE_FLOAT,
                ], $history_columns, [
            'PRIMARY KEY (id_product , id_price_category )'
        ]));

        $this->createTable('{{%cogs}}', array_merge([
            'id_product' => Schema::TYPE_INTEGER . ' PRIMARY KEY',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cogs' => Schema::TYPE_FLOAT,
                ], $history_columns, [
        ]));

        $this->createTable('{{%user_to_branch}}', array_merge([
            'id_branch' => Schema::TYPE_INTEGER,
            'id_user' => Schema::TYPE_INTEGER,
                ], $history_columns, [
            'PRIMARY KEY (id_branch , id_user )'
        ]));
    }

    public function down()
    {
        echo "m140624_050135_create_table_accounting cannot be reverted.\n";

        return false;
    }
}
