<?php

use yii\db\Schema;

class m140624_050135_create_table_accounting extends \yii\db\Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%coa}}', [
            'id_coa' => Schema::TYPE_PK,
            'id_parent' => Schema::TYPE_INTEGER,
            'cd_account' => Schema::TYPE_STRING . '(16) NOT NULL',
            'nm_account' => Schema::TYPE_STRING . '(64) NOT NULL',
            'coa_type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'normal_balance' => Schema::TYPE_STRING . '(1) NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'FOREIGN KEY (id_parent) REFERENCES {{%coa}} (id_coa) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%acc_periode}}', [
            'id_periode' => Schema::TYPE_PK,
            'nm_periode' => Schema::TYPE_STRING . '(32) NOT NULL',
            'date_from' => Schema::TYPE_DATE . ' NOT NULL',
            'date_to' => Schema::TYPE_DATE . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%entri_sheet}}', [
            'cd_esheet' => Schema::TYPE_STRING . '(16) NOT NULL',
            'nm_esheet' => Schema::TYPE_STRING . '(64) NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
			// constrain
            'PRIMARY KEY (cd_esheet)',
        ], $tableOptions);

        $this->createTable('{{%entri_sheet_dtl}}', [
            'cd_esheet' => Schema::TYPE_STRING . '(16) NOT NULL',
            'cd_esheet_dtl' => Schema::TYPE_STRING . '(16) NOT NULL',
            'nm_esheet_dtl' => Schema::TYPE_STRING . '(64) NOT NULL',
            'id_coa' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'PRIMARY KEY (cd_esheet, cd_esheet_dtl)',
            'FOREIGN KEY (cd_esheet) REFERENCES {{%entri_sheet}} (cd_esheet) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%gl_header}}', [
            'id_gl' => Schema::TYPE_PK,
            'gl_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'gl_date' => Schema::TYPE_DATE . ' NOT NULL',
            'id_periode' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_branch' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type_reff' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_reff' => Schema::TYPE_INTEGER,
            'description' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            // constrain
            'FOREIGN KEY (id_periode) REFERENCES {{%acc_periode}} (id_periode) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%gl_detail}}', [
            'id_gl_detail' => Schema::TYPE_PK,
            'id_gl' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_coa' => Schema::TYPE_INTEGER . ' NOT NULL',
            'amount' => Schema::TYPE_FLOAT . ' NOT NULL',
            // constrain
            'FOREIGN KEY (id_gl) REFERENCES {{%gl_header}} (id_gl) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (id_coa) REFERENCES {{%coa}} (id_coa) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%invoice}}', [
            'id_invoice' => Schema::TYPE_PK,
            'invoice_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'invoice_date' => Schema::TYPE_DATE . ' NOT NULL',
            'due_date' => Schema::TYPE_DATE . ' NOT NULL',
            'invoice_type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_vendor' => Schema::TYPE_INTEGER . ' NOT NULL',
            'invoice_value' => Schema::TYPE_FLOAT . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%invoice_dtl}}', [
            'id_invoice' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type_reff' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_reff' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_STRING . '(64) NULL',
            'trans_value' => Schema::TYPE_FLOAT . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_invoice, id_reff)',
            'FOREIGN KEY (id_invoice) REFERENCES {{%invoice}} (id_invoice) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%payment}}', [
            'id_payment' => Schema::TYPE_PK,
            'payment_num' => Schema::TYPE_STRING . '(16) NOT NULL',
            'payment_date' => Schema::TYPE_DATE . ' NOT NULL',
            'payment_type' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'create_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%payment_dtl}}', [
            'id_payment' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_invoice' => Schema::TYPE_INTEGER . ' NOT NULL',
            'payment_value' => Schema::TYPE_FLOAT . ' NOT NULL',
            // constrain
            'PRIMARY KEY (id_payment, id_invoice)',
            'FOREIGN KEY (id_payment) REFERENCES {{%payment}} (id_payment) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (id_invoice) REFERENCES {{%invoice}} (id_invoice) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%payment_dtl}}');
        $this->dropTable('{{%payment}}');
        $this->dropTable('{{%invoice_dtl}}');
        $this->dropTable('{{%invoice}}');
        $this->dropTable('{{%gl_detail}}');
        $this->dropTable('{{%gl_header}}');
        $this->dropTable('{{%entri_sheet_dtl}}');
        $this->dropTable('{{%entri_sheet}}');
        $this->dropTable('{{%acc_periode}}');
        $this->dropTable('{{%coa}}');
    }
}
