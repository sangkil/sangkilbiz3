<?php

use yii\db\Schema;

class m140624_050056_create_table_inventory extends \yii\db\Migration
{

    public function safeUp()
    {
        $this->createTable('{{%transfer}}', [
            'id_transfer' => Schema::TYPE_PK,
            'transfer_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'id_warehouse_source' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_warehouse_dest' => Schema::TYPE_INTEGER . ' NOT NULL',
            'transfer_date' => Schema::TYPE_DATE . ' NOT NULL',
            'receive_date' => Schema::TYPE_DATE,
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createTable('{{%transfer_dtl}}', [
            'id_transfer' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'transfer_qty_send' => Schema::TYPE_FLOAT,
            'transfer_qty_receive' => Schema::TYPE_FLOAT,
            // constrain
            'PRIMARY KEY (id_transfer , id_product )',
            'FOREIGN KEY (id_transfer) REFERENCES {{%transfer}} (id_transfer) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->createTable('{{%transfer_notice}}', [
            'id_transfer' => Schema::TYPE_INTEGER . ' NOT NULL',
            'notice_date' => Schema::TYPE_DATE . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_STRING,
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_transfer )',
            'FOREIGN KEY (id_transfer) REFERENCES {{%transfer}} (id_transfer) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->createTable('{{%notice_dtl}}', [
            'id_transfer' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty_notice' => Schema::TYPE_FLOAT . ' NOT NULL',
            'qty_approve' => Schema::TYPE_FLOAT,
            // constrain
            'PRIMARY KEY (id_transfer , id_product )',
            'FOREIGN KEY (id_transfer) REFERENCES {{%transfer_notice}} (id_transfer) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);


        $this->createTable('{{%stock_opname}}', [
            'id_opname' => Schema::TYPE_PK,
            'opname_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'id_warehouse' => Schema::TYPE_INTEGER . ' NOT NULL',
            'opname_date' => Schema::TYPE_DATE . ' NOT NULL',
            'description' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            'operator1' => Schema::TYPE_STRING . '(32)',
            'operator2' => Schema::TYPE_STRING . '(32)',
            'operator3' => Schema::TYPE_STRING . '(32)',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createTable('{{%stock_opname_dtl}}', [
            'id_opname' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_opname , id_product, id_uom)',
            'FOREIGN KEY (id_opname) REFERENCES {{%stock_opname}} (id_opname) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);


        $this->createTable('{{%stock_adjustment}}', [
            'id_adjustment' => Schema::TYPE_PK,
            'adjustment_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'id_warehouse' => Schema::TYPE_INTEGER . ' NOT NULL',
            'adjustment_date' => Schema::TYPE_DATE . ' NOT NULL',
            'id_reff' => Schema::TYPE_INTEGER,
            'description' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createTable('{{%stock_adjustment_dtl}}', [
            'id_adjustment' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            'item_value' => Schema::TYPE_FLOAT . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_adjustment , id_product, id_uom)',
            'FOREIGN KEY (id_adjustment) REFERENCES {{%stock_adjustment}} (id_adjustment) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%notice_dtl}}');
        $this->dropTable('{{%notice}}');

        $this->dropTable('{{%transfer_dtl}}');
        $this->dropTable('{{%transfer}}');

        $this->dropTable('{{%stock_adjustment_dtl}}');
        $this->dropTable('{{%stock_adjustment}}');

        $this->dropTable('{{%stock_opname_dtl}}');
        $this->dropTable('{{%stock_opname}}');
    }
}