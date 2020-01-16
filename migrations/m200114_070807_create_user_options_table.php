<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_options}}`.
 */
class m200114_070807_create_user_options_table extends Migration
{

    public $tableName      = 'user_options';
    public $foreignKeyName = 'fk_user_options_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_options', [
            'id'       => $this->primaryKey(),
            'user_id'  => $this->integer()->notNull(),
            'dir_name' => $this->string()->notNull(),
        ]);
        $this->addForeignKey(
                $this->foreignKeyName, // это "условное имя" ключа
                $this->tableName,     // это название текущей таблицы
                'user_id',           // это имя поля в текущей таблице, которое будет ключом
                'user',             // это имя таблицы, с которой хотим связаться
                'id',              // это поле таблицы, с которым хотим связаться
                'CASCADE',        // что делать при удалении сущности, на которую ссылаемся
                'CASCADE'        // что делать при обновлении сущности, на которую ссылаемся
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey($this->foreignKeyName, $this->tableName);
        $this->dropTable($this->tableName);
    }

}
