<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\User;
use app\models\Country;
use app\models\ClientsQuery;

/**
 * Clients model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $status
 * @property int $country
 * @property string|null $note
 * @property int $created_at
 * @property int $updated_at
 * @property Country $countryData
 * @property User $user
 * @property PaymentsToClients $paymentsToClients
 * @property Payments $payments
 */
class Clients extends ActiveRecord
{
    protected $_statuses = [
        0 => 'Inactive',
        1 => 'Active',
        2 => 'Blacklisted'
    ];

    const DEFAULT_STATUS = 1;

    public static function tableName()
    {
        return '{{%clients}}';
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
            [['user_id', 'name', 'country'], 'required'],
            [['user_id', 'status', 'country'], 'integer'],
            [['note'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name', 'user_id'], 'unique', 'targetAttribute' => ['name', 'user_id']],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'name' => 'Name',
            'status' => 'Status',
            'country' => 'Country',
            'note' => 'Note'
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountryData()
    {
        return $this->hasOne(Country::className(), ['id' => 'country']);
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
        return $this->hasMany(PaymentsToClients::className(), ['client_id' => 'id']);
    }

    public function getPayments()
    {
        return $this->hasMany(Payments::className(), ['id' => 'payment_id'])->viaTable(PaymentsToClients::tableName(), ['client_id' => 'id']);
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

    public static function find()
    {
        return new ClientsQuery(get_called_class());
    }

    public function getStatuses($status = null)
    {
        if (!empty($status) && isset($this->_statuses[$status])) {
            return $this->_statuses[$status];
        }
        return $this->_statuses;
    }

    public function linkPaymentsToClients($requestData)
    {
        $this->unlinkAll('paymentsToClients', true);
        foreach ($requestData as $paymentId) {
            $paymentsToClients = new PaymentsToClients();
            $paymentsToClients->payment_id = $paymentId;
            $this->link('paymentsToClients', $paymentsToClients);
        }
    }
}
