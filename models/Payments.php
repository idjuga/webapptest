<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\PaymentsQuery;
use app\models\User;
use app\models\PaymentsToClients;

/**
 * Payments model
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $type
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 * @property User $user
 * @property PaymentsToClients $paymentsToClients
 * @property Clients $clients
 */
class Payments extends ActiveRecord
{
    protected $_paymentTypes = [
        'paypal' => 'PayPal',
        'skrill' => 'Skrill',
        'bank' => 'Bank transfer'
    ];

    public static function tableName()
    {
        return '{{%payments}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'name', 'type'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'type'], 'string', 'max' => 255],
            [['name', 'user_id'], 'unique', 'targetAttribute' => ['name', 'user_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'clients' => 'Clients'
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentsToClients()
    {
        return $this->hasMany(PaymentsToClients::className(), ['payment_id' => 'id']);
    }

    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['id' => 'client_id'])->viaTable(PaymentsToClients::tableName(), ['payment_id' => 'id']);
    }

    public function getPaymentTypes($type = null)
    {
        if (!empty($type) && isset($this->_paymentTypes[$type])) {
            return $this->_paymentTypes[$type];
        }
        return $this->_paymentTypes;
    }

    public static function find()
    {
        return new PaymentsQuery(get_called_class());
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {

            if(empty($this->user_id)) {
                $this->user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    public function linkPaymentsToClients($requestData)
    {
        $this->unlinkAll('paymentsToClients', true);
        foreach ($requestData as $clientId) {
            $paymentsToClients = new PaymentsToClients();
            $paymentsToClients->client_id = $clientId;
            $this->link('paymentsToClients', $paymentsToClients);
        }
    }
}
