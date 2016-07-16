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

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionEdit()
    {
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
            if ($model->validate() && $model->updateBook($model)) {
                Yii::app()->user->setFlash('bookSuccess', 'Данные о книге "' . $model->name . '" успешно сохранены.');
                $this->redirect('edit?id=' . $model->id);
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
        if (isset($_GET['id'])){
            $model = Book::model()->findByPk($_GET['id']);
            $model->deleteBook();
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