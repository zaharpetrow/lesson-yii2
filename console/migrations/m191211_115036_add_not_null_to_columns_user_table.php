<?php

use yii\db\Migration;

/**
 * Class m191211_115036_add_not_null_to_columns_user_table
 */
class m191211_115036_add_not_null_to_columns_user_table extends Migration
{

    const MAX_NAME  = 20;
    const MAX_EMAIL = 50;
    const MAX_PASS  = 255;

    public $tableName = 'user';
    public $nameCol   = 'name';
    public $emailCol  = 'email';
    public $passCol   = 'password';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->tableName, $this->nameCol, $this->string(self::MAX_NAME)->notNull());
        $this->alterColumn($this->tableName, $this->emailCol, $this->string(self::MAX_EMAIL)->notNull());
        $this->alterColumn($this->tableName, $this->passCol, $this->string(self::MAX_PASS)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn($this->tableName, $this->nameCol, $this->string(self::MAX_NAME));
        $this->alterColumn($this->tableName, $this->emailCol, $this->string(self::MAX_EMAIL));
        $this->alterColumn($this->tableName, $this->passCol, $this->string(self::MAX_PASS));
    }

}
