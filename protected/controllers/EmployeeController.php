<?php

class EmployeeController extends Controller
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
         $arr =array('index', 'update', 'view', 'create', 'admin', 'downloadCV', 'Pdf', 'excelWorking', 'excelNotWorking');   /* give all access to admin */
	    } elseif( Yii::app()->user->getState('roles') =="manager") {
	      	
         $arr =array('index', 'update', 'view', 'create', 'admin', 'downloadCV', 'excelWorking', 'excelNotWorking', 'Pdf');   /* give all access to manager*/
	    } elseif( Yii::app()->user->getState('roles') =="leader") {
	      	
        $arr =array('index', 'update', 'view', 'create', 'admin', 'downloadCV', 'Pdf');   /* give all access to leader*/
	    } else {

        $arr = array('view',  'update', 'downloadCV', 'Pdf');    /*  no access to other user */
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
      parent::init();
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
    if(User::model()->getRole() > $model->user->roles) {
      throw new CHttpException(404,'You are not authorized to update This profile info !');
    } elseif (User::model()->getRole() ==  $model->user->roles && app()->user->id != $id) {
      throw new CHttpException(404,'You are not authorized to update This profile info !');
    }
    $logs = new ActivityLog;
    if(isset($logs))
    {
      $logs->activity_date = time();
      $logs->user_id = Yii::app()->user->id;
      $logs->action_id = Yii::app()->user->id;	// 	User ID
      $logs->action_group = 'employee';				// 	User Group
      $logs->activity_type = 10;					//	update User
      $logs->ip_logged = Yii::app()->request->userHostAddress;
      $logs->save();
    }
    $this->render('view',array(	'model'=>$model,));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		Yii::app()->request->redirect(app()->createUrl('/Employee/Admin'));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/vacation.css');
    $model=$this->loadModel($id);

    if($model->telephone == 0) {
      $model->setAttribute('telephone', '');
    } else {
      $model->setAttribute('telephone', '0'.$model->telephone);
    }
    if($model->mobile == 0) {
      $model->setAttribute('mobile', '');
    } else {
      $model->setAttribute('mobile', '0'.$model->mobile);
    }
    if(User::model()->getRole() > $model->user->roles) {
      throw new CHttpException(404,'You are not authorized to update This profile info !');
    } elseif (User::model()->getRole() ==  $model->user->roles && app()->user->id != $id) {
      throw new CHttpException(404,'You are not authorized to update This profile info !');
    }

		$departmentName = $model->department_id;
		$oldAvatar = $model->avatar;
		$oldCv = $model->cv;
		$model->setScenario('update');
		if(isset($_POST['Employee']))
		{
			$model->setAttributes(array('content_article'=>$_FILES['Employee']['name']['avatar'],
                                                       $_FILES['Employee']['name']['cv'],));
			$model->attributes = Clean($_POST['Employee']);
			$model->avatar = CUploadedFile::getInstance($model,'avatar');
			$model->cv = CUploadedFile::getInstance($model,'cv');
			
			$model->created_date = gettime();
			if(isset($_POST['Employee']['department_id'])) {
        $model->setDepartment($_POST['Employee']['department_id']);
      }
      if ($model->validate()) {
        //check value avatar exits
        $avatar = CUploadedFile::getInstance($model, 'avatar');
        if (is_object($avatar) && get_class($avatar)==='CUploadedFile')
        {
          $model->avatar = $avatar;
        }

        if (is_object($model->avatar)) {
          if($oldAvatar) {
            unlink(Yii::getPathOfAlias('webroot'). Employee::S_THUMBNAIL.$oldAvatar);
          }

          $model->avatar->saveAs(Yii::getPathOfAlias('webroot'). Employee::S_THUMBNAIL.$model->avatar->name);
        } else {
          $model->avatar = $oldAvatar;
        }

        //check value cv exits
        $cv = CUploadedFile::getInstance($model, 'cv');
        if (is_object($cv) && get_class($cv)==='CUploadedFile')
        {
          $model->cv = $cv;
        }

        if (is_object($model->cv)) {
          if($oldCv) {
            unlink(Yii::getPathOfAlias('webroot'). Employee::S_CVS.$oldCv);
          }

          $model->cv->saveAs(Yii::getPathOfAlias('webroot'). Employee::S_CVS.$model->cv->name);
        } else {
          $model->cv = $oldCv;
        }
        if($model->save()) {
          $logs = new ActivityLog;
          if(isset($logs))
          {
            $logs->activity_date = time();
            $logs->user_id = Yii::app()->user->id;
            $logs->action_id = $id;						// 	User ID
            $logs->action_group = 'employee';				// 	Employee Group
            $logs->activity_type = 11;					// 	update Employee
            $logs->ip_logged = Yii::app()->request->userHostAddress;
            $logs->save();
          }
          $this->redirect(array('view','id'=>$model->id));
        }
      }

    }

		$this->render('update',array('model'=>$model, 'departmentName' => $departmentName	));
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
		Yii::app()->request->redirect(app()->createUrl('/Employee/Admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Employee('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employee']))
			$model->attributes=$_GET['Employee'];

		$this->render('admin',array(	'model'=>$model,	));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Employee the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Employee::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Employee $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='employee-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

  /**
   * *download CV
   *
   * @param $id
   *
   */
  public function actionDownloadCV($id)
  {
    $model = $this->loadModel($id);
    $src = Yii::getPathOfAlias('webroot'). Employee::S_CVS.$model->cv;
    if(file_exists($src)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      //header('Content-Type: '.$mime);
      header('Content-Disposition: attachment; filename='.basename($src));
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Pragma: public');
      header('Content-Length: ' . filesize($src));
      ob_clean();
      flush();
      readfile($src);
    } else {
      header("HTTP/1.0 404 Not Found");
      exit();
    }
  }

  public function actionPdf2($id)
  {
      $model = $this->loadModel($id);
      $this->renderPartial('html2pdf', array('model' => $model));
  }
  public function actionPdf($id)
  {
    $model = $this->loadModel($id);
    $pdf = Yii::app()->ePdf->mpdf('', 'A4', 0, 'Tahoma', 2, 2, 2, 2);
    try {
      $pdf->AddPage('L');
      $pdf->useAdobeCJK = true;
      $pdf->cacheTables = false;
      $pdf->WriteHTML($this->renderPartial('htmlpage', array('model' => $model), 1));
      $pdf->Output($model->user->fullname. '.pdf', 'D');
    } catch (Exception $exc) {
      echo $exc->getTraceAsString();
    }
  }
  public function actionExcelWorking()
  {
    $issueDataProvider = $_SESSION['employee_working'];

    $this->actionExcel($issueDataProvider);
  }
  public function actionExcelNotWorking()
  {
    $issueDataProvider = $_SESSION['employee_not_working'];
    $this->actionExcel($issueDataProvider);
  }


  public function actionExcel($issueDataProvider)
  {
    $i = 0;
    $data = array();
    $data[$i]['id'] = 'id';
    $data[$i]['fullname'] = 'Fullname';
    $data[$i]['job_title'] = 'Job Title';
    $data[$i]['degree'] = 'Degree';
    $data[$i]['degree_name'] = 'Degree name';
    $data[$i]['background'] = 'Background';
    $data[$i]['telephone'] = 'Telephone';
    $data[$i]['mobile'] = 'Mobile';
    $data[$i]['homeaddress'] = 'homeaddress';
    $data[$i]['department'] = 'Department';
    $data[$i]['created_date'] = 'Created date';

    $i++;
    //populate data array with the required data elements
    foreach($issueDataProvider->data as $issue)
    {
      $data[$i]['id'] = $issue['id'];
      $data[$i]['fullname'] = $issue->user['fullname'];
      $data[$i]['job_title'] = $issue['job_title'];
      $data[$i]['degree'] = $issue['degree'];
      $data[$i]['degree_name'] = $issue['degree_name'];
      $data[$i]['background'] = $issue['background'];
      $data[$i]['telephone'] = $issue['telephone']?'0'.$issue['telephone']:'';
      $data[$i]['mobile'] = $issue['mobile']?'0'.$issue['mobile']:'';
      $data[$i]['homeaddress'] = $issue['homeaddress'];
      $data[$i]['department'] = $issue->getDepartmentName($issue['department_id']);
      $data[$i]['created_date'] = date('M-d-Y',$issue['created_date']);
//      $data[$i]['reason'] = $issue['reason'];
      $i++;
    }

    Yii::import('application.extensions.phpexcel.JPhpExcel');
    $xls = new JPhpExcel('UTF-8', false, 'My Test Sheet');
    $xls->addArray($data);
    $xls->generateXML('profile');
  }
}
