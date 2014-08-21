<?php
Yii::import('application.models.CalculateForm');
class ContractController extends Controller
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
      $arr = array('index', 'create', 'newContract', 'calculate', 'stop', 'view', 'pdf');
    } else if( Yii::app()->user->getState('roles') =="manager") {
      $arr = array('index', 'create', 'newContract', 'calculate', 'view', 'pdf');
    } else {
      $arr = array('view', 'pdf');
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
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/contract.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/contract.css');

    parent::init();
  }
  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
//    echo  Yii::app()->user->getState('roles') ;
//    echo $model->employee_id;
    if(User::model()->getRole() > $model->employee->user->roles) {
      Yii::app()->user->setFlash('error_view','You are not authorized to view This Contract info !');
      $this->redirect(array('dashboard/index'));
    } elseif ( Yii::app()->user->getState('roles') =="leader" || Yii::app()->user->getState('roles') =="user"){
      if(app()->user->id != $model->employee_id) {
        Yii::app()->user->setFlash('error_view','You are not authorized to view This Contract info !');
        $this->redirect(array('dashboard/index'));
      }
    }
    $this->render('view',array(
      'model'=> $model,
    ));
  }

  public function actionIndex()
  {
    $model=new Contract('search');
    $model->unsetAttributes();  // clear any default values
    if(isset($_GET['Contract']))
      $model->attributes=$_GET['Contract'];
    Yii::trace(CVarDumper::dumpAsString($model));
    $this->render('index',array(
      'model'=>$model,
    ));
  }
  public function actionNewContract()
  {
//    if( Yii::app()->user->getState('roles') !="admin" || Yii::app()->user->getState('roles') !="manager") {
//      Yii::app()->request->redirect(Yii::app()->createUrl('/dashboard'));
//    }
    $model=new Contract('create');

    if(isset($_POST['Contract']['employee_id']))
    {
      $this->redirect(array('create','id'=>$_POST['Contract']['employee_id']));
    }

    $this->render('index',array(
      'model' => $model,
    ));
  }
 /*
  *
  */

  public function actionCreate($id)
  {
    $model = new Contract('create');
    $modelContractSalary = new ContractSalary('create');

    $this->performAjaxValidation($model);
    $this->performAjaxValidation($modelContractSalary);
    if(isset($_POST['Contract']))
    {
      $model->attributes = Clean($_POST['Contract']);
      $modelContractSalary->attributes = Clean($_POST['ContractSalary']);
      $model->probation_start_date = $model->setProbationStartDate($_POST['Contract']['probation_start_date']);

      if($_POST['Contract']['probation_start_date']&& $_POST['Contract']['probation_length']) {
        $model->setUserEndProbationDate($_POST['Contract']['contract_probation_date'],$_POST['Contract']['probation_length']);
      } else if(!$_POST['Contract']['probation_length']) {
        $model->probation_end_date = 0;
      }

      $model->contract_start_date = $model->setContractStartDate($_POST['Contract']['contract_start_date']);

      if($_POST['Contract']['contract_start_date']&& $_POST['Contract']['contract_length']) {
        $model->setUserEndContractDate($_POST['Contract']['contract_start_date'],$_POST['Contract']['contract_length']);
      } else if(!$_POST['Contract']['contract_length']) {
        $model->contract_end_date = 0;
      }

      $model->created_date = gettime();
      $model->employee_id = $id;
      $model->created_id = app()->user->id ;
      $model->validate();
      $modelContractSalary->validate();
      if($model->save()) {

        //set data for contract_salary
        $modelContractSalary->contract_id=$model->id;
        $modelContractSalary->attributes = Clean($_POST['ContractSalary']);

        if($modelContractSalary->save()) {
          $logs = new ActivityLog;
          if(isset($logs))
          {
            $logs->activity_date = time();
            $logs->user_id = Yii::app()->user->id;
            $logs->action_id = Yii::app()->user->id;	// 	User ID
            $logs->action_group = 'contract';				// 	User Group
            $logs->activity_type = 23;					//	update User
            $logs->ip_logged = Yii::app()->request->userHostAddress;
            $logs->save();
          }
          $this->redirect(array('index'));
        }

      }
    }

    $this->render('create',array(	'model'=>$model, 'modelContractSalary' => $modelContractSalary));

  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionStop($id)
  {
    $model = Contract::model()->findByPk($id);
    $oldmodel = Contract::model()->findByPk($id);

    //if(isset($oldmodel->contract_status))
    if(isset($oldmodel->contract_status)&&$oldmodel->contract_status==0)
    {
      Yii::app()->user->setFlash('updateFail', "You are requesting to stop contract with ".$model->employee->user->fullname." that was stopped before!" );
      $this->redirect(array('index'));
    }

    if(isset($_POST['Contract']))
    {
      $model->setScenario('stop');
      $model->attributes=$_POST['Contract'];
      if(isset($_POST['Contract']['contract_stop_date']))
      {
        $date = $_POST['Contract']['contract_stop_date'];
        $model->contract_stop_date = CDateTimeParser::parse($date,'MM-dd-yyyy');
      }
      $model->setStatus(0);

      if($model->save())
      {
        $logs = new ActivityLog;
        if(isset($logs))
        {
          $logs->activity_date = time();
          $logs->user_id = Yii::app()->user->id;
          $logs->action_id = $id;						// 	Staff ID
          $logs->action_group = 'contract';				// 	Staff Group
          $logs->activity_type = 24;					// 	Update Staff
          $logs->save();
        }

        Yii::app()->user->setFlash('work_status', "You have just stopped the contract with ".$model->employee->user->fullname );
        $this->redirect(array('index'));
      }
    }

    $this->render('stop',array( 'model'=>$model,  ));
  }

  /*
   *
   */
  public function actionLoadnew()
  {
    $staff = Employee::model()->findAll();
    $count = 0;
    $up = 0;
    foreach($staff as $row)
    {
      $existId = Contract::model()->findByPk($row['user_id']);
      if(!isset($existId))
      {
        $model=new Contract;
        if(isset($model))
        {
          $model->contract_user = $row['user_id'];
          $model->contract_start_date = $row['user_official_start_date'];
          $model->contract_length = $row['user_official_contract_length'];
          $model->contract_end_date = $row['user_end_contract_date'];
          //$model->contract_status = 1;
          $model->contract_actor = Yii::app()->user->id;
          $model->save();
          if($model->save()) $up++;
        }
      }
      else
      {
        //$count++;
        //Yii::app()->user->setFlash('updateFail', "Some records are duplicated ".$count);
        Yii::app()->user->setFlash('updateFail', $up." records are inserted");
      }
    }

    Yii::app()->user->setFlash('work_status', "All records are inserted");
    $this->redirect(array('index'));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model=Contract::model()->findByPk($id);
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
    if(isset($_POST['ajax']) && $_POST['ajax']==='contract-form')
    {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionCalculate($id = null)
  {
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/contract.js');
    $model=new CalculateForm;

    if(isset($_POST['CalculateForm']))
    {
      $model->attributes=$_POST['CalculateForm'];
      if ($_POST['calculateWhat'] == 'net') {
        $data = $model->calculateNet();
      }
      if ($_POST['calculateWhat'] == 'gross') {
        $data = $model->calculateGross();
      }
      $salary = new Salary;
      $salary->saveSalary($_GET['id'], $data);
      if($salary->save())
      {
        $logs = new ActivityLog;
        if(isset($logs))
        {
          $logs->activity_date = time();
          $logs->user_id = Yii::app()->user->id;
          $logs->action_id = $id;						// 	Staff ID
          $logs->action_group = 'cost';				// 	Staff Group
          $logs->activity_type = 12;					// 	Update Staff
          $logs->save();
        }
      }
      Yii::app()->user->setFlash('saveSalary', 'Successfully to calculate salary of '.$_POST['employeeName']);
      $this->redirect(array('staff/index'));
    }

    // get current net salary from staff
    if ($id) {
      $staff = Employee::model()->findByPk($id);
      $model->thunhap_vnd = $staff->user_net_salary;

      $this->render('calculate',array(
        'model'=>$model,
        'staff' => $staff,
      ));
    }
    else {
      $this->render('calculate',array(
        'model'=>$model,
      ));
    }
  }

  public function actionPdf($id)
  {
    $model = $this->loadModel($id);
    if(User::model()->getRole() > $model->employee->user->roles) {
      Yii::app()->user->setFlash('error_view','You are not authorized to export  This Contract info !');
      $this->redirect(array('dashboard/index'));
    } elseif ( Yii::app()->user->getState('roles') =="leader" || Yii::app()->user->getState('roles') =="user"){
      if(app()->user->id != $model->employee_id) {
        Yii::app()->user->setFlash('error_view','You are not authorized to export This Contract info !');
        $this->redirect(array('dashboard/index'));
      }
    }
    $pdf = Yii::app()->ePdf->mpdf('', 'A4', 0, 'Tahoma', 2, 2, 2, 2);
    try {
      $pdf->AddPage('L');
      $pdf->useAdobeCJK = true;
      $pdf->cacheTables = false;
      $pdf->WriteHTML($this->renderPartial('exportPDF', array('model' => $model), 1));
      $pdf->Output($model->employee->user->fullname. '.pdf', 'D');
    } catch (Exception $exc) {
      echo $exc->getTraceAsString();
    }

  }
}
