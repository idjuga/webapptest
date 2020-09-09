<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="payments-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data){
                    return $data->getPaymentTypes($data->type);
                }
            ],
            'description:ntext',
            [
                'attribute' => 'created_at',
                'label' => 'Created',
                'format' => 'raw',
                'value' => function($data){
                    return date('d-m-Y', $data->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Updated',
                'format' => 'raw',
                'value' => function($data){
                    return date('d-m-Y', $data->updated_at);
                }
            ],
            [
                'attribute' => 'clients',
                'label' => 'Clients',
                'format' => 'raw',
                'value' => function($data){
                    $result = [];
                    foreach ($data->clients as $client) {
                        $result[] = $client->name;
                    }
                    return implode('<br>', $result);
                }
            ],
        ],
    ]) ?>

</div>
