<?php
/* @var $this BooksController */
/* @var $model Book */
/* @var $form CActiveForm */

if (Yii::app()->user->hasFlash('bookError')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('bookError'); ?>
    </div>
<?php endif;

if (Yii::app()->user->hasFlash('bookSuccess')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('bookSuccess'); ?>
    </div>
<?php endif;

if (isset($model->id)):
    $this->breadcrumbs = array(
        'Книги' => '/books_task/index.php/books/index',
        'Редактирование',
    ); ?>
    <h1>Редактировать</h1>
    <p>Пожалуйста, введите новую информацию информацию книге <?php echo $model->name ?>:</p>
<?php else:
    $this->breadcrumbs = array(
        'Книги' => 'index',
        'Добавление',
    ); ?>
    <h1>Добавить книгу</h1>
    <p>Пожалуйста, введите информацию о новой книге:</p>
<?php endif; ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'book-add-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>

    <p class="note">Поля, помеченные звездочкой (<span class="required">*</span>), обязательные к заполнению.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name'); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date'); ?>
        <?php echo $form->textField($model, 'date', array(
            'placeholder' => '31/12/2014',
            'pattern' => '(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/(1[9][6-9][0-9]|2[0][01][0-9])',
        )); ?>
        <?php echo $form->error($model, 'date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'author_id'); ?>
        <?php $authors = CHtml::listData(Author::model()->findAll(), 'id', 'lastname');
        echo $form->dropDownList($model, 'author_id', $authors, array(
            'style' => "width: 250px;",
            'empty' => '--- Укажите автора книги ---',
        ));; ?>
        <?php echo $form->error($model, 'author_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'image'); ?>
        <?php echo $form->fileField($model, 'image'); ?>
        <?php echo $form->error($model, 'image'); ?>
    </div>

    <hr>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->