<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}


  public function actionIndex()
  {
    Yii::app()->request->redirect(Yii::app()->createUrl('/dashboard'));
  }
  public function actionAdmin()
  {
    Yii::app()->request->redirect(Yii::app()->createUrl('/dashboard'));
  }
  public function actionCreate()
  {
    Yii::app()->request->redirect(Yii::app()->createUrl('/dashboard'));
  }
  public function actionView()
  {
    Yii::app()->request->redirect(Yii::app()->createUrl('/dashboard'));
  }
  public function actionUpdate()
  {
    Yii::app()->request->redirect(Yii::app()->createUrl('/dashboard'));
  }
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

  /**
   * Displays the login page
   */
  public function actionLogin()
  {
    $this->layout="login";
    if(Yii::app()->request->isAjaxRequest){
      throw new CHttpException(500,'Permission denied');
    }
    if(Yii::app()->user->id) {
      $this->redirect('index');
    }
    $model=new LoginForm;

    // if it is ajax validation request
    if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
    {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }

    // collect user input data
    if(isset($_POST['LoginForm']))
    {
      $model->attributes=$_POST['LoginForm'];
      // validate user input and redirect to the previous page if valid
      if($model->validate() && $model->login())
      {
//        $logs = new ActivityLog;
//        if(isset($logs))
//        {
//          $logs->activity_date = time();
//          $logs->user_id = Yii::app()->user->id;
//          $logs->action_id = Yii::app()->user->id;	// 	User ID
//          $logs->action_group = 'user';				// 	User Group
//          $logs->activity_type = 1;					//	Log in
//          $logs->save();
//        }
        $this->redirect(Yii::app()->user->returnUrl);
//        Yii::app()->request->redirect(Yii::app()->createUrl('/Vacation'));echo 111;die;
      }
    }
    // display the login form
    $this->render('login',array('model'=>$model));
  }

  /**
   * Logs out the current user and redirect to homepage.
   */
  public function actionLogout()
  {

    //print_r(Yii::app()->createUrl()); exit;
    //print_r(Yii::app()->createUrl('site/login')); exit;
    //print_r(Yii::app()->request->getBaseUrl()); exit;
    $logs = new ActivityLog;

    if(isset($logs))
    {
      $logs->activity_date = time();
      $logs->user_id = Yii::app()->user->id;
      $logs->action_id = Yii::app()->user->id;	// 	User ID
      $logs->action_group = 'user';				// 	User Group
      $logs->activity_type = 2;					//	Log out
      $logs->save();
    }
    Yii::app()->user->logout();
    $this->redirect(Yii::app()->createUrl('site/login'));

  }
}