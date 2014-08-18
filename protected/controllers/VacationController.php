<?php

class VacationController extends Controller
{
	public $defaultAction = 'admin';
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

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
				'actions'=>array('index','view','total'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','Request','Withdraw'),
				'users'=>array('@'),
			),
			array('allow', // allow manager user to perform 'create' and 'update' actions
				'actions'=>array('create','update','Request','Accept','Decline','Withdraw','Cancel'),
				'roles'=>array('manager','admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','acceptlist','awaitlist','Requestlist','declinelist'),
				'users'=>array('@'),
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
		$model=new Vacation;
		$user = User::model()->findByPk(Yii::app()->user->id);	    
		 
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Vacation']))
		{
			$model->attributes=$_POST['Vacation'];
			$model->setTimeVacation($_POST['Vacation']['time']);
			//print_r($_POST['Vacation']);exit;
			$model->setStatus(1);
			$model->user_id = Yii::app()->user->id;
			if($model->save())
			{
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = Yii::app()->user->id;	// 	Vacation ID
					$logs->action_group = 'vacation';			// 	Vacation Group
					$logs->activity_type = 13;					// 	Create Vacation
					$logs->save();
				} 
				
				$this->redirect(array('view','id'=>$model->vacation_id));
			}
		}
		$model->time = 'am';
		$this->render('create',array(
			'model'=>$model,
			'user'=>$user,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$user = User::model()->findByPk(Yii::app()->user->id);	
		 
		
		//print_r($model->user_id);print_r($user->user_id);print_r($model->status);exit;
		if(($model->user_id)<>($user->user_id))
		{
			//$this->redirect(array('view','id'=>$model->vacation_id));
			//throw new CHttpException(400,'You are not authorized to perform this action.');
			Yii::app()->user->setFlash("updateFail","You are not authorized to edit the other's vacation");
			$this->redirect(array('admin'));
		}
		if(($model->status)<>1)
		{
			//$this->redirect(array('view','id'=>$model->vacation_id));
			//throw new CHttpException(400,'You are not authorized to perform this action.');
			Yii::app()->user->setFlash("updateFail","This vacation had been ".$model->getStatusName());
			$this->redirect(array('admin'));
		}
				
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Vacation']))
		{
			$model->setScenario('edit');
			//print_r($_POST['Vacation']['start_day']);exit;
			$model->attributes=$_POST['Vacation'];
			$model->setTimeVacation($_POST['Vacation']['time']);		
			if($model->save())
			{
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	Vacation ID
					$logs->action_group = 'vacation';			// 	Vacation Group
					$logs->activity_type = 14;					// 	Update Vacation
					$logs->save();
				}
				
				$this->redirect(array('view','id'=>$model->vacation_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'user'=>$user,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
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
		$user = User::model()->findByPk(Yii::app()->user->id);
		$dataProvider=new CActiveDataProvider('Vacation', array(
			'criteria' => array(
				'with' => 'user',
			),
		));
		
	    //if($view=="quick") //$this->layout = "dialoglayout";
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'user'=>$user,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Vacation('search');//print_r($model);exit;
        $model->unsetAttributes();  // clear any default values
        //print_r($_GET);exit;
        if(isset($_GET['Vacation']))
            $model->attributes=$_GET['Vacation'];
    
        $this->render('admin',array(
            'model'=>$model,
        ));
	}
	/**
	 * Manages all models. [Accept List]
	 */
	public function actionAcceptlist()
	{
		$model=new Vacation('search');//print_r($model);exit;
        $model->unsetAttributes();  // clear any default values
        //print_r($_GET);exit;
        if(isset($_GET['Vacation']))
            $model->attributes=$_GET['Vacation'];
    
        $this->render('admin',array(
            'model'=>$model,
			'condition'=>$model->status=3,	
        ));
	}
	/**
	 * Manages all models. [Await List]
	 */
	public function actionAwaitlist()
	{
		$model=new Vacation('search');//print_r($model);exit;
        $model->unsetAttributes();  // clear any default values
        //print_r($_GET);exit;
        if(isset($_GET['Vacation']))
            $model->attributes=$_GET['Vacation'];
    
        $this->render('admin',array(
            'model'=>$model,
			'condition'=>$model->status=1,	
        ));
	}

	/**
	 * Manages all models. [Request List]
	 */
	public function actionRequestlist()
	{
		$model=new Vacation('search');//print_r($model);exit;
        $model->unsetAttributes();  // clear any default values
        //print_r($_GET);exit;
        if(isset($_GET['Vacation']))
            $model->attributes=$_GET['Vacation'];
    
        $this->render('admin',array(
            'model'=>$model,
			'condition'=>$model->status=2,	
        ));
	}
	
	/**
	 * Manages all models. [Decline List]
	 */
	public function actionDeclinelist()
	{
		$model=new Vacation('search');//print_r($model);exit;
        $model->unsetAttributes();  // clear any default values
        //print_r($_GET);exit;
        if(isset($_GET['Vacation']))
            $model->attributes=$_GET['Vacation'];
    
        $this->render('admin',array(
            'model'=>$model,
			'condition'=>$model->status=5,	
        ));
	}
	
	/*
	 * Action sent a request cancel vacation accepted
	 * if request cancel is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRequest($id)
	{
		$model=$this->loadmodel($id);
		$tmp_date = date('m-d-Y');		
		$withdraw_date = CDateTimeParser::parse($tmp_date,'MM-dd-yyyy');
		$tmp_end_day = $model->end_day;
		 
		
		/*
		print_r($tmp_end_day); print_r("<br>");
		if($tmp_end_day == $withdraw_date) print_r("=");
		if($tmp_end_day > $withdraw_date) print_r($tmp_end_day);
		if($tmp_end_day < $withdraw_date) print_r("oh yeah");
		print_r($withdraw_date); exit;
		*/
		if($model->user_id!=(Yii::app()->user->id))		
		{		
			Yii::app()->user->setFlash("updateFail","You have no permit to request cancel another's vacation");
			$this->redirect(array('admin'));
		}
		if(($model->status)<>3)	// not accepted
		{			
			Yii::app()->user->setFlash("updateFail","The vacation is not accepted. You have no permit to request cancel");
			$this->redirect(array('admin'));
		}
		if(($model->status)==3&&($tmp_end_day < $withdraw_date))	// not accepted
		{					
			throw new CHttpException(403, 'You are already on days off.');
		}
		
		if(isset($_POST['Vacation']))
		{
			$model->comment_two=$_POST['Vacation']['comment_two'];
			$model->setStatus(2);	//	request cancel
			if($model->save())
			{
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	Vacation ID
					$logs->action_group = 'vacation';			// 	Vacation Group
					$logs->activity_type = 15;					// 	Request Cancel Vacation
					$logs->save();
				}
				
				$this->redirect(array('view','id'=>$model->vacation_id));
			}
			else
			{
				throw new CHttpException(403,'Error while request vacation');
			}
			/*
			if($model->save())
			{
				echo 2;
				if ($vacation->save()) {
					echo 4;exit;
				} else {
					print_r($vacation->getErrors());
					echo 5;exit;
				}
				$this->redirect(array('view','id'=>$model->request_vacation_id));
			} else {
				echo 3;exit;
			}
			*/
		}

		$this->render('request',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/*
	 * Action accept a vacation
	 * if accept is successful, the browser will be redirected to the 'view' page.
	 */
	
	public function actionAccept($id)
	{
		$model=$this->loadmodel($id);
		 
		if(!Yii::app()->user->checkAccess('admin')&&!Yii::app()->user->checkAccess('manager'))	
		{		
			Yii::app()->user->setFlash("updateFail","You have no permit to accept the vacation");
			$this->redirect(array('admin'));
		}
		if(($model->status)<>1)	// not awaiting
		{			
			Yii::app()->user->setFlash("updateFail","The vacation is not awaiting. You have no permit to accept");
			$this->redirect(array('admin'));
		}
		
		if(isset($_POST['Vacation']))
		{
			$model->setScenario('update');
			$model->comment_one=$_POST['Vacation']['comment_one'];
			$model->setStatus(3);	//	accept
			if($model->save())
			{
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	Vacation ID
					$logs->action_group = 'vacation';			// 	Vacation Group
					$logs->activity_type = 16;					// 	Accept Vacation
					$logs->save();
				}				
				
				$this->redirect(array('view','id'=>$model->vacation_id));
			}
			else
			{
				throw new CHttpException(403,'Error while accept vacation');
			}
			/*
			if($model->save())
			{
				echo 2;
				if ($vacation->save()) {
					echo 4;exit;
				} else {
					print_r($vacation->getErrors());
					echo 5;exit;
				}
				$this->redirect(array('view','id'=>$model->request_vacation_id));
			} else {
				echo 3;exit;
			}
			*/
		}

		$this->render('accept',array(
			'model'=>$model,
		));
	}
	
	/*
	 * Action decline a vacation
	 * if decline is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionDecline($id)
	{
		$model=$this->loadmodel($id);
		 
				
		if(!Yii::app()->user->checkAccess('admin')&&!Yii::app()->user->checkAccess('manager'))			
		{
			Yii::app()->user->setFlash("updateFail","You have no permit to decline the vacation");
			$this->redirect(array('admin'));
		}
		if(($model->status)<>1)	// not awaiting
		{
			Yii::app()->user->setFlash("updateFail","The vacation is not awaiting. You have no permit to decline");
			$this->redirect(array('admin'));
		}
		
		if(isset($_POST['Vacation']))
		{
			$model->comment_one=$_POST['Vacation']['comment_one'];
			$model->setStatus(5);	//	decline
			if($model->save())
			{
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	Vacation ID
					$logs->action_group = 'vacation';			// 	Vacation Group
					$logs->activity_type = 17;					// 	Decline Vacation
					$logs->save();
				}				
				
				$this->redirect(array('view','id'=>$model->vacation_id));
			}
			else
			{
				throw new CHttpException(403,'Error while decline vacation');
			}
			/*
			if($model->save())
			{
				echo 2;
				if ($vacation->save()) {
					echo 4;exit;
				} else {
					print_r($vacation->getErrors());
					echo 5;exit;
				}
				$this->redirect(array('view','id'=>$model->request_vacation_id));
			} else {
				echo 3;exit;
			}
			*/
		}

		$this->render('decline',array(
			'model'=>$this->loadmodel($id),
		));
	}
	
	/*
	 * Action cancel a vacation
	 * if cancel is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCancel($id)
	{		
		$model=$this->loadmodel($id);
		 
				
		if(!Yii::app()->user->checkAccess('admin')&&!Yii::app()->user->checkAccess('manager'))			
		{
			Yii::app()->user->setFlash("updateFail","You have no permit to cancel the vacation");
			$this->redirect(array('admin'));
		}
		if(($model->status)<>2)	//	not request cancel
		{
			Yii::app()->user->setFlash("updateFail","The vacation is not requested to cancel. You have no permit to cancel");
			$this->redirect(array('admin'));
		}	
		if(isset($_POST['Vacation']))
		{
			$model->comment_one=$_POST['Vacation']['comment_one'];
			$model->setStatus(4);	//	cancel
			if($model->save())
			{
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	Vacation ID
					$logs->action_group = 'vacation';			// 	Vacation Group
					$logs->activity_type = 18;					// 	Cancel Vacation
					$logs->save();
				}				
				
				$this->redirect(array('view','id'=>$model->vacation_id));
			}
			else
			{
				throw new CHttpException(403,'Error while cancel vacation');
			}
			/*
			if($model->save())
			{
				echo 2;
				if ($vacation->save()) {
					echo 4;exit;
				} else {
					print_r($vacation->getErrors());
					echo 5;exit;
				}
				$this->redirect(array('view','id'=>$model->request_vacation_id));
			} else {
				echo 3;exit;
			}
			*/
		}

