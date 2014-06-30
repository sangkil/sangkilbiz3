<?php

use yii\db\Schema;

class m140624_050056_create_table_inventory extends \yii\db\Migration
{

    public function up()
    {
        $history_columns = [
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ];

        $this->createTable('{{%transfer}}', array_merge([
            'id_transfer' => Schema::TYPE_PK,
            'transfer_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'id_warehouse_source' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_warehouse_dest' => Schema::TYPE_INTEGER . ' NOT NULL',
            'transfer_date' => Schema::TYPE_DATE . ' NOT NULL',
            'receive_date' => Schema::TYPE_DATE,
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
                ], $history_columns));

        $this->createTable('{{%transfer_dtl}}', array_merge([
            'id_transfer' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_uom' => Schema::TYPE_INTEGER . ' NOT NULL',
            'transfer_qty_send' => Schema::TYPE_FLOAT,
            'transfer_qty_receive' => Schema::TYPE_FLOAT,
            'PRIMARY KEY (id_transfer , id_product )',
            'FOREIGN KEY (id_transfer) REFERENCES {{%transfer}} (id_transfer) ON DELETE CASCADE ON UPDATE CASCADE',
        ]));

        $this->createTable('{{%notice}}', array_merge([
            'id_transfer' => Schema::TYPE_INTEGER . ' NOT NULL',
            'notice_date' => Schema::TYPE_DATE . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
                ], $history_columns, [
            'PRIMARY KEY (id_transfer )',
            'FOREIGN KEY (id_transfer) REFERENCES {{%transfer}} (id_transfer) ON DELETE CASCADE ON UPDATE CASCADE',
        ]));

        $this->createTable('{{%notice_dtl}}', array_merge([
            'id_transfer' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty_notice' => Schema::TYPE_FLOAT . ' NOT NULL',
            'qty_approve' => Schema::TYPE_FLOAT,
            'PRIMARY KEY (id_transfer , id_product )',
            'FOREIGN KEY (id_transfer) REFERENCES {{%notice}} (id_transfer) ON DELETE CASCADE ON UPDATE CASCADE',
        ]));
    }

    public function down()
    {
        echo "m140624_050056_create_table_inventory cannot be reverted.\n";

        return false;
    }
}