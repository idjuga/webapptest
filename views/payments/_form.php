<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="payments-form">
 <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'type')->dropDownList($model->getPaymentTypes()) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?=
    $form->field($model, 'clients')->checkboxList(
        \yii\helpers\ArrayHelper::map($clients, 'id', 'name'),
        [
            'class' => 'clients-container',
            'item' => function ($index, $label, $name, $checked, $value) {
                return '<div class="checkbox">'.
                    \yii\helpers\Html::checkbox($name, $checked, ['label' => $label, 'value' => $value]).
                '</div>';
            },
        ]
    );
    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
