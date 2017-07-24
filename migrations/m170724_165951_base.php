<?php

use yii\db\Migration;

class m170724_165951_base extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'identity_number' => $this->integer(11)->unsigned()->notNull(),
            'firstname' => $this->string()->notNull(),
            'lastname' => $this->string()->notNull(),
            'gender' => $this->integer(1)->notNull(),
            'birthday' => $this->date()->notNull(),
        ], 'engine = innodb charset = utf8');
        
        $this->createTable('{{%deposits}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(11)->notNull(),
            'deposit' => $this->integer(11)->notNull(),
            'percent' => $this->integer(3)->notNull(),
            'date' => $this->date()->notNull(),
            'current_balance' => $this->integer(1)->notNull(),
        ], 'engine = innodb charset = utf8');
        
        $this->createTable('{{%history}}', [
            'id' => $this->primaryKey(),
            'deposit_id' => $this->integer(11)->notNull(),
            'operation_type' => $this->integer(11)->notNull(),
            'date' => $this->date()->notNull(),
            'revenue' => $this->integer(1)->notNull(),
        ], 'engine = innodb charset = utf8');
        
        $this->createTable('{{%operations}}', [
            'id' => $this->primaryKey(),
            'name' => $this->integer(11)->notNull(),
        ], 'engine = innodb charset = utf8');
        
        $this->insert('{{%operations}}', [
            'id' => 1,
            'name' => 'Adding percents'
        ]);
        $this->insert('{{%operations}}', [
            'id' => 2,
            'name' => 'Comission'
        ]);

        $this->createIndex('idx_client_id', '{{%deposits}}', 'client_id');
        $this->createIndex('idx_deposit_id', '{{%history}}', 'deposit_id');
        $this->createIndex('idx_operation_type', '{{%history}}', 'operation_type');
        
        $this->addForeignKey('fk_client_id', '{{%deposits}}', 'client_id','{{%clients}}','id','RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_deposit_id', '{{%history}}', 'deposit_id','{{%deposits}}','id','RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_operation_type', '{{%history}}', 'operation_type','{{%operations}}','id','RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        echo "m170724_165951_base cannot be reverted.\n";

        return false;
    }
}
