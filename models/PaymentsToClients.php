<?php

namespace app\models;

use Yii;

/**
 * PaymentsToClients model
 *
 * @property int $id
 * @property int $payment_id
 * @property int $client_id
 * @property Clients $client
 * @property Payments $payment
 */
class PaymentsToClients extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%payments_to_clients}}';
    }

    public function rules()
    {
        return [
            [['payment_id', 'client_id'], 'required'],
            [['payment_id', 'client_id'], 'integer'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payments::className(), 'targetAttribute' => ['payment_id' => 'id']],
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payments::className(), ['id' => 'payment_id']);
    }
}
