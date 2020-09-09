<?php

use yii\helpers\Html;

$this->title = 'Create Client';
?>
<div class="clients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'countriesList' => $countriesList,
        'payments' => $payments
    ]) ?>

</div>
