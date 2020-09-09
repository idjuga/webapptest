<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Payments';
?>
<div class="payments-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Payments', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data){
                    return !empty($data->type) ? $data->getPaymentTypes($data->type) : '';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
