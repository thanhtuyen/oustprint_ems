<?php

class VacationController extends Controller
{
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
		if( Yii::app()->user->getState('roles') =="admin" || Yii::app()->user->getState('roles') =="leader" ||Yii::app()->user->getState('roles') =="manager"  ) {
	    
	         $arr =array('index','create', 'update', 'view', 'admin', 'total', 'withdraw', 'accepted','request',
             'cancel', 'detail', 'decline', 'excel', 'excelAll', 'excelWaiting', 'excelRequestCancel', 'excelAccepted', 'excelDecline', 'addEmployeeVacation');   /* give all access to admin */
	    }
//    elseif( Yii::app()->user->getState('roles') =="manager" ) {
//
//	      	 $arr =array('index','create', 'update', 'view', 'admin', 'total', 'withdraw', 'accepted','request', 'cancel', 'detail', 'decline',
//             'excel', 'excelAll', 'excelWaiting', 'excelRequestCancel', 'excelAccepted', 'excelDecline', 'addEmployeeVacation');   /* give all access to manager*/
//	    } elseif( Yii::app()->user->getState('roles') =="leader") {
//
//	        $arr =array('index','create', 'update', 'view', 'admin', 'total', 'withdraw', 'accepted','request', 'cancel', 'detail', 'decline',);   /* give all access to leader*/
//	    }
    else {

	        $arr = array('view', 'create', 'update', 'withdraw', 'admin','request', 'total');    /*  no access to other user */
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
    	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/employee.css');
    	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/vacation.css');

        parent::init();
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{	
		$model = $this->loadModel($id);
		$employeeLogin = $this->loadModelEmployee(Yii::app()->user->id);
		$employeeVacation = $this->loadModelEmployee($model->user_id);
		$type = $model->getReasonSearchArr();
		$model->setAttribute('type', $type[$model->type]);
//    print_r($_GET);die;
//    $logs = new ActivityLog;
//    if(isset($logs))
//    {
//      $logs->activity_date = time();
//      $logs->user_id = Yii::app()->user->id;
//      $logs->action_id = Yii::app()->user->id;	// 	User ID
//      $logs->action_group = 'vacation';				// 	User Group
//      $logs->activity_type = 16;					//	update User
//      $logs->ip_logged = Yii::app()->request->userHostAddress;
//      $logs->save();
//    }
    $this->render('view',array(
			'model'=>$model,'employeeLogin' => $employeeLogin, 'employeeVacation' => $employeeVacation
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
    $model=new Vacation;
    $user_id = app()->user->id;
    //get total day remaining vacation
    $employee_vacation = EmployeeVacation::model()->findByAttributes(array('employee_id'=>$user_id), array('order'=>'id DESC'));
    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
    if(isset($_POST['Vacation']))
    {
      $model->setScenario('add');
      $model->attributes = Clean($_POST['Vacation']);

        $model->setTimeVacation($_POST['Vacation']['time']);
        $model->approve_id = $_POST['Vacation']['approve_id'];
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
            $logs->activity_type = 15;					// 	Create Vacation
            $logs->save();
          }

          $this->redirect(array('view','id'=>$model->id));
        }

    }
    $model->time = 'am';
    $this->render('create',array(  'model'=>$model, 'employee_vacation' => $employee_vacation));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

    if($model->status != $model::STATUS_WAITING) {
      Yii::app()->user->setFlash('warn_status', "You are requesting to update vacation that you are not authorized!" );
      Yii::app()->request->redirect(Yii::app()->createUrl('/vacation/admin'));

    }
    if(($model->user_id)<>(Yii::app()->user->id))
    {
      Yii::app()->user->setFlash("updateFail","You have no permit to update another's vacation");
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
            $logs->activity_type = 17;					// 	Update Vacation
            $logs->save();
//            echo $logs->id;
//            echo $logs->activity_type;die;
          }

          $this->redirect(array('view','id'=>$model->id));
        }

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
		// $dataProvider=new CActiveDataProvider('Vacation');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));
		Yii::app()->request->redirect(app()->createUrl('/Vacation/Admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Vacation('search');
		$model_waiting=new Vacation('search_waiting');
		$model_accepted=new Vacation('search_accepted');
		$model_request_cancel=new Vacation('search_request_cancel');
		$model_decline=new Vacation('search_decline');
    $model_withdraw=new Vacation('search_withdraw');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Vacation']))
        {
            $model->attributes=$_GET['Vacation'];
//            echo "<pre>";
//            print_r($model->attributes);die;
        }

		$this->render('admin',array(
			'model'=>$model,
            'model_waiting' => $model_waiting,
            'model_accepted' => $model_accepted,
            'model_request_cancel' => $model_request_cancel,
            'model_decline' => $model_decline,
            'model_withdraw' => $model_withdraw,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Vacation the loaded model
	 * @throws CHttpException
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
	 * @param Vacation $model the model to be validated
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
		if(isset($_POST['Vacation']['type'])){
			$type = $_POST['Vacation']['type'];
		}
		if ($type == 0)   
			return array();
		
        $data = Vacation::model()->gettotalsarr($type);
        foreach ($data as $value => $name) {
            echo CHtml::tag('option',
                    array('value' => $value), CHtml::encode($name), true);
        }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModelUser($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModelEmployee($id)
	{
		$model=Employee::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

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
      $model->setScenario('edit');
			$model->comment_four=$_POST['Vacation']['comment_four'];
			$model->setStatus(3);	//	withdraw
			if($model->save())
			{
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	Vacation ID
					$logs->action_group = 'vacation';			// 	Vacation Group
					$logs->activity_type = 13;					// 	Withdraw Vacation
					$logs->save();
				}				
				
				$this->redirect(array('view','id'=>$model->id));
			}
			else
			{ 
				throw new CHttpException(403,'Error while withdraw vacation');
			}
			
		}

		$this->render('withdraw',array(
			'model'=>$model,
		));
	}

  /**
   * @param $id
   * @throws CHttpException
   */
  public function actionAccepted($id)
	{
		$model=$this->loadmodel($id);
//    if(Yii::app()->user->getState('roles') != 'admin' && Yii::app()->user->getState('roles') != 'manager' && Yii::app()->user->getState('roles') != 'leader')
    if(Yii::app()->user->getState('roles') == 'user')
    {
      Yii::app()->user->setFlash("updateFail","You have no permit to accept the vacation");
      $this->redirect(array('admin'));
    }
    if(in_array($model->status, array(Vacation::STATUS_REQUEST_CANCEL,Vacation::STATUS_CANCEL, Vacation::STATUS_DECLINE, Vacation::STATUS_COLSED)))	// not awaiting
    {
      Yii::app()->user->setFlash("updateFail","The vacation is not awaiting. You have no permit to accept");
      $this->redirect(array('admin'));
    }
    $model->setScenario('apply');
		if(isset($_POST['Vacation']))
		{
      $model->approve_id = $_POST['Vacation']['approve_id'];

      if(Yii::app()->user->getState('roles') == 'admin'){
        $model->setStatus(7);	//	closed
        if($_POST['Vacation']['comment_three']){
          $model->comment_three=$_POST['Vacation']['comment_three'];
        }
      }elseif(Yii::app()->user->getState('roles') == 'manager') {
        $model->setStatus(6);	//	resolved
        if($_POST['Vacation']['comment_two']){
          $model->comment_two=$_POST['Vacation']['comment_two'];
        }
      }elseif(Yii::app()->user->getState('roles') == 'leader') {
        $model->setStatus(5);	//	in_progress
        $model->comment_one=$_POST['Vacation']['comment_one'];
      }

			if($model->save())
			{
        if($model->status == $model::STATUS_COLSED){
        $type = $model->type;
          switch($type) {
            case $model::REASON_ILLNESS:
              if($model->medical_certificate == 0) {
                $limit = 3;
                $this->addEmployeeVacation($model, $limit);
              }
              break;
            case $model::REASON_WEDDING:
              $limit = 3;
              $this->addEmployeeVacation($model, $limit);
              break;
            case $model::REASON_BEREAVEMENT:
              $limit = 3;
              $this->addEmployeeVacation($model, $limit);
              break;
            case $model::REASON_MATERNITY:
              $limit = 132;
              $this->addEmployeeVacation($model, $limit);
              break;
            case $model::REASON_VACATION:
              $limit = 0;
              $this->addEmployeeVacation($model, $limit);

            break;
          }
        }
				//write data into log
				$logs = new ActivityLog;
				if(isset($logs))
				{
					$logs->activity_date = time();
					$logs->user_id = Yii::app()->user->id;
					$logs->action_id = $id;						// 	Vacation ID
					$logs->action_group = 'vacation';			// 	Vacation Group
					$logs->activity_type = 18;					// 	Withdraw Vacation
					$logs->save();
				}	
				$this->redirect(array('view','id'=>$model->id));
			}
			else
			{
				throw new CHttpException(403,'Error while accepted vacation');
			}

		}

		$this->render('accepted',array(
			'model'=>$model,
		));
	}

  private function addEmployeeVacation($model, $limit)
  {
    //get total day off in current year and status is closed for type
    $vacation = Vacation::getTotalDayByType($model->user_id, $model->type, $model->medical_certificate);
    $total = $vacation['total_day_off'];
    $total_vacation = '';
    if($total > $limit) {
      $total_vacation = $total - $limit;
    }
    if($model->id){

      $employee_vacation = new EmployeeVacation;
      $employee_vacation->total_day_off = abs($total_vacation);
      $employee_vacation_old = EmployeeVacation::getEmployeeByMaxId($model->user_id);
      if($employee_vacation_old != '') {
        $employee_vacation->total_day_off = $employee_vacation_old['total_day_off'] + abs($total_vacation);
      }
      $employee_vacation->id = $model->id;
      $employee_vacation->employee_id = $model->user_id;
      $employee_vacation->yearly_date = 12;
      $employee_vacation->remaining_vacation = $employee_vacation->yearly_date - $employee_vacation->total_day_off;
      $employee_vacation->year = date('Y', time());
      $employee_vacation->save();
    }
  }

  /*
	 * Action decline a vacation
	 * if decline is successful, the browser will be redirected to the 'view' page.
	 */
  public function actionDecline($id)
  {
    $model=$this->loadmodel($id);

    if(Yii::app()->user->getState('roles') != 'admin' && Yii::app()->user->getState('roles') != 'manager')
    {
      Yii::app()->user->setFlash("updateFail","You have no permit to accept the vacation");
      $this->redirect(array('admin'));
    }
    if(($model->status)<>1)	// not awaiting
    {
      Yii::app()->user->setFlash("updateFail","The vacation is not awaiting. You have no permit to accept");
      $this->redirect(array('admin'));
    }
    $model->setScenario('apply');
    if(isset($_POST['Vacation']))
    {
      $model->comment_one=$_POST['Vacation']['comment_one'];
      $model->setStatus(4);	//	decline
      if($model->save())
      {
        $logs = new ActivityLog;
        if(isset($logs))
        {
          $logs->activity_date = time();
          $logs->user_id = Yii::app()->user->id;
          $logs->action_id = $id;						// 	Vacation ID
          $logs->action_group = 'vacation';			// 	Vacation Group
          $logs->activity_type = 19;					// 	Decline Vacation
          $logs->save();
        }

        $this->redirect(array('view','id'=>$model->id));
      }
      else
      {
        throw new CHttpException(403,'Error while decline vacation');
      }
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


    if(Yii::app()->user->getState('roles') != 'admin' && Yii::app()->user->getState('roles') != 'manager')
    {
      Yii::app()->user->setFlash("updateFail","You have no permit to accept the vacation");
      $this->redirect(array('admin'));
    }
    if(($model->status)<>2)	//	not request cancel
    {
      Yii::app()->user->setFlash("updateFail","The vacation is not requested to cancel. You have no permit to cancel");
      $this->redirect(array('admin'));
    }
    $model->setScenario('apply');
    if(isset($_POST['Vacation']))
    {
      $model->comment_three=$_POST['Vacation']['comment_three'];
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

        $this->redirect(array('view','id'=>$model->id));
      }
      else
      {
        throw new CHttpException(403,'Error while cancel vacation');
      }
    }

    $this->render('cancel',array(
      'model'=>$this->loadmodel($id),
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
    $tmp_end_day = $model->end_date;

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
    $model->setScenario('apply');
    if(isset($_POST['Vacation']))
    {
      $model->comment_four=$_POST['Vacation']['comment_four'];
      $model->setStatus(4);	//	request cancel
      if($model->save())
      {

        $logs = new ActivityLog;
        if(isset($logs))
        {
          $logs->activity_date = time();
          $logs->user_id = Yii::app()->user->id;
          $logs->action_id = $id;						// 	Vacation ID
          $logs->action_group = 'vacation';			// 	Vacation Group
          $logs->activity_type = 20;					// 	Request Cancel Vacation
          $logs->save();
        }

        //write data into employee_vacation

        if($model->type == $model::REASON_VACATION) {
          $employee_vacation= EmployeeVacation::model()->findByPk($id);
          $employee_vacation->total_day_off = $employee_vacation->total_day_off -  $model->total;
          $employee_vacation->remaining_vacation = $employee_vacation->remaining_vacation +  $model->total;
          
          $employee_vacation->save();
        }

        $this->redirect(array('view','id'=>$model->id));
      }
      else
      {
        throw new CHttpException(403,'Error while request vacation');
      }

    }

    $this->render('request',array(
      'model'=>$this->loadModel($id),
    ));
  }

  public function actionDetail() {
    //$this->render('detail',array( ));
    $items[]=array(
      'title'=>'Meeting',
      'start'=>'2012-11-23',
      'color'=>'#CC0000',
      'allDay'=>true,
      'url'=>'http://localhost/TTTN/index.php/vacation/detail'
    );
    $items[]=array(
      'title'=>'Meeting reminder',
      'start'=>'2012-11-19',
      'end'=>'2012-11-22',

      // can pass unix timestamp too
      // 'start'=>time()

      'color'=>'blue',
    );

    $data =  CJSON::encode($items);
   // echo $data;
    //echo CJSON::decode($data);
    $this->render('detail',array( 'data' => $data));
   // Yii::app()->end();

  }

  public function actionExcelAll()
  {
    $issueDataProvider = $_SESSION['vacationAll'];
    $this->actionExcel($issueDataProvider);
  }

  public function actionExcelWaiting()
  {
    $issueDataProvider = $_SESSION['vacationWaiting'];
    $this->actionExcel($issueDataProvider);
  }

  public function actionExcelRequestCancel()
  {
    $issueDataProvider = $_SESSION['vacationCancel'];
    $this->actionExcel($issueDataProvider);
  }

  public function actionExcelAccepted()
  {
    $issueDataProvider = $_SESSION['vacationAccepted'];
    $this->actionExcel($issueDataProvider);
  }
  public function actionExcelDecline()
  {
    $issueDataProvider = $_SESSION['vacationDecline'];
    $this->actionExcel($issueDataProvider);
  }


  public function actionExcel($issueDataProvider)
  {
    $i = 0;
    $data = array();
    $data[$i]['id'] = 'id';
    $data[$i]['fullname'] = 'Fullname';
    $data[$i]['request_date'] = 'Request date';
    $data[$i]['start_date'] = 'Start date';
    $data[$i]['end_date'] = 'End date';
    $data[$i]['total'] = 'Total day';
    $data[$i]['type'] = 'type';
    $data[$i]['status'] = 'status';
//    $data[$i]['reason'] = 'Reason';
    $i++;

    //populate data array with the required data elements
    foreach($issueDataProvider->data as $issue)
    {
      $data[$i]['id'] = $issue['id'];
      $data[$i]['fullname'] = $issue->user['fullname'];
      $data[$i]['request_date'] = $issue->getrequestDay();
      $data[$i]['start_date'] = $issue->getstartDate();
      $data[$i]['end_date'] = $issue->getEnddate();
      $data[$i]['total'] = $issue['total'];
      $data[$i]['type'] = $issue->getReasonName($issue['type']);
      $data[$i]['status'] = $issue->getStatusName($issue['status']);
//      $data[$i]['reason'] = $issue['reason'];
      $i++;
    }
    Yii::import('application.extensions.phpexcel.JPhpExcel');
    $xls = new JPhpExcel('UTF-8', false, 'My Test Sheet');
    $xls->addArray($data);
    $xls->generateXML('my-test');
  }
}
