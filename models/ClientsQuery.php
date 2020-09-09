<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use app\models\User;
use app\models\Country;

class ClientsQuery extends ActiveQuery
{
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }

    public function onlyOwn()
    {
        return $this->andWhere(['user_id' => Yii::$app->user->id]);
    }
}
