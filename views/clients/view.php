<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="clients-view">
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
            'note:ntext',
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
                'attribute' => 'payments',
                'label' => 'Payments',
                'format' => 'raw',
                'value' => function($data){
                    $result = [];
                    foreach ($data->payments as $payment) {
                        $result[] = $payment->name;
                    }
                    return implode('<br>', $result);
                }
            ],
        ],
    ]) ?>

</div>
