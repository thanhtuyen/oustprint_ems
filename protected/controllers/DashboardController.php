<?php

/**
 * Dashboard controller
 *
 */

class DashboardController extends Controller {

    /**
     * Index action
     */

    public function actionIndex() {
        $id = Yii::app()->user->id;
        $usr = User::model()->findByPk(Yii::app()->user->id);


        $dataProvider=new CActiveDataProvider('Message',
            array (
                'criteria' => array(
                    'order'=>'mod_user_id DESC',
                    'condition'=>"mod_user_id = (".$id.") || mod_sender_id = (".$id.") || status = 1",
                ),
                'sort'=>array(
                    'defaultOrder'=>'id DESC',
                ),
                'pagination' => array(
                    'pageSize' => 5,
                ),
            ));

        $user=new CActiveDataProvider('User',
            array (
                'criteria' => array(
                    'order'=>'id DESC',
                    'condition'=>"status = 1",
                ),
                'sort'=>array(
                    'defaultOrder'=>'id DESC',
                ),
                'pagination' => array(
                    'pageSize' => 10,
                ),
            ));
        if($usr->getUserRole($id)== 'user')
        {
            $vacation=new CActiveDataProvider('Vacation',
                array (
                    'criteria' => array(
                        'order'=>'id DESC',
                        'condition'=>"status != 4 && user_id = (".$id.")",
                    ),
                    'sort'=>array(
                        'defaultOrder'=>'id DESC',
                    ),
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        }
        else
        {
            $vacation=new CActiveDataProvider('Vacation',
                array (
                    'criteria' => array(
                        'order'=>'id DESC',
                        'condition'=>"status = 1 || status = 2",
                    ),
                    'sort'=>array(
                        'defaultOrder'=>'id DESC',
                    ),
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                ));
        }

        $profile=new CActiveDataProvider('Employee',
            array (
                'criteria' => array (
                    'order'=>'id DESC',
                ),
                'sort'=>array(
                    'defaultOrder'=>'id DESC',
                ),
                'pagination' => array (
                    'PageSize' => 10,
                ),
            ));


        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'vacation'=>$vacation,
            'profile'=>$profile,
            'user'=>$user,
        ));
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

  /*
       *  init CSS and Javascript file
       */
  public function init(){

    parent::init();
  }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index','sample','viewmessage','viewvacation', 'admin'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionSample()
    {
        $model=new SampleModel;
        if(isset($_POST['SampleModel']))
        {
            $model->attributes=$_POST['SampleModel'];
            if($model->validate())
            {
                // form inputs are valid, do something here
                DialogBox::closeDialogBox($model->name,"index.php/dashboard/");
                return;
            }
        }

        /*
         * to present an specific dialogBox layout, create a new one
         * layout in views/layout and then uncomment this lines:
         */
        /* to set an specific layout for dialogboxes */
        $this->layout = "dialoglayout";

        $this->render('sample',array('model'=>$model));
    }

    public function loadModel($id)
    {
        $model=Message::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function actionViewmessage($id)
    {
        $model = Message::model()->findByPk($id);
        if(isset($_POST['Message']))
        {
            $model->attributes=$_POST['Message'];
            if($model->validate())
            {
                // form inputs are valid, do something here
                DialogBox::closeDialogBox();
                return;
            }
        }

        /*
         * to present an specific dialogBox layout, create a new one
         * layout in views/layout and then uncomment this lines:
         */
        /* to set an specific layout for dialogboxes */
        $this->layout = "dialoglayout";

        $this->render('viewmessage',array(
            'model'=>$model,
        ));
    }

    public function actionViewvacation($id,$quick="quick")
    {
        $model = Vacation::model()->findByPk($id);
        if(isset($_POST['Vacation']))
        {
            $model->attributes=$_POST['Vacation'];
            if($model->validate())
            {
                // form inputs are valid, do something here
                DialogBox::closeDialogBox();
                return;
            }
        }

        $view = "quick";
        $this->layout = "dialoglayout";

        /*
         * to present an specific dialogBox layout, create a new one
         * layout in views/layout and then uncomment this lines:
         */
        /* to set an specific layout for dialogboxes */

        $this->render('viewvacation',array(
            'model'=>$model,
            'view'=>$view,
        ));
    }
  public function actionAdmin()
  {
    $this->render('admin',array(

    ));
  }
}