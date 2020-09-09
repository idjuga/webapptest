<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Clients';
?>
<div class="clients-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Clients', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data){
                    return $data->getStatuses($data->status);
                }
            ],
            [
                'attribute' => 'country',
                'format' => 'raw',
                'value' => function($data){
                    return $data->countryData->name_en;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
