<?php

use yii\helpers\Html;

$this->title = 'Update Clients: ' . $model->name;
?>
<div class="clients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'countriesList' => $countriesList,
        'payments' => $payments
    ]) ?>

</div>