<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
/**
 * Registration form
 */
class RegistrationForm extends Model
{

    public $subscription_type;
    public $company_name;
    public $name;
    public $email;
    public $country;
    public $username;
    public $password;
    public $repeat_password;

    protected $_subscriptionTypes = [
        'Individual' => 'Individual',
        'Company' => 'Company'
    ];

    public function rules()
    {
        return [
            [['subscription_type', 'name', 'email', 'country', 'username', 'password', 'repeat_password'], 'trim'],
            [['subscription_type', 'name', 'email', 'country', 'username', 'password', 'repeat_password'], 'required'],
            ['subscription_type', 'default', 'value'=> 'Individual'],
            [['name', 'email', 'username', 'password'], 'string', 'max' => 255],
            ['email', 'email'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => 'This username has already been taken.'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => 'This email address has already been taken.'],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country' => 'id']],
            ['subscription_type', 'in', 'range' => array_keys($this->_subscriptionTypes)],
            ['company_name', 'required', 'when' => function($model) {
                return $model->subscription_type == 'Company';
            }, 'whenClient' => "function (attribute, value) {
                return $('.js-subscription-type').val() == 'Company';
            }"],
            ['repeat_password', 'compare', 'compareAttribute'=>'password']
        ];
    }

    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->subscription_type = $this->subscription_type;
        $user->company_name = $this->company_name;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->country = $this->country;
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

    public function getSubscriptionTypes()
    {
        return $this->_subscriptionTypes;
    }
}