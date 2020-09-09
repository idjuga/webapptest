<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="clients-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php $model->status = $model->isNewRecord ? $model::DEFAULT_STATUS : $model->status; ?>
    <?= $form->field($model, 'status')->dropDownList($model->getStatuses()) ?>
    <?= $form->field($model, 'country')->dropDownList($countriesList); ?>
    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    <?=
    $form->field($model, 'payments')->checkboxList(
        \yii\helpers\ArrayHelper::map($payments, 'id', 'name'),
        [
            'class' => 'payments-container',
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