		$this->render('cancel',array(
			'model'=>$this->loadmodel($id),
		));
	}
	/*
	 * Action Withdraw a vacation 
	 * if Withdraw is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionWithdraw($id)
	{		
		$model=$this->loadmodel($id);
		 
				
		if(($model->user_id)<>(Yii::app()->user->id))
		{
			Yii::app()->user->setFlash("updateFail","You have no permit to withdraw another's vacation");
			$this->redirect(array('admin'));
		}
		if(($model->status)<>1)	//	not awaiting
		{
			Yii::app()->user->setFlash("updateFail","The vacation is not awaiting. You have no permit to withdraw");
			$this->redirect(array('admin'));
		}
		
		if(isset($_POST['Vacation']))
		{
			$model->comment_two=$_POST['Vacation']['comment_two'];
			$model->setStatus(4);	//	withdraw
			if($model->save())
			{
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	Vacation ID
					$logs->action_group = 'vacation';			// 	Vacation Group
					$logs->activity_type = 19;					// 	Withdraw Vacation
					$logs->save();
				}				
				
				$this->redirect(array('view','id'=>$model->vacation_id));
			}
			else
			{ 
				throw new CHttpException(403,'Error while withdraw vacation');
			}
			/*
			if($model->save())
			{
				echo 2;
				if ($vacation->save()) {
					echo 4;exit;
				} else {
					print_r($vacation->getErrors());
					echo 5;exit;
				}
				$this->redirect(array('view','id'=>$model->request_vacation_id));
			} else {
				echo 3;exit;
			}
			*/
		}

		$this->render('withdraw',array(
			'model'=>$model,
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Vacation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vacation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actiontotal()
	{
		if(isset($_POST['Vacation']['reason'])){
			$reason = $_POST['Vacation']['reason'];
		}
		if ($reason == 0)   
			return array();
		
        $data = Vacation::model()->gettotalsarr($reason);
        foreach ($data as $value => $name) {
            echo CHtml::tag('option',
                    array('value' => $value), CHtml::encode($name), true);
        }
	}
	
	/*public function actionabc()
		{
			if(isset($_POST['Vacation']['total'])){
				$total = $_POST['Vacation']['total'];
			}
			if ($total == 0)   
				return array();
			
	        $data = Vacation::model()->gettotalsarr($total);
	        foreach ($data as $value => $name) {
	            echo CHtml::tag('option',
	                    array('value' => $value), CHtml::encode($name), true);
	        }
		}*/
}
