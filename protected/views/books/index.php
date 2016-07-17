<?php

/* @var $this BooksController */
/* @var $model Book */
/* @var $form CActiveForm */

$this->pageTitle = 'Книги';
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
            echo $form->dropDownList($model, 'filterAuthor', $authors, array(
                'style' => "width: 185px;",
                'empty' => 'автор',
            ));
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; //Два абзаца
            echo $form->textField($model, 'filterName', array('placeholder' => 'название книги'));
            ?>
        </div>
        <div>
            Дата выхода книги: &nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo $form->textField($model, 'filterDateSinceSub', array(
                'size' => 4,
                'placeholder' => '31/12/2014',
                'pattern' => '(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/(1[9][6-9][0-9]|2[0][01][0-9])',
            ));
            echo '&nbsp;&nbsp; до &nbsp;&nbsp;';
            echo $form->textField($model, 'filterDateToSub', array(
                'size' => 4,
                'placeholder' => '31/02/2015',
                'pattern' => '(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/(1[9][6-9][0-9]|2[0][01][0-9])',
            ));
            ?>
        </div>
        <div align="right">
            <?php echo CHtml::submitButton('Искать'); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php if ($model->filterDateTo < 1) {
        $model->filterDateTo = time() + time();
    }
    if (isset($_GET['id']) && $_GET['id'] > 0){
        $model->order = $_GET['id'];
    } else {
        $model->order = 1;
    }
    $orderLow = 5 * ($model->order - 1) + 1;
    $books = Book::model()->findAllBySql("select * from book where status = " . Book::STATUS_ACTIVE .
        " and name like '%" . $model->filterName . "%' and author_id like '%" . $model->filterAuthor .
        "%' and date between '" . $model->filterDateSince . "' and '" . $model->filterDateTo . "'" .
        "order by name limit " . $orderLow . ", " . 5);
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
                        <div class="blokimg">
                            <div class="overlay" id="contenedor<?= $i ?>">
                                <div class="overlay_container">
                                    <a href='#close'>
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
                <td><?php if (date('dmy') === date('dmy', $book->date)) {
                        echo 'Сегодня';
                    } elseif ((-1 * ($book->date + time() - time() - strtotime(date('d-m-Y', time())))
                            <= 3600 * 24) && (-1 * ($book->date + time() - time() - strtotime(date('d-m-Y', time())))
                            > 0)
                    ) {
                        echo 'Вчера';
                    } elseif (($book->date + time() - time() - strtotime(date('d-m-Y', time()))
                            <= 3600 * 24) && (-1 * ($book->date + time() - time() - strtotime(date('d-m-Y', time())))
                            < 0)
                    ) {
                        echo 'Завтра';
                    } else {
                        echo date('d F Y', $book->date);
                    } ?></td>
                <td><?php if (date('dmy') === date('dmy', $book->date_create)) {
                        echo 'Сегодня';
                    } elseif (-1 * ($book->date_create + time() - time() - strtotime(date('d-m-Y', time())))
                        <= 3600 * 24
                    ) {
                        echo 'Вчера';
                    } else {
                        echo date('d F Y', $book->date_create);
                    } ?></td>
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
                                    <div id="show<?= $book->id ?>" class="modal">
                                        <div class="modal-content">
                                            <span class="close<?= $book->id ?>">X</span>
                                            <p>
                                            <table>
                                                <tr>
                                                    <td width="270px">
                                                        <?php if ($book->preview != false) {
                                                            echo '<img src="' .
                                                                substr($book->preview, 13) . '" width="270px"/>';
                                                        } else {
                                                            echo '<p align="center">Нет изображения...</p>';
                                                        } ?>
                                                    </td>
                                                    <td style="font-size: 18px;">
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    <?= 'Название книги: <strong>' . $book->name . '</strong>' ?>
                                                                    <br><br>
                                                                    <?= 'Автор: <strong>' . $book->getAuthor()->firstname ?>
                                                                    <?= $book->getAuthor()->lastname . '</strong>' ?>
                                                                    <br><br>
                                                                    <?= 'Дата выхода книги: <strong>' . date('d F Y', $book->date) . '</strong>' ?>
                                                                    <br><br>
                                                                    <?= 'Дата добавления: <strong>' . date('d F Y', $book->date_create) . '</strong>' ?>
                                                                    <br><br>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="150px"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            </p>
                                        </div>
                                    </div>

                                    <a id="showBtn<?= $book->id ?>">[просм]</a>

                                    <script>
                                        var modal<?= $book->id ?> = document.getElementById("show<?= $book->id ?>");

                                        var btn<?= $book->id ?> = document.getElementById("showBtn<?= $book->id ?>");

                                        var span<?= $book->id ?> = document.getElementsByClassName("close<?= $book->id ?>")[0];

                                        btn<?= $book->id ?>.onclick = function () {
                                            modal<?= $book->id ?>.style.display = "block";
                                        }

                                        span<?= $book->id ?>.onclick = function () {
                                            modal<?= $book->id ?>.style.display = "none";
                                        }

                                        window<?= $book->id ?>.onclick = function (event) {
                                            if (event.target == modal<?= $book->id ?>) {
                                                modal<?= $book->id ?>.style.display = "none";
                                            }
                                        }
                                    </script>
                                    <style>
                                        .close<?= $book->id ?> {
                                            color: #e06060;
                                            float: right;
                                            font-size: 28px;
                                            font-weight: bold;
                                        }

                                        .close<?= $book->id ?>:hover,
                                        .close<?= $book->id ?>:focus {
                                            color: #ff2020;
                                            text-decoration: none;
                                            cursor: pointer;
                                        }
                                    </style>
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

    <?php $size = sizeof($model->findAllByAttributes(array('status' => Book::STATUS_ACTIVE)));
    $page = 1; ?>
    <div align="center">
        <?php for ($i = 0; $i < $size; $i += 5): ?>
            <?php if ($model->order != $page) {
                echo CHtml::link($page, '/books_task/index.php/books/index/' . $page++) .
                    '&nbsp;&nbsp;&nbsp;&nbsp;';
            } else {
                echo $page++ . '&nbsp;&nbsp;&nbsp;&nbsp;';
            }?>
        <?php endfor; ?>
    </div>
</div>

<style>
    /* Увеличение изображения */
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

    /* Модальное окно */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: -120px;
        width: 100%;
        height: 135%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.6);
    }

    .modal-content {
        background-color: #f8f8f8;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 55%;
    }
</style>
