<?php

use yii\db\Migration;

/**
 * Class m191211_112920_add_column_img_to_user_table
 */
class m191211_112920_add_column_img_to_user_table extends Migration
{

    public $tableName = 'user';
    public $colName   = 'img';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, $this->colName, $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, $this->colName);
    }

}
