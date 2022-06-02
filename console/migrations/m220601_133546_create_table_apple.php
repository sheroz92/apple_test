<?php

use yii\db\Migration;

/**
 * Class m220601_133546_create_table_apple
 */
class m220601_133546_create_table_apple extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string(100)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'fell_at' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'size' => $this->decimal(10,2)->notNull()->defaultValue(1),
            'spoiled' => $this->decimal(10,2)->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->dropTable('apple');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200124_133546_create_table_apple cannot be reverted.\n";

        return false;
    }
    */
}
