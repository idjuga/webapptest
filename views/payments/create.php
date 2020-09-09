<?php

use yii\helpers\Html;

$this->title = 'Create Payment';
?>
<div class="payments-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'clients' => $clients,
    ]) ?>
</div>
