<?php

/* @var $this BooksController */
/* @var $model Book */
/* @var $form CActiveForm */

$this->breadcrumbs = array(
    'Книги',
);
?>
<h1>Книги</h1>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'add-book-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    echo CHtml::submitButton('+ Добавить', array(
        'name' => 'add',
    ));
    $this->endWidget(); ?>

</div>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'filter-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <div class="row">
        <div>
            <?php $authors = CHtml::listData(Author::model()->findAll(), 'id', 'lastname');
            echo $form->dropDownList($model, 'author_id', $authors, array(
                'style' => "width: 185px;",
                'empty' => 'автор',
            ));
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; //Два абзаца
            echo $form->textField($model, 'name', array('placeholder' => 'название книги'));
            ?>
        </div>
        <div>
            Дата выхода книги: &nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo $form->textField($model, 'date', array(
                'size' => 4,
                'placeholder' => '31/12/2014',
                'pattern' => '(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/(1[9][6-9][0-9]|2[0][01][0-9])',
            ));
            echo '&nbsp;&nbsp; до &nbsp;&nbsp;';
            echo $form->textField($model, 'date', array(
                'size' => 4,
                'placeholder' => '31/12/2015',
                'pattern' => '(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/(1[9][6-9][0-9]|2[0][01][0-9])',
            ));
            ?>
        </div>
        <div align="right">
            <?php echo CHtml::submitButton('Искать'); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $books = $model->findAllByAttributes(array('status' => Book::STATUS_ACTIVE)); ?>
    <table border="1" rules="all" style="border: #0f0f0f">
        <tr style="background-color: #BBBBBB">
            <th width="3%">ID</th>
            <th width="18%">Название</th>
            <th width="12%">Превью</th>
            <th width="17%">Автор</th>
            <th width="15%">Дата выхода книги</th>
            <th width="15%">Дата добавления</th>
            <th width="20%">Кнопки действия</th>
        </tr>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo $book->id ?></td>
                <td><?php echo $book->name ?></td>
                <td><?php echo $book->preview ?></td>
                <td><?php echo $book->getAuthor()->firstname . ' ' . $book->getAuthor()->lastname ?></td>
                <td><?php echo date('d F Y', $book->date) ?></td>
                <td><?php echo date('d F Y', $book->date_create) ?></td>
                <td>
                    <table>
                        <tr>
                            <div class="form">
                                <?php $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'add-book-form',
                                    'enableClientValidation' => true,
                                    'clientOptions' => array(
                                        'validateOnSubmit' => true,
                                    ),
                                )); ?>
                                <td><br>
                                    <?php echo CHtml::link('[ред]', '#',
                                        array(
                                            'submit' => array(
                                                'edit', 'id' => $book->id
                                            ))); ?>
                                </td>
                                <td><br>
                                    <?php echo CHtml::link('[просм]', '#',
                                        array(
//                                            'submit' => array(
//                                                'edit', 'id' => $book->id
//                                            )
                                        )); ?>
                                </td>
                                <td><br>
                                    <?php echo CHtml::link('[удал]', '#',
                                        array('submit' => array('delete', 'id' => $book->id), 'confirm' => 'Are you sure?')); ?>
                                </td>
                                <?php $this->endWidget(); ?>
                            </div>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
