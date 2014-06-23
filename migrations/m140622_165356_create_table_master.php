<?php

use yii\db\Schema;

class m140622_165356_create_table_master extends \yii\db\Migration
{

    public function safeUp()
    {
        $history_columns = [
            'create_at' => Schema::TYPE_TIMESTAMP,
            'create_by' => Schema::TYPE_INTEGER,
            'update_at' => Schema::TYPE_TIMESTAMP,
            'ubdate_by' => Schema::TYPE_INTEGER,
        ];

        $this->createTable('{{%orgn}}', array_merge([
            'id_orgn' => Schema::TYPE_PK,
            'cd_orgn' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_orgn' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $history_columns));

        $this->createTable('{{%branch}}', array_merge([
            'id_branch' => Schema::TYPE_PK,
            'id_orgn' => Schema::TYPE_INTEGER,
            'cd_branch' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_branch' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $history_columns));

        $this->createTable('{{%warehouse}}', array_merge([
            'id_warehouse' => Schema::TYPE_PK,
            'id_branch' => Schema::TYPE_INTEGER,
            'cd_whse' => Schema::TYPE_STRING . '(4) NOT NULL',
            'nm_whse' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $history_columns));
        
        $this->createTable('{{%product}}', array_merge([
            'id_product' => Schema::TYPE_PK,
            'id_category' => Schema::TYPE_INTEGER,
            'cd_product' => Schema::TYPE_STRING . '(13) NOT NULL',
            'nm_product' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $history_columns));
        
        
        
    }

    public function safeDown()
    {
        echo "m140622_165356_create_table_master cannot be reverted.\n";

        return false;
    }
}