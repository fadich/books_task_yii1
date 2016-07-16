<?php

class BooksController extends Controller
{
	public function actionIndex()
	{
		$model = new Book();

		if (isset($_POST['add'])){
			$this->redirect('edit');
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionEdit()
	{
		if (isset($_GET['id'])) {
			$model = ($model = Book::model()->findByPk($_GET['id'])) ? $model : new Book();
		} else {
			$model = new Book();
		}

		if(isset($model->date_update)){
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