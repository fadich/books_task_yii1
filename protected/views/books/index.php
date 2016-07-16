<?php

/* @var $this BooksController */
/* @var $model Book */
/* @var $form CActiveForm */

$this->breadcrumbs = array(
    'Книги',
);
if (Yii::app()->user->hasFlash('guest')): ?>
    <div class="flash-notice">
        <?php echo Yii::app()->user->getFlash('guest'); ?>
    </div>
<?php endif; ?>

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

    <?php $books = $model->findAllByAttributes(array('status' => Book::STATUS_ACTIVE));
    $i = 0; ?>
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
                <!--                <td>--><?php //echo $book->id ?><!--</td>-->    <!-- id в базе данных -->
                <td><?php echo ++$i; ?></td>    <!-- Порядковый номер -->
                <td><?php echo $book->name ?></td>
                <td><?php if ($book->preview != false): ?>
                        <style>
                            .blokimg {
                                position: relative;
                            }

                            .overlay {
                                display: none;
                                height: auto;
                                left: -100%;
                                position: absolute;
                                top: -250%;
                                width: auto;
                                z-index: 999;
                            }

                            .overlay .overlay_container {
                                display: table-cell;
                                vertical-align: middle;
                            }

                            .overlay_container img {
                                background-color: #FFFFFF;
                                padding: 10px;
                                -webkit-border-radius: 5px;
                                -moz-border-radius: 5px;
                            }

                            .overlay:target {
                                display: table;
                            }
                        </style>
                        <div class="blokimg">
                            <div class="overlay" id="contenedor<?= $i ?>">
                                <div class="overlay_container">
                                    <a href=''>
                                        <?php echo '<img src="' .
                                            substr($book->preview, 13) . '" width="350px"/>' ?>
                                    </a>
                                </div>
                            </div>
                            <a href="#contenedor<?= $i ?>">
                                <?php echo '<img src="' .
                                    substr($book->preview, 13) . '" id="imagenM1" width="75px"/>' ?>
                            </a>
                        </div>
                        <?php
                    else:
                        echo 'Нет изображения...';
                    endif;
                    ?></td>
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
                                    <?php if (!Yii::app()->user->isGuest) {
                                        echo CHtml::link('[ред]', '#',
                                            array(
                                                'submit' => array(
                                                    'edit', 'id' => $book->id
                                                )));
                                    } ?>
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
                                    <?php if (!Yii::app()->user->isGuest) {
                                        echo CHtml::link('[удал]', '#',
                                            array('submit' => array('delete', 'id' => $book->id),
                                                'confirm' => 'Вы уверены, что хотите удалить книгу "' .
                                                    $book->name . '"?'));
                                    } ?>
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


<script>
    function showImage() {
    }
</script>