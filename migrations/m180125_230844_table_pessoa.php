<?php

use yii\db\Migration;

/**
 * Class m180125_230844_table_pessoa
 */
class m180125_230844_table_pessoa extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('Pessoa', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(40)->notNull(),
            'email' => $this->string(100)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180125_230844_table_pessoa cannot be reverted.\n";

        return false;
    }
}
