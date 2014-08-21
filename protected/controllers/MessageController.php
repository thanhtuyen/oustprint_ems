<?php

class MessageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
  public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
    if( Yii::app()->user->getState('roles') =="admin") {

      $arr =array('create', 'update', 'modUser','view', 'admin');   /* give all access to admin */
    } elseif( Yii::app()->user->getState('roles') =="manager") {

      $arr =array('create', 'update', 'modUser', 'view', 'admin');   /* give all access to manager*/
    } elseif( Yii::app()->user->getState('roles') =="leader") {

      $arr =array('create', 'update', 'modUser', 'view', 'admin');   /* give all access to leader*/
    } else {

      $arr = array('create', 'update', 'modUser', 'view', 'admin');    /*  no access to other user */
    }

    return array(array('allow',
      'actions'=>$arr,
      'users'=>array('@'),),
      array('deny',
        'users'=>array('*'),),
    );
	}
  /*
      *  init CSS and Javascript file
      */
  public function init(){
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/message.css');
    parent::init();
  }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
    $model = $this->loadModel($id);
    $mod_id= Yii::app()->user->id;
    if($model->status==$model::STATUS_PRIVATE)	//	private
    {
      if(($model->mod_sender_id<>$mod_id) && ($model->mod_user_id<>$mod_id))
        throw new CHttpException(400,'You are not authorized to perform this action.');
    }
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Message;
		if(isset($_POST['Message']))
		{
      $model->attributes=$_POST['Message'];
      $model->created_date = gettime();
      $model->mod_sender_id = Yii::app()->user->id;
//      echo "<pre>";
//      print_r($model->mod_user_id);die;
			if($model->save())
        $logs = new ActivityLog;
        if(isset($logs))
        {
          $logs->activity_date = time();
          $logs->user_id = Yii::app()->user->id;
          $logs->action_id = Yii::app()->user->id;	// 	User ID
          $logs->action_group = 'message';				// 	User Group
          $logs->activity_type = 21;					//	update User
          $logs->ip_logged = Yii::app()->request->userHostAddress;
          $logs->save();
        }
      $this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

  /**
   * @return array
   */
  public function actionModUser()
  {
    if(isset($_POST['Message']['status'])){
      $status = $_POST['Message']['status'];
    }
    $data = Message::model()->getListUserSendMessage($status);

    foreach ($data as $value => $name) {
      echo CHtml::tag('option',
        array('value' => $value), CHtml::encode($name), true);
    }
  }
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Message']))
		{
			$model->attributes=$_POST['Message'];
			if($model->save())
        $logs = new ActivityLog;
        if(isset($logs))
        {
          $logs->activity_date = time();
          $logs->user_id = Yii::app()->user->id;
          $logs->action_id = Yii::app()->user->id;	// 	User ID
          $logs->action_group = 'message';				// 	User Group
          $logs->activity_type = 22;					//	update User
          $logs->ip_logged = Yii::app()->request->userHostAddress;
          $logs->save();
        }
      $this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Message');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Message('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Message']))
			$model->attributes=$_GET['Message'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Message the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Message::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Message $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='message-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
