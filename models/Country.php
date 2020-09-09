<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\User;
use app\models\Clients;

/**
 * Country model.
 *
 * @property int $id
 * @property int $number
 * @property string $alpha
 * @property int $calling
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_uk
 * @property Clients $clients
 * @property User $users
 */
class Country extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%country}}';
    }

    public function rules()
    {
        return [
            [['number', 'alpha', 'calling', 'name_en', 'name_ru', 'name_uk'], 'required'],
            [['number', 'calling'], 'integer'],
            [['alpha'], 'string', 'max' => 2],
            [['name_en', 'name_ru', 'name_uk'], 'string', 'max' => 255],
            [['alpha'], 'unique'],
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['country' => 'id']);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['country' => 'id']);
    }


    public static function getCoutriesList()
    {
        $countries = Country::find()
            ->select(['id', 'name_en'])
            ->asArray()
            ->all();
        $countries = array_reduce($countries, function ($result, $item) {
                $result[$item['id']] = $item['name_en'];
                return $result;
            }, array());
        return $countries;
    }
}
