<?php

class BooksController extends Controller
{
    public function actionIndex()
    {
        $model = new Book();

        if (isset($_POST['add'])) {
            $this->redirect('edit');
        }

        if (isset($_POST['edit'])) {
            $this->redirect('edit?id=' . $_POST['edit']);
        }

        if (isset($_POST['page'])) {
            $model->limit = $_POST['page'];
        } else {
            $model->limit = 1;
        }

        if (isset($_POST['Book'])) {
            $this->redirect('index?filterName=' . $_POST['Book']['filterName'] .
                '&filterAuthor=' . $_POST['Book']['filterAuthor'] .
            '&filterDateSince=' . strtotime(str_replace('/', '-', $_POST['Book']['filterDateSinceSub'])) .
                '&filterDateTo=' . strtotime(str_replace('/', '-', $_POST['Book']['filterDateToSub'])));
        }

        /**
         * Не лучший исход...
         */
        if(isset($_GET['filterName'])){
            $model->filterName = $_GET['filterName'];
        }
        if(isset($_GET['filterAuthor'])){
            $model->filterAuthor = $_GET['filterAuthor'];
        }
        if(isset($_GET['filterDateSince'])){
            $model->filterDateSince = $_GET['filterDateSince'];
            if($_GET['filterDateSince'] != null) {
                $model->filterDateSinceSub = Date('d/m/Y', (int)$_GET['filterDateSince']);
            }
        }
        if(isset($_GET['filterDateTo'])){
            $model->filterDateTo = $_GET['filterDateTo'];
            if($_GET['filterDateTo'] != null) {
                $model->filterDateToSub = Date('d/m/Y', (int)$_GET['filterDateTo']);
            }
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionEdit()
    {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setFlash('guest', 'Только авторизированные пользователи могут управлять записями.');
            $this->redirect('/books_task/index.php/books/index');
        }
        /**
         * Найти существующую не удаленную книгу или создать новую
         */
        if (isset($_GET['id'])) {
            $model = ($model = Book::model()->findByPk($_GET['id'])) ?
                ($model = ($model->status == Book::STATUS_ACTIVE) ? $model : new Book()) : new Book();
        } else {
            $model = new Book();
        }

        if (isset($model->date_update)) {
            $model->date = date('d/m/Y', $model->date);
        }

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];
            $model->image = CUploadedFile::getInstance($model, 'image');
            $path = Yii::getPathOfAlias('webroot') . '/protected/uploads/' . $model->id . $model->image;
            $oldPreview = $model->preview;
            if ($model->image != null) {
                if ($model->image->saveAs($path)) {
                    $model->preview = $path;
                }
            }
            if ($model->validate() && $model->updateBook($model)) {
                if ($oldPreview != false && $model->image != false) {
                    unlink($oldPreview);
                }
                Yii::app()->user->setFlash('bookSuccess', 'Данные о книге "' . $model->name . '" успешно сохранены.');
                $this->redirect('/books_task/index.php/books/edit/' . $model->id);
            } else {
                Yii::app()->user->setFlash('bookError', 'Ошибка записи.');
            }
        }

        $this->render('edit', array(
            'model' => $model,
        ));
    }

    public function actionDelete()
    {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setFlash('guest', 'Только авторизированные пользователи могут управлять записями.');
            $this->redirect('/books_task/index.php/books/index');
        }
        if (isset($_GET['id'])) {
            $model = Book::model()->findByPk($_GET['id']);
            if (isset($model->id)) {
                $model->deleteBook();
            }
        }

        $this->redirect('/books_task/index.php/books/index');
    }

    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */
}