<?php

use yii\db\Migration;

/**
 * Class m200218_105222_add_index_and_delete_primary_key_in_user_options
 */
class m200218_105222_add_index_and_delete_primary_key_in_user_options extends Migration
{

    public $tableName = 'user_options';
    public $indexName = 'user_id_unique';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'id');
        $this->createIndex($this->indexName, $this->tableName, 'user_id', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex($this->indexName, $this->tableName);
        $this->addColumn($this->tableName, 'id', $this->primaryKey());
    }

}
