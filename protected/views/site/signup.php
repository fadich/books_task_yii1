<?php
/* @var $this SiteController */
/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Signup';
$this->breadcrumbs=array(
    'Login' => 'Login',
    'Signup',
);

if (Yii::app()->user->hasFlash('registration')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('registration'); ?>
    </div>
<?php endif; ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-signup-form',
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->emailField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->