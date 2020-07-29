<?php

use yii\db\Migration;

/**
 * Class m200116_064903_move_img_column_from_user_to_user_options_table
 */
class m200116_064903_move_img_column_from_user_to_user_options_table extends Migration
{

    public $fromTable = 'user';
    public $toTable   = 'user_options';
    public $colName   = 'img';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->toTable, $this->colName, $this->string(255));
        $this->dropColumn($this->fromTable, $this->colName);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->toTable, $this->colName);
        $this->addColumn($this->fromTable, $this->colName, $this->string(255));
    }

}
