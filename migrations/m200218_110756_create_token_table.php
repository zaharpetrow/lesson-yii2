<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%token}}`.
 */
class m200218_110756_create_token_table extends Migration
{

    public $indexName = 'user_id_unique';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%token}}', [
            'user_id'    => $this->integer()->notNull(),
            'token'      => $this->string(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex($this->indexName, '{{%token}}', 'user_id', true);
        $this->addForeignKey('{{%fk_user_token}}', '{{%token}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%token}}');
    }

}
