<?php

use yii\db\Migration;

/**
 * Class m220601_133234_add_admin_user
 */
class m220601_133234_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $pass = Yii::$app->security->generatePasswordHash('admin');
        $this->insert('user', [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => 'gOlP3qMOqc7tnC9yIkqdCsTh74RoJdB6',
            'password_hash' => $pass,
            'email' => 'admin@admin.ru',
            'created_at' => time(),
            'updated_at' => time(),
            'status' => 10,
            'verification_token' => 'wCrGbq8_U-QGvDrDk1TGdXcLC_o7QC-L_1615820431',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200124_133234_add_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
