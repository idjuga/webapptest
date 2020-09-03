<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payments_to_clients}}`.
 */
class m200903_083159_create_payments_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payments_to_clients}}', [
            'id' => $this->primaryKey(),
            'payment_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-paymentstoclients-payment_id',
            '{{%payments_to_clients}}',
            'payment_id'
        );

        $this->createIndex(
            'idx-paymentstoclients-client_id',
            '{{%payments_to_clients}}',
            'client_id'
        );

        $this->addForeignKey(
            'fk-paymentstoclients-payment_id',
            '{{%payments_to_clients}}',
            'payment_id',
            '{{%payments}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-paymentstoclients-client_id',
            '{{%payments_to_clients}}',
            'client_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payments_to_clients}}');
    }
}
