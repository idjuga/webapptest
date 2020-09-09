<?php

use yii\db\Migration;

/**
 * Class m200908_155155_add_field_to_users
 */
class m200908_155155_add_field_to_users extends Migration
{

    public $tableName = '{{%user}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'auth_key', 'VARCHAR(32) AFTER `name`');
        $this->addColumn($this->tableName,'status', 'INT(1) UNSIGNED DEFAULT 1 AFTER `password`');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200908_155155_add_field_to_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200908_155155_add_field_to_users cannot be reverted.\n";

        return false;
    }
    */
}
