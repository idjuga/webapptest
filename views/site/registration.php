<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-registration">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to registration:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-registration']); ?>
                <?= $form->field($model, 'subscription_type')->dropDownList($model->getSubscriptionTypes(), ['class' => 'form-control js-subscription-type']) ?>
                <?= $form->field($model, 'company_name', [
                    'options' => [
                        'class' => 'form-group js-form-group-company-name',
                        'style' => 'display: ' . (($model->subscription_type == 'Company') ? 'block' : 'none')
                    ]]); ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'email', ['enableAjaxValidation' => true]) ?>
                <?= $form->field($model, 'country')->dropDownList($countriesList); ?>
                <?= $form->field($model, 'username', ['enableAjaxValidation' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'repeat_password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<?php
$script = <<< JS
    $(document).on("change",".js-subscription-type",function(e){
        if ($(this).val() == 'Company') {
            $('.js-form-group-company-name').show();
        } else {
            $('.js-form-group-company-name').hide();
        }
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);