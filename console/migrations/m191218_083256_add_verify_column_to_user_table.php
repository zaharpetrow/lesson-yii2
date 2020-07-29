<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m191218_083256_add_verify_column_to_user_table extends Migration
{

    public $tableName     = 'user';
    public $verifyColName = 'verify';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 
                $this->verifyColName, 
                $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, $this->verifyColName);
    }

}
