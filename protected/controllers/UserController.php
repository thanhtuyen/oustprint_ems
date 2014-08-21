<?php

class UserController extends Controller
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
	    
      $arr =array('index','create', 'update', 'view', 'admin', 'changePassword', 'deactive', 'Department', 'active', 'resetPassword', 'excelActive', 'excelDeActive');   /* give all access to admin */
    } elseif( Yii::app()->user->getState('roles') =="manager") {
	      	
       $arr =array('index','create', 'update', 'view', 'admin', 'changePassword', 'Department', 'deactive', 'active', 'resetPassword', 'excelActive', 'excelDeActive');   /* give all access to manager*/
    } elseif( Yii::app()->user->getState('roles') =="leader") {
	      	
      $arr =array('index', 'view', 'admin', 'changePassword', 'Department', 'resetPassword');   /* give all access to leader*/
    } else {

      $arr = array('view', 'changePassword', 'forgotPassword', 'resetPassword');    /*  no access to other user */
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
    	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/user.css');
         
      parent::init();
    }

  /**
   * view information for user
   *
   * @param $id
   * @throws CHttpException
   */
  public function actionView($id)
	{
    $model = $this->loadModel($id);

    if(User::model()->getRole() > $model->roles) {
      throw new CHttpException(404,'You are not authorized to update This profile info !');
    } elseif (User::model()->getRole() ==  $model->roles && app()->user->id != $id) {
      throw new CHttpException(404,'You are not authorized to update This profile info !');
    }
    $lastVisit = get_date($model->lastvisit, null);
    $createdDate = get_date($model->created_date, null);
    $model->setAttribute('lastvisit', $lastVisit);
    $model->setAttribute('created_date', $createdDate);
    $logs = new ActivityLog;
    if(isset($logs))
    {
      $logs->activity_date = time();
      $logs->user_id = Yii::app()->user->id;
      $logs->action_id = Yii::app()->user->id;	// 	User ID
      $logs->action_group = 'user';				// 	User Group
      $logs->activity_type = 4;					//	update User
      $logs->ip_logged = Yii::app()->request->userHostAddress;
      $logs->save();
    }
    $this->render('view',array(	'model'=>$model,));
	}

	/**
   * add new user
   *
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User('create');
		$employeemodel=new Employee('create');
    $idLogin = app()->user->id;
    $roles = $this->getListRole($model, $idLogin);
		$employeemodel->getDepartmentOption();
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model, $employeemodel);

		if(isset($_POST['User']))
		{
      $pass = $model->autoGeneralPass();
      $model->setScenario('create');
			$model->attributes = Clean($_POST['User']);
      $model->email = textlower($_POST['User']['email']);
			$model->password = $pass;
			$model->dob = $model->setUserDob($_POST['User']['dob']);
			$model->activkey = encrypt(microtime().$model->password);
			$model->created_date = gettime();
			// validate BOTH $model and $employeemodel
     // $model->validate();
      $employeemodel->validate();
			if($model->save()) {
        //save into employee
				$employeemodel->attributes = Clean($_POST['Employee']);
				$employeemodel->id = $model->id;
				$employeemodel->created_date =  gettime();

        if(isset($_POST['Employee']['department_id'])) {
          $employeemodel->setDepartment($_POST['Employee']['department_id']);
        }
        //send mail active account
				if($employeemodel->save()) {

          $activation_url = $this->createAbsoluteUrl('/activation/Index',array("activkey" => $model->activkey,
                            "email" => $model->email));
          MailTransport::sendMail( app()->params['noreplyEmail'], $model->email, 'Welcome to EMS',
                        CController::renderPartial('emailwelcome',array('activation_url'=>$activation_url,
                            'email'=>$model->email,'password'=>$pass),true,false)
            );

          //write log
          $logs = new ActivityLog;
          if(isset($logs)) {
            $logs->activity_date = time();
            $logs->user_id = Yii::app()->user->id;
            $logs->action_id = Yii::app()->user->id;	// 	User ID
            $logs->action_group = 'user';				// 	User Group
            $logs->activity_type = 3;					//	Create
            $logs->ip_logged = Yii::app()->request->userHostAddress;
            $logs->save();
          }
          app()->user->setFlash('success', 'You create a new user successful !');
					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

		$this->render('create',array(	'model'=>$model, 'employeemodel' => $employeemodel, 'roles' => $roles));
	}

  /**
   * get list department
   *
   * @return array
   */
  public function actionDepartment()
    {
      if(isset($_POST['Employee']['department_id'])){
        $departmentId = $_POST['Employee']['department_id'];
      }
      if ($departmentId == 0)
        return array();

      $data = Employee::model()->getDepartmentList($departmentId);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option',
          array('value' => $value), CHtml::encode($name), true);
      }
    }

	/**
   *
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
    //only updated roles under now role login
    if(User::model()->getRole() > $model->roles) {
      throw new CHttpException(404,'You are not authorized to update This profile info !');
    } elseif (User::model()->getRole() ==  $model->roles && app()->user->id != $id) {
      throw new CHttpException(404,'You are not authorized to update This profile info !');
    }
    $idLogin = app()->user->id;
    $roles = $this->getListRole($model, $idLogin);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes = Clean($_POST['User']);
      $model->email = textlower($_POST['User']['email']);
			$model->dob = $model->setUserDob($_POST['User']['dob']);
			$model->updated_date = gettime();
			if($model->save()) {
				//write log system
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = Yii::app()->user->id;	// 	User ID
					$logs->action_group = 'user';				// 	User Group
					$logs->activity_type = 5;					//	update User
					$logs->ip_logged = Yii::app()->request->userHostAddress;
					$logs->save();
				}  

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(	'model'=>$model, 'roles' => $roles	));
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
		Yii::app()->request->redirect(app()->createUrl('/User/Admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
    $idLogin = app()->user->id;
    $roles = $this->getListRole($model, $idLogin);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model, 'roles' => $roles
		));
	}

  /**
   * get list roles
   *
   * @param $model
   * @param $idLogin
   * @return mixed
   */
  private function getListRole($model, $idLogin)
  {
    //get list role
    $roles = $model->getRoleOptions();
    if($model->getUserRole($idLogin) == 'admin' ){
      unset($roles[USER::ADMIN]);
    }
    elseif($model->getUserRole($idLogin) == 'manager' ){
      unset($roles[USER::ADMIN]);
      unset($roles[USER::MANAGER]);
    }
    elseif($model->getUserRole($idLogin) == 'leader'){
      unset($roles[USER::ADMIN]);
      unset($roles[USER::MANAGER]);
      unset($roles[USER::LEADER]);
    }

    return $roles;
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

  /**
   * change password
   *
   * @param $id
   * @throws CHttpException
   */
  public function actionChangePassword($id)
	{
		if($id != app()->user->id) {
			throw new CHttpException(404,'You are not authorized to update This profile info !');
		}

		$model=$this->loadModel($id);
		$password = $model->password;
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
   // $model->setScenario('changePassword');
    if(isset($_POST['User']))
    {
      if($model->encrypt($_POST['User']['old_password'])!=$password)
      {
        Yii::app()->user->setFlash('wrongPassword', "Your old password is invalid." );
      }
      else
      {
        $model->setScenario('changePassword');
        $model->password = $_POST['User']['password'];
        if($model->save()) {

          $logs = new ActivityLog;
          if(isset($logs))
          {
            $logs->activity_date = time();
            $logs->user_id = Yii::app()->user->id;
            $logs->action_id = $id;						// 	User ID
            $logs->action_group = 'user';				// 	User Group
            $logs->activity_type = 11;					// 	Change Password
            $logs->save();
          }

          //send change password email to user
          Yii::app()->user->setFlash('changedPassword', "Your password is changed." );
          $this->redirect(array('view','id'=>$model->id));
        }
      }
    }

    $this->render('changePassword',array(	'model'=>$model,));
	}

  /**
   * deactive user
   *
   * @param $id
   * @throws CHttpException
   */
  public function actionDeactive($id)
  {
    $model=$this->loadModel($id);
    $model->setScenario('deactive');
    if($id === app()->user->id || User::model()->getRole() >= $model->roles) {
      Yii::app()->user->setFlash('warn_status', "You are requesting to deactive user that you are not authorized!" );
      Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin'));
    }

    if($model->status==0)
    {
      Yii::app()->user->setFlash('warn_status', "You are requesting to deactive user that is deactive already!" );
      Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin'));
    }
    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
    //print_r($_POST);exit;
    if(isset($_POST['Deactive']))
    {
      //$model->setStatus($_POST['User']['user_active']);	//	option - need change some code in _deactive
      $model->status = 0;	//	deactive
      if($model->save())
      {
        $logs = new ActivityLog;
        if(isset($logs))
        {
          $logs->activity_date = time();
          $logs->user_id = Yii::app()->user->id;
          $logs->action_id = $id;						// 	User ID
          $logs->action_group = 'user';				// 	User Group
          $logs->activity_type = 7;					// 	Deactive User
          $logs->ip_logged = Yii::app()->request->userHostAddress;					//	Log in
          $logs->save();
        }

        $this->redirect(array('view','id'=>$model->id));
      }
    }

    $this->render('deactive',array('model'=>$model,));
  }

  /**
   *active user
   *
   * @param $id
   * @throws CHttpException
   */
  public function actionActive($id)
  {
    $model=$this->loadModel($id);
//    $model->setScenario('active');
    if($id === app()->user->id || User::model()->getRole() >= $model->roles) {
      Yii::app()->user->setFlash('warn_status', "You are requesting to deactive user that you are not authorized!" );
      Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin'));
    }

    if($model->status!=0)
    {
      Yii::app()->user->setFlash('warn_status', "You are requesting to deactive user that is deactive already!" );
      Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin'));
    }
    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
    //print_r($_POST);exit;
    if(isset($_POST['Active']))
    {
      //$model->setStatus($_POST['User']['user_active']);	//	option - need change some code in _deactive
      $model->status = 1;	//	active
      if($model->save())
      {
        $logs = new ActivityLog;
        if(isset($logs))
        {
          $logs->activity_date = time();
          $logs->user_id = Yii::app()->user->id;
          $logs->action_id = $id;						// 	User ID
          $logs->action_group = 'user';				// 	User Group
          $logs->activity_type = 8;					// 	Active User
          $logs->ip_logged = Yii::app()->request->userHostAddress;					//	Log in
          $logs->save();
        }
        Yii::app()->user->setFlash('success', "User has actived success!" );
        $this->redirect(array('view','id'=>$model->id));
      }
    }

    $this->render('active',array( 'model'=>$model,));
  }

  public function actionResetPassword($id)
  {
    $model=$this->loadModel($id);

    if(isset($_POST['User'])) {
      $model->setScenario('resetPassword');
      $model->attributes = Clean($_POST['User']);
//      $model->validate();

      if($model->save()) {
        Yii::app()->user->setFlash('resetPassword', "Your password is changed." );
        $this->redirect(array('site/logout'));
      }
    }

    $this->render('resetPassword', array('model' => $model));
  }


  /**
   *
   */
  public function actionForgotPassword()
	{
		$form = new User;
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($form);
		
		if(isset($_POST['User']))
		{
			$form->email = $_POST['User']['email'];
			// validate user input and set a sucessfull flassh message if valid   
			if($form->validate())  
			{
				//sending e-mail to user
				$this->sendForgotPasswordEmail($form->getFullName(), $form->email, $form->token);
				//Yii::app()->user->setFlash('success', $form->user_email . " has been actived to change pass." ); 
				$form = new User;
				$form->status = 'success';				
			}
		}			
		$this->render('forgotPassword',array(
			'model'=>$form
		));
		
	}

	private function sendForgotPasswordEmail($fullName, $mailto, $token) {
		try {
			$to = $mailto;
			$url = Yii::app()->createAbsoluteUrl('user/resetPassword/?token='.$token);
			$subject = 'Reset your password';
			$body = 'Dear '.$fullName.',<br><br>';			
			$body .= 'Please click on this link: <a href="'.$url.'">'.$url.'</a> to reset your password.<br><br>';
//			$body .= 'Please note that this link is only active for 6 hours after receipt. After this time limit has expired the link will not work and you will need to resubmit the password change request.';
			$body .= '<br><br>Best Regards,<br>';
			$body .= 'Validant vSource Team'; 
			MailTransport::sendMail(null, $to, $subject, $body, 'text/html');
		} catch (Exception $e) {
			    //echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

  public function actionExcelActive()
  {
    $issueDataProvider = $_SESSION['user_active'];

    $this->actionExcel($issueDataProvider);
  }
  public function actionExcelDeActive()
  {
    $issueDataProvider = $_SESSION['user_deactive'];
    $this->actionExcel($issueDataProvider);
  }

  public function actionExcel($issueDataProvider)
  {
    $i = 0;
    $data = array();
    $data[$i]['id'] = 'id';
    $data[$i]['firstname'] = 'First Name';
    $data[$i]['lastname'] = 'Last Name';
    $data[$i]['fullname'] = 'Full Name';
    $data[$i]['email'] = 'Email';
    $data[$i]['dob'] = 'Birthday';
    $data[$i]['created_date'] = 'Created date';

    $i++;
    //populate data array with the required data elements
    foreach($issueDataProvider->data as $issue)
    {
      $data[$i]['id'] = $issue['id'];
      $data[$i]['firstname'] = $issue['firstname'];
      $data[$i]['lastname'] = $issue['lastname'];
      $data[$i]['fullname'] = $issue['fullname'];
      $data[$i]['email'] = $issue['email'];
      $data[$i]['dob'] = date('M-d-Y',$issue['dob']);
      $data[$i]['created_date'] = date('M-d-y',$issue['created_date']);
//      $data[$i]['reason'] = $issue['reason'];
      $i++;
    }

    Yii::import('application.extensions.phpexcel.JPhpExcel');
    $xls = new JPhpExcel('UTF-8', false, 'My Test Sheet');
    $xls->addArray($data);
    $xls->generateXML('list user');
  }
}
