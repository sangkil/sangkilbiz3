<?php

use yii\db\Schema;

class m140622_165356_create_table_master extends \yii\db\Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orgn}}', [
            'id_orgn' => Schema::TYPE_PK,
            'cd_orgn' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_orgn' => Schema::TYPE_STRING . '(32) NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%branch}}', [
            'id_branch' => Schema::TYPE_PK,
            'id_orgn' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cd_branch' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_branch' => Schema::TYPE_STRING . '(32) NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'FOREIGN KEY (id_orgn) REFERENCES {{%orgn}} (id_orgn) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%warehouse}}', [
            'id_warehouse' => Schema::TYPE_PK,
            'id_branch' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cd_whse' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_whse' => Schema::TYPE_STRING . '(32) NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'FOREIGN KEY (id_branch) REFERENCES {{%branch}} (id_branch) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%product_group}}', [
            'id_group' => Schema::TYPE_PK,
            'cd_group' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_group' => Schema::TYPE_STRING . '(32) NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%category}}', [
            'id_category' => Schema::TYPE_PK,
            'cd_category' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_category' => Schema::TYPE_STRING . '(32) NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%product}}', [
            'id_product' => Schema::TYPE_PK,
            'id_group' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_category' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cd_product' => Schema::TYPE_STRING . '(13) NOT NULL',
            'nm_product' => Schema::TYPE_STRING . '(64) NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'FOREIGN KEY (id_group) REFERENCES {{%product_group}} (id_group) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (id_category) REFERENCES {{%category}} (id_category) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%product_child}}', [
            'barcode' => Schema::TYPE_STRING . '(13) PRIMARY KEY',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'FOREIGN KEY (id_product) REFERENCES {{%product}} (id_product) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%uom}}', [
            'id_uom' => Schema::TYPE_PK,
            'cd_uom' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_uom' => Schema::TYPE_STRING . '(32) NOT NULL',
            'isi' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%product_uom}}', [
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'isi' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_product, id_uom)',
            'FOREIGN KEY (id_product) REFERENCES {{%product}} (id_product) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (id_uom) REFERENCES {{%uom}} (id_uom) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%product_stock}}', [
            'id_warehouse' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty_stock' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_warehouse , id_product )',
            'FOREIGN KEY (id_warehouse) REFERENCES {{%warehouse}} (id_warehouse) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (id_product) REFERENCES {{%product}} (id_product) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%supplier}}', [
            'id_supplier' => Schema::TYPE_PK,
            'cd_supplier' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_supplier' => Schema::TYPE_STRING . '(64) NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%product_supplier}}', [
            'id_product' => Schema::TYPE_INTEGER,
            'id_supplier' => Schema::TYPE_INTEGER,
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_product , id_supplier )',
            'FOREIGN KEY (id_product) REFERENCES {{%product}} (id_product) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (id_supplier) REFERENCES {{%supplier}} (id_supplier) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%customer}}', [
            'id_customer' => Schema::TYPE_PK,
            'cd_customer' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_customer' => Schema::TYPE_STRING . '(64) NOT NULL',
            'contact_name' => Schema::TYPE_STRING . '(64)',
            'contact_number' => Schema::TYPE_STRING . '(64)',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%customer_detail}}', [
            'id_customer' => Schema::TYPE_INTEGER,
            'id_distric' => Schema::TYPE_INTEGER,
            'addr1' => Schema::TYPE_STRING . '(128)',
            'addr2' => Schema::TYPE_STRING . '(128)',
            'latitude' => Schema::TYPE_FLOAT,
            'longtitude' => Schema::TYPE_FLOAT,
            'id_kab' => Schema::TYPE_INTEGER,
            'id_kec' => Schema::TYPE_INTEGER,
            'id_kel' => Schema::TYPE_INTEGER,
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_customer)',
            'FOREIGN KEY (id_customer) REFERENCES {{%customer}} (id_customer) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%price_category}}', [
            'id_price_category' => Schema::TYPE_PK,
            'nm_price_category' => Schema::TYPE_STRING . '(64) NOT NULL',
            'formula' => Schema::TYPE_STRING . '(256)',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%price}}', [
            'id_product' => Schema::TYPE_INTEGER,
            'id_price_category' => Schema::TYPE_INTEGER,
            'price' => Schema::TYPE_FLOAT,
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_product , id_price_category )',
            'FOREIGN KEY (id_product) REFERENCES {{%product}} (id_product) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (id_price_category) REFERENCES {{%price_category}} (id_price_category) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%cogs}}', [
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
			'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cogs' => Schema::TYPE_FLOAT . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_product)',
            'FOREIGN KEY (id_product) REFERENCES {{%product}} (id_product) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (id_uom) REFERENCES {{%uom}} (id_uom) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%user_to_branch}}', [
            'id_branch' => Schema::TYPE_INTEGER,
            'id_user' => Schema::TYPE_INTEGER,
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_branch , id_user )',
            'FOREIGN KEY (id_branch) REFERENCES {{%branch}} (id_branch) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%global_config}}', [
            'group' => Schema::TYPE_STRING.'(16) NOT NULL',
            'name' => Schema::TYPE_STRING.'(32) NOT NULL',
            'value' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_STRING,
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY ([[group]] , [[name]])',
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%global_config}}');
        $this->dropTable('{{%user_to_branch}}');
        $this->dropTable('{{%cogs}}');
        $this->dropTable('{{%price}}');
        $this->dropTable('{{%price_category}}');
        $this->dropTable('{{%product_supplier}}');
        $this->dropTable('{{%product_stock}}');
        $this->dropTable('{{%product_uom}}');
        $this->dropTable('{{%product_child}}');
        $this->dropTable('{{%product}}');
        $this->dropTable('{{%product_group}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%uom}}');
        $this->dropTable('{{%customer_detail}}');
        $this->dropTable('{{%customer}}');
        $this->dropTable('{{%supplier}}');
        $this->dropTable('{{%warehouse}}');
        $this->dropTable('{{%branch}}');
        $this->dropTable('{{%orgn}}');
    }
}
