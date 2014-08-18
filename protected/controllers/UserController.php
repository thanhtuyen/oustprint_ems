<?php

class UserController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'listEmail', 'changePassword'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create', 'update' and changePassword actions
				'actions'=>array('admin','create', 'update','deactive','deactivelist','active','noworklist','nwlist','move','unmove'),
				'roles'=>array('admin', 'manager'),
			),
			array('allow', // allow authenticated user to perform 'create', 'update' and changePassword actions
                'actions'=>array('delete'),
                'roles'=>array('admin'),
            ),
			array('allow', 
				'actions'=>array('resetPassword', 'forgotPassword'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if(!Yii::app()->user->checkAccess('readUser'))
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to view user info that you are not authorized!" );  
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		} 
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if(!Yii::app()->user->checkAccess('createUser'))
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to create new user that you are not authorized!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		} 
		$model = new User('add');
		/*date_default_timezone_set('Asia/Saigon');
		$timezone = date_default_timezone_get();
        echo "The current server timezone is: " . $timezone;
		echo '<pre>=====================date()<br/>';print_r(getdate());echo '</pre><br/>=====================<br/>';
		echo '<pre>=====================date()<br/>';print_r(time());echo '</pre><br/>=====================<br/>';exit;*/
		//Get companies list
		//$companies = $this->loadCompanyList();
		//print_r(Yii::app()->user->checkAccess('manager'));exit;
		//Get roles list
		$roles = $model->getRoleOptions();//print_r($roles);exit;
		if(!Yii::app()->user->checkAccess('admin'))
            unset($roles[USER::ADMIN]);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		if(isset($_POST['User']))
		{
			$model->attributes=GlandoreHelper::clean($_POST['User']);
			$model->user_created_date = time();
			if($model->save()) {
			
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = Yii::app()->user->id;	// 	User ID
					$logs->action_group = 'user';				// 	User Group
					$logs->activity_type = 5;					// 	Create User
					$logs->save();
				} 
				
				$this->associateUserToRole($_POST['User']['user_role'], $model->user_id);
				//sending email to user
				$this->sendWelcomeEmail($model->getFullName(), $model->user_email, $model->user_username, $_POST['User']['user_password']);
				$this->redirect(array('view','id'=>$model->user_id));
			}
		}
		
		$this->render('create',array(
			'model'=>$model,
			//'company'=>$companies,
			'roles'=>$roles
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if(!Yii::app()->user->checkAccess('updateUser'))
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to update user info that you are not authorized!" ); 			 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		} 
		
		$model=$this->loadModel($id);
		$model->user_role = $model->getRoleValue();
		if(!Yii::app()->user->checkAccess('admin'))
		{
			if($model->user_role == 'admin' || ($model->user_role == 'manager' && $id != Yii::app()->user->id))
			{
				Yii::app()->user->setFlash('warn_status', "You are requesting to update manager/admin info that you are not authorized!" ); 				 
				if(!Yii::app()->user->checkAccess('manageUser'))
					Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
				else
					Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
	        } 
		}
		//Get list companies
		//$companies = $this->loadCompanyList();
		$profile = Profile::model()->findByPk($id);
		//Get roles list
		$roles = $model->getRoleOptions();
		if(!Yii::app()->user->checkAccess('admin'))
            unset($roles[USER::ADMIN]);
        if(Yii::app()->user->checkAccess('admin') && $id != Yii::app()->user->id)
        	unset($roles[USER::ADMIN]);
        if(Yii::app()->user->checkAccess('manager') && $id != Yii::app()->user->id)
        	unset($roles[USER::ADMIN]);
        if(Yii::app()->user->checkAccess('admin') && $id == Yii::app()->user->id)
        	$roles = $model->getAdminRoleOptions();
        if(Yii::app()->user->checkAccess('manager') && $id == Yii::app()->user->id)
        	$roles = $model->getManagerRoleOptions();
            
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{	$model->setScenario('update');
			$model->attributes=$_POST['User'];
			if(isset($profile))
			{
				$profile->setUserFirstName($_POST['User']['user_first_name']);
				$profile->setUserLastName($_POST['User']['user_last_name']);
				$profile->setUserFullName($_POST['User']['user_full_name']);
				$profile->save();
			}
			if($model->save()) {
			
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	User ID
					$logs->action_group = 'user';				// 	User Group
					$logs->activity_type = 6;					// 	Update User
					$logs->save();
				} 
				
				$this->deleteAllAssociateUserToRole($model->user_id);
				$this->associateUserToRole($_POST['User']['user_role'], $model->user_id);
				$this->redirect(array('view','id'=>$model->user_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			//'company'=>$companies,
			'roles'=>$roles		
		));
	}
	
	/**
	 * Deactive a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionDeactive($id)
	{
		if(!Yii::app()->user->checkAccess('deactiveUser'))
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to deactive user that you are not authorized!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		} 
		$model=$this->loadModel($id);
		$model->setScenario('deactive');
		if($model->getUserRole($id)=='admin')
		{			
			Yii::app()->user->setFlash('warn_status', "You are requesting to deactive admin that you are not authorized!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		}
		
		if($model->user_active==0)
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to deactive user that is deactive already!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		}
		
		if(!Yii::app()->user->checkAccess('admin'))
		{
			if($model->user_role == 'admin' || ($model->user_role == 'manager' && $id != Yii::app()->user->id))
			{
				Yii::app()->user->setFlash('warn_status', "You are requesting to deactive another manager/admin that you are not authorized!" ); 
				if(!Yii::app()->user->checkAccess('manageUser'))
					Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
				else
					Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
	        } 
		}
				
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        //print_r($_POST);exit;
		if(isset($_POST['Deactive']))
		{	
			
			//$model->attributes=$_POST['User'];
			//$model->setStatus($_POST['User']['user_active']);	//	option - need change some code in _deactive
			$model->setStatus(0);	//	deactive
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
					$logs->save();
				} 
				
				$this->redirect(array('view','id'=>$model->user_id));
			}
		}

		$this->render('deactive',array(
			'model'=>$model,  		
		));
	}	
	
	/**
	 * Active a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionActive($id)
	{
		if(!Yii::app()->user->checkAccess('deactiveUser'))
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to active user that you are not authorized!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		} 
		
		$model=$this->loadModel($id);
		$model->setScenario('active');
		
		if($model->user_active==1)
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to active user that is active already!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		}
		if(!Yii::app()->user->checkAccess('admin'))
		{
			if($model->user_role == 'admin' || ($model->user_role == 'manager' && $id != Yii::app()->user->id))
			{
				Yii::app()->user->setFlash('warn_status', "You are requesting to active another manager/admin that you are not authorized!" ); 
				if(!Yii::app()->user->checkAccess('manageUser'))
					Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
				else
					Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
	        } 
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Active']))
		{	
			//$model->setScenario('active');
			//$model->attributes=$_POST['User'];								
			//$model->setStatus($_POST['User']['user_active']);	//	option - need change some code in _deactive
			$model->setStatus(1);	//	active	
			if($model->save())
			{
			
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	User ID
					$logs->action_group = 'user';				// 	User Group
					$logs->activity_type = 8;					// 	Deactive User
					$logs->save();
				} 
				
				$this->redirect(array('view','id'=>$model->user_id));
			}
		}

		$this->render('active',array(
			'model'=>$model,
		));
	}	
	
	/**
	 * creates an association between the user and the user's role
	 */
	public function associateUserToRole($role, $userId)
	{
		$sql = "INSERT INTO AuthAssignment (itemname, userid, bizrule, data) VALUES (:role, :userId, '', 'N;')";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":role", $role, PDO::PARAM_STR);
		$command->bindValue(":userId", $userId, PDO::PARAM_INT);
		return $command->execute();
	}
	
	/**
	 * delete all association between the user and role
	 */
	public function deleteAllAssociateUserToRole($userId)
	{
		$sql = "DELETE FROM AuthAssignment WHERE userid =:userId";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $userId, PDO::PARAM_INT);
		return $command->execute();
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionChangePassword($id)
	{
		/*if(!Yii::app()->user->checkAccess('updateUser'))
	    {
			throw new CHttpException(403,'You are not authorized to perform this action.');
		} */
		$model=$this->loadModel($id);
		$password = $model->user_password;
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
        /*print_r($_POST['User']);echo '</br>';
        print_r($password);echo '</br>';
        print_r($_POST['User']['user_old_password']);echo '</br>';
        exit;*/
		if(isset($_POST['User']))
		{
			if($model->encrypt($_POST['User']['user_old_password'])!=$password)
			{
				Yii::app()->user->setFlash('wrongPassword', "Your old password is invalid." ); 
			}
			else
			{
				$model->setScenario('changePassword');
				$model->user_password = $_POST['User']['user_password'];
				//print_r($model->getErrors());exit;
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
					//$this->sendResetPasswordEmail($model->getFullName(), $model->user_email, $_POST['User']['user_password']);
					if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager'))
						$this->redirect(array('view','id'=>$model->user_id));		
				}
				/*else {
					print_r($model->getErrors());exit;
				}*/
			}
		}
				
		$this->render('changePassword',array(
			'model'=>$model,
		));
	}
	
	public function actionResetPassword()
	{
		$this->layout = '//layouts/resetPassword';
		$form = new ResetPasswordForm;
		
		$form->user_token = $_GET['token'];
		$user = new User;
		if(!empty($form->user_token)) {
			$user->user_token = $form->user_token;
			$userOfToken = $user->findUserByToken();
			$form->status = ($userOfToken != null);
		} else {
			$form->status = false;
		}
		
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($form);

		if(isset($_POST['ResetPasswordForm']))
		{
			$form->user_password = $_POST['ResetPasswordForm']['user_password'];
			$form->user_password_repeat = $_POST['ResetPasswordForm']['user_password_repeat'];
			$form->user_token = $_GET['token'];
			// validate user input and set a sucessfull flassh message if valid   
			if($form->validate())  
			{
				//send reset password email to user
				//$this->sendResetPasswordEmail($userOfToken->getFullName(), $userOfToken->user_email, $form->user_password);
				Yii::app()->user->setFlash('resetPassword', "Your password is changed." ); 
				$form = new ResetPasswordForm;
				$this->redirect(array('site/login'));
			}
		}
		
		$this->render('resetPassword',array(
			'model'=>$form,
		));
	}
	
	private function sendResetPasswordEmail($fullName, $mailto, $password) {
		try {
			$to = $mailto;		
			$subject = 'Your new password';
			$body = 'Dear '.$fullName.',<br><br>';			
			$body .= 'Your new password is: '.$password.'<br><br>Regards,';
			MailTransport::sendMail(null, $to, $subject, $body, 'text/html');
		} catch (Exception $e) {
		    //echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	
	public function actionForgotPassword()
	{
		$this->layout = '//layouts/resetPassword';
		$form = new ForgotPasswordForm;
		
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($form);
		
		if(isset($_POST['ForgotPasswordForm']))
		{
			$form->user_email = $_POST['ForgotPasswordForm']['user_email'];
			// validate user input and set a sucessfull flassh message if valid   
			if($form->validate())  
			{
				//sending e-mail to user
				$this->sendForgotPasswordEmail($form->getFullName(), $form->user_email, $form->token);
				//Yii::app()->user->setFlash('success', $form->user_email . " has been actived to change pass." ); 
				$form = new ForgotPasswordForm;
				$form->status = 'success';				
			}
		}			
		$this->render('forgotPassword',array(
			'model'=>$form
		));
		
	}
	
	private function sendWelcomeEmail($fullName, $mailto, $username, $password) {
		try {
			$to = $mailto;
			$url = Yii::app()->createAbsoluteUrl('site/login');
			$subject = 'Welcome letter';
			$body = 'Dear '.$fullName.',<br><br>';
			$body .= 'Your Validant vSource account is now set up! You can get access into the system with the following details:<br><br>';			
			$body .= '<a href="'.$url.'">'.$url.'</a><br>';
			$body .= 'Username: '.$username.'<br>';
			$body .= 'Password: '.$password.'<br>';
			$body .= '<br>Best Regards,<br>';
			$body .= 'Validant vSource Team'; 
			MailTransport::sendMail(null, $to, $subject, $body, 'text/html');
		} catch (Exception $e) {
		    //echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}	
	
	private function sendForgotPasswordEmail($fullName, $mailto, $token) {
		try {
			$to = $mailto;
			$url = Yii::app()->createAbsoluteUrl('user/resetPassword/?token='.$token);
			$subject = 'Reset your password';
			$body = 'Dear '.$fullName.',<br><br>';			
			$body .= 'Please click on this link: <a href="'.$url.'">'.$url.'</a> to reset your password.<br><br>';
			$body .= 'Please note that this link is only active for 6 hours after receipt.
			 After this time limit has expired the link will not work and you will need to resubmit the password change request.';
			$body .= '<br><br>Best Regards,<br>';
			$body .= 'Validant vSource Team'; 
			MailTransport::sendMail(null, $to, $subject, $body, 'text/html');
		} catch (Exception $e) {
			    //echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(!Yii::app()->user->checkAccess('deleteUser'))
	    {
			throw new CHttpException(403,'You are not authorized to perform this action.');
		} 
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{	
		Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		/*if(!Yii::app()->user->checkAccess('readUser'))
	    {
			throw new CHttpException(403,'You are not authorized to perform this action.');
		}
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        
		if(!Yii::app()->user->checkAccess('manageUser'))
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to manage user that you are not authorized!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		}
		$model=new User('search');
		$model->pageSize = Yii::app()->user->getState('pageSize');
		//print_r($_GET);exit;
		//Get roles list
		$roles = $model->getRoleOptions();//print_r($roles);exit;
			
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
			'roles'=>$roles,
		));
	}
	/**
	 * Manages all models. [Non-working List]
	 */
	public function actionNoworklist()
	{
        
		if(!Yii::app()->user->checkAccess('manageUser'))
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to manage user that you are not authorized!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		}
		$model=new User('search2'); 
		$model->pageSize = Yii::app()->user->getState('pageSize');
		//print_r($_GET);exit;
		//Get roles list
		$roles = $model->getRoleOptions();//print_r($roles);exit;
			
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('noworklist',array(
			'model'=>$model,
			'roles'=>$roles
		));
	}
	/**
	 * Manages all models. [Deactive List]
	 */
	public function actionDeactivelist()
	{
        
		if(!Yii::app()->user->checkAccess('manageUser'))
	    {
			Yii::app()->user->setFlash('warn_status', "You are requesting to manage user that you are not authorized!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		}
		$model=new User('search');
		$model->pageSize = Yii::app()->user->getState('pageSize');
		//print_r($_GET);exit;
		//Get roles list
		$roles = $model->getRoleOptions();//print_r($roles);exit;
			
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('deactivelist',array(
			'model'=>$model,
			'roles'=>$roles,			
			'condition'=>$model->user_active=0
		));
	} 

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->with('profile')->findByPk((int)$id);
		if($model===null)
		{
			Yii::app()->user->setFlash('warn_status', "You are requesting to do some action with user has user_id=".$id." that does not exist!" ); 
			if(!Yii::app()->user->checkAccess('manageUser'))
				Yii::app()->request->redirect(Yii::app()->createUrl('/')); 
			else
				Yii::app()->request->redirect(Yii::app()->createUrl('/user/admin')); 
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
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
	 * Get the list of companies
	 */
	public function loadJobFunction(){
		/*$list_company = Company::model()->findAll(array(
			'condition'=>'company_status=:company_status',
			'params'=> array(':company_status'=>'1'),
			'order' => 'company_name asc')
		);
		$companies = array(''=>'Select a company');
		foreach($list_company as $company){
			$companies[$company->company_id] = $company->company_name;
		}
		return $companies;*/
	}
	
	public function actionListEmail() {
		$emails = Yii::app()->db->createCommand()
			->select('user_first_name, user_last_name, user_full_name, user_email, user_id')
    		->from('user')
//			->where('id=:id', array(':id'=>1))
			->order('user_first_name')
			->queryAll();
		$len = count($emails);
		for($i = 0; $i < $len; $i++) {
			$emails[$i] = array(
				'value' => $emails[$i]['user_email'],
				'key' => "{$emails[$i]['user_first_name']} {$emails[$i]['user_last_name']}",
			);
		}
		echo CJSON::encode($emails);
	}
    
    /**
     * Display profile of a user
     */
    public function actionProfile() {
        //$this->render('profile');
    }
    
    public function actionNwlist($id)
    {
		
        $profile = Profile::model()->findByPk($id);
        
        if(!Yii::app()->user->checkAccess('manageUser'))
        { 
			Yii::app()->user->setFlash('work_status', "You are not authorized to perform this action" ); 
			if($profile->user_status==0)	Yii::app()->request->redirect(Yii::app()->createUrl('/profile/admin')); 
			if($profile->user_status==1)	Yii::app()->request->redirect(Yii::app()->createUrl('/profile/noworklist')); 
        }
        $model=$this->loadModel($id);
        
        if($model->getUserRole($id)=='admin')
        {  
			Yii::app()->user->setFlash('work_status', "You are not authorized to perform this action for admin" ); 
			if($profile->user_status==0)	Yii::app()->request->redirect(Yii::app()->createUrl('/profile/admin')); 
			if($profile->user_status==1)	Yii::app()->request->redirect(Yii::app()->createUrl('/profile/noworklist')); 
        }
        
        if($model->user_active==0)
        {            
			Yii::app()->user->setFlash('work_status', "This profile user is deactive" ); 
        }
        if($model->user_active==1)
        {            
			Yii::app()->user->setFlash('work_status', "This profile user is deactive" ); 
        }
        
        if(!Yii::app()->user->checkAccess('admin'))
        {
            if($model->user_role == 'admin' || ($model->user_role == 'manager' && $id != Yii::app()->user->id))
            {
				Yii::app()->user->setFlash('work_status', "You are not authorized as admin/owner to perform this action" ); 
				if($profile->user_status==0)	Yii::app()->request->redirect(Yii::app()->createUrl('/profile/admin')); 
				if($profile->user_status==1)	Yii::app()->request->redirect(Yii::app()->createUrl('/profile/noworklist')); 
            } 
        }
		
        if($profile->user_status==0)
        {            
			Yii::app()->user->setFlash('work_status', "This profile user is working" ); 
        }
        if($profile->user_status==1)
        {            
			Yii::app()->user->setFlash('work_status', "This profile user is non-working" ); 
        }
		
        if($profile)
        {
	        $this->render('nwlist',array(
	            'model'=>$profile,
	        ));
        }
        else
		{
			Yii::app()->user->setFlash('work_status', "This user has no profile" ); 
			if($profile->user_status==0)	Yii::app()->request->redirect(Yii::app()->createUrl('/profile/admin')); 
			if($profile->user_status==1)	Yii::app()->request->redirect(Yii::app()->createUrl('/profile/noworklist')); 
		}
    }
    
    public function actionMove($id)
    {
        
        if(!Yii::app()->user->checkAccess('manageUser'))
        {
            throw new CHttpException(403,'You are not authorized to perform this action.');
        }
        $model=$this->loadModel($id);
        
        if($model->getUserRole($id)=='admin')
        {
            throw new CHttpException(403,'You are not authorized to perform this action.');  
        }
        
        if($model->user_active==0)
        {            
			Yii::app()->user->setFlash('work_status', "This profile user is in working list already" ); 
        }
        
        if(!Yii::app()->user->checkAccess('admin'))
        {
            if($model->user_role == 'admin' || ($model->user_role == 'manager' && $id != Yii::app()->user->id))
            {
                throw new CHttpException(403,'You are not authorized to perform this action.');
            } 
        }
        $profile = Profile::model()->findByPk($id);
        $profile->user_status = 1;
        $model->user_active = 0;
        if($profile->save())
        { 		
		
			$logs = new ActivityLog;
			if(isset($logs))
			{
				$logs->activity_date = time();
				$logs->user_id = Yii::app()->user->id;
				$logs->action_id = $id;						// 	Profile ID
				$logs->action_group = 'profile';			// 	Profile Group
				$logs->activity_type = 9;					// 	Move User To Non-working
				$logs->save();
			}
			
			Yii::app()->request->redirect(Yii::app()->createUrl('/profile/noworklist')); 
        }
    }
    
    public function actionUnmove($id)
    {
        
        if(!Yii::app()->user->checkAccess('manageUser'))
        {
            throw new CHttpException(403,'You are not authorized to perform this action.');
        }
        $model=$this->loadModel($id);
        
        if($model->getUserRole($id)=='admin')
        {
            throw new CHttpException(403,'You are not authorized to perform this action.');  
        }
        
        if($profile->user_status==1)
        {            
			Yii::app()->user->setFlash('work_status', "This profile user is in non-working list already" ); 
        }
        
        if(!Yii::app()->user->checkAccess('admin'))
        {
            if($model->user_role == 'admin' || ($model->user_role == 'manager' && $id != Yii::app()->user->id))
            {
                throw new CHttpException(403,'You are not authorized to perform this action.');
            } 
        }
        $profile = Profile::model()->findByPk($id);
        $profile->user_status = 0;
        $model->user_active = 1;
        if($profile->save())
		{	
		
			$logs = new ActivityLog;
			if(isset($logs))
			{
				$logs->activity_date = time();
				$logs->user_id = Yii::app()->user->id;
				$logs->action_id = $id;						// 	Profile ID
				$logs->action_group = 'profile';			// 	Profile Group
				$logs->activity_type = 10;					// 	Move User To Working
				$logs->save();
			}
			
            Yii::app()->request->redirect(Yii::app()->createUrl('/profile/admin')); 
		}
        
    }
	
	
	/*End*/
}