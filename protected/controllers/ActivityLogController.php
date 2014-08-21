<?php

class ActivityLogController extends Controller
{
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

    if( Yii::app()->user->getState('roles') =="admin" || Yii::app()->user->getState('roles') =="manager") {

      $arr =array('admin');
    }
    return array(array('allow',
      'actions'=>$arr,
      'users'=>array('@'),),
      array('deny',
        'users'=>array('*'),),
    );

  }
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    /*$dataProvider=new CActiveDataProvider('ActivityLog');
    $this->render('index',array(
      'dataProvider'=>$dataProvider,
    ));*/
    Yii::app()->request->redirect(Yii::app()->createUrl('/activityLog/admin'));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model=new ActivityLog('search');
    $model->unsetAttributes();  // clear any default values
    if(isset($_GET['ActivityLog']))
      $model->attributes=$_GET['ActivityLog'];

    $this->render('admin',array(
      'model'=>$model,
    ));
  }

}