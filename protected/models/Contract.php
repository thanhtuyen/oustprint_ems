<?php

/**
 * This is the model class for table "contract".
 *
 * The followings are the available columns in table 'contract':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $created_id
 * @property integer $probation_start_date
 * @property integer $probation_end_date
 * @property integer $probation_length
 * @property integer $contract_start_date
 * @property integer $contract_length
 * @property integer $contract_end_date
 * @property integer $contract_stop_date
 * @property string $contract_stop_reason
 * @property integer $contract_status
 * @property integer $type
 * @property integer $updated_id
 * @property integer $created_date
 * @property integer $updated_date
 */

class Contract extends CActiveRecord
{
	const CONTRACT_STATUS_ON = 1;
	const CONTRACT_STATUS_OFF = 0;
  const ACTIVE = 1;
  const PROBATION_CONTRACT = 1;
  const LIMITATION_CONTRACT = 2;
  const NON_LIMITATION_CONTRACT = 3;

	public $s_month;
	public $s_day;
	public $s_year;
	public $e_month;
	public $e_day;
	public $e_year;
	public $st_month;
	public $st_day;
	public $st_year;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contract the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contract';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id, created_id, type', 'required'),
      array('contract_stop_date, contract_stop_reason', 'required', 'on' => 'stop_contract'),
			array('employee_id, created_id, contract_start_date, probation_start_date, probation_end_date, probation_length, contract_length, contract_end_date, contract_stop_date, contract_status', 'numerical', 'integerOnly'=>true),
			array('contract_stop_reason', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employee_id, created_id, contract_start_date, s_day, s_month, s_year, e_day, e_month, e_year, st_day, st_month,
			      st_year, contract_length, contract_end_date, contract_stop_date, contract_stop_reason, contract_status, type, employee', 'safe', 'on'=>'search'),
			array('contract_stop_date','compare','compareAttribute'=>'contract_start_date','operator'=>'>=',
              'allowEmpty'=>false , 'message'=>'You Stop Contract On the date before Contract Start Date','on'=>'stop'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(		
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_id'),
      'contract_salary' => array(self::HAS_ONE, 'ContractSalary', 'contract_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
      'id'          => 'ID',
			'employee_id' => 'Contract User',
			'created_id' => 'Contract Actor',
			'contract_start_date' => 'Contract Start',
			'contract_length' => 'Contract Length',
			'contract_end_date' => 'Contract End',
			'contract_stop_date' => 'Contract Stop',
			'contract_stop_reason' => 'Contract Stop Reason',
			'contract_status' => 'Contract Status',
      'type'  => 'Type',
      'updated_id' => 'Updated_id',
      'created_date' => 'Created date',
      'updated_date' => 'Updated date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//		$criteria->join = 'JOIN employee on employee.id=t.employee_id';
		$criteria->join = 'JOIN user on user.id=t.employee_id';

 		// begin code search for start day
			if($this->s_month)
			{				
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.contract_start_date), "%m") = :month_s');
				$criteria->params = array(':month_s'=>$this->s_month);		
			}
			if($this->s_day)
			{				
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.contract_start_date), "%d") = :day_s');
				$criteria->params[':day_s'] = $this->s_day;
			}	
			if($this->s_year)
			{
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.contract_start_date), "%Y") = :year_s');
				$criteria->params[':year_s'] = $this->s_year;
			}
			// End code search for start day
			
		// begin code search for end day
			if($this->e_month)
			{				
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.contract_end_date), "%m") = :month_e');
				$criteria->params[':month_e'] = $this->e_month;		
			}
			if($this->e_day)
			{				
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.contract_end_date), "%d") = :day_e');
				$criteria->params[':day_e'] = $this->e_day;
			}	
			if($this->e_year)
			{
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.contract_end_date), "%Y") = :year_e');
				$criteria->params[':year_e'] = $this->e_year;
			}
			// End code search for end day

		// begin code search for stop day
			if($this->st_month)
			{				
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.contract_stop_date), "%m") = :month_st');
				$criteria->params[':month_st'] = $this->st_month;		
			}
			if($this->st_day)
			{				
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.contract_stop_date), "%d") = :day_st');
				$criteria->params[':day_st'] = $this->st_day;
			}	
			if($this->st_year)
			{
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.contract_stop_date), "%Y") = :year_st');
				$criteria->params[':year_st'] = $this->st_year;
			}
			// End code search for stop day
//		if($this->employee)
//		{
//			//$this->employee = $this->getUserId($this->employee);
//			$criteria->compare('user.fullname',$this->employee );
//		}
//    $criteria->compare('user.id',$this->employee_id );
 		$criteria->compare('user.fullname', $this->employee, true);
 		$criteria->compare('t.contract_length',$this->contract_length);
// 		$criteria->compare('t.contract_stop_reason',$this->contract_stop_reason,true);
 		$criteria->compare('t.contract_status',$this->contract_status);
		
 		$criteria->compare('t.contract_start_date',$this->contract_start_date);
		$criteria->compare('t.contract_end_date',$this->contract_end_date);
		$criteria->compare('t.contract_stop_date',$this->contract_stop_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.id DESC',
			),			
//			'pagination' => array(
//				'pageSize' => 5,
//			),
		));
	}

	/*
	 * Get status array
	 * @return array
	 */
	public function getStatusArr() {
		return array(
			''=>'All Status',
			self::CONTRACT_STATUS_OFF => 'OFF',
			self::CONTRACT_STATUS_ON => 'ON',
		);
	}
	
	/*
	 * Convert Status from Array to string
	 */
	public function getStatusName()
	{
		$arr=$this->getStatusArr();
		return $arr[$this->contract_status];	
	}

	/*
	 * 
	 */
	public function setStatus($status) {
		$this->contract_status = $status;
	}
	/*
	 * get list user full name for contract user search
	 */
		public function getListUserSearch() {
			
			$staff = Employee::model()->findAll();
			$contract = Contract::model()->findAll();			
			
			foreach($contract as $ar)
			{	
				$alreadyid[]= $ar['employee_id'];	
			}
			
			foreach($staff as $row)
			{
				if(in_array($row['id'],$alreadyid))
					echo "\"".$row['id']."\", ";
			}
			
			return $row;
			
		}
	/*
	 * get list user full name for Actor search
	 */
		public function getListActorSearch() {
			
			$users= User::model()->findAll();	 
			foreach($users as $row)
			{					
				echo "\"".$row['fullname']."\", ";
			}
			
			return $row;
		}

		/*
		 * 
		 */
//	public function getUserId($fullname)
//	{
//		$users= Staff::model()->findAll();
//		foreach($users as $row)
//			if($row['user_full_name'] == $fullname)
//				return $row['user_id'];
//	}

	/*
	 * Get year for Search Day on Vaction
	 */
	public function getYearSearch()
	{
		$now = getdate();
		$range = 20;	//	+/- 40 years
		
    	$currentYear = $now["year"];
     //	print_r($currentYear);exit;
		$year = $currentYear - $range/2;
		$list[]= "Year";
		$list[$year] = $year;
		for($i=0;$i<=$range;$i++)
		{
			$year++;
			$list[$year] = $year;
		}
		return $list;
	}
	
	/*
	 * Get day for Search Day on Vaction
	 */
	public function get_MonthSearch() {
		return array(
			''=>'Month',
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		);
	}
	/*
	 * Get month for Search Day on Vaction
	 */
	public function get_DaySearch() {
		return array(
			''=>'Day',
			'01' => '01',
			'02' => '02',
			'03' => '03',
			'04' => '04',
			'05' => '05',
			'06' => '06',
			'07' => '07',
			'08' => '08',
			'09' => '09',
			'10' => '10',
			'11' => '11',
			'12' => '12',
			'13' => '13',
			'14' => '14',
			'15' => '15',
			'16' => '16',
			'17' => '17',
			'18' => '18',
			'19' => '19',
			'20' => '20',
			'21' => '21',
			'22' => '22',
			'23' => '23',
			'24' => '24',
			'25' => '25',
			'26' => '26',
			'27' => '27',
			'28' => '28',
			'29' => '29',
			'30' => '30',
			'31' => '31',
		);
	}

  public function getFullNameActive()
  {
    $users= User::model()->findAll(array('select' => 'id, fullname',
      'condition' => 'status =:status',
      'params' => array(':status' => self::ACTIVE)));
    $fullName = array();
    foreach($users as $user) {
      $fullName[$user['id']] = $user['fullname'];
    }

    return $fullName;
  }

  public function getListType()
  {
    return array(
      self::PROBATION_CONTRACT => 'Probation Contract',
      self::LIMITATION_CONTRACT=> 'Limitation Contract',
      self::NON_LIMITATION_CONTRACT => 'Non Limitation Contract',
    );
  }
  public function setProbationStartDate($probationStartDate)
  {
    $st = CDateTimeParser::parse($probationStartDate, 'MMM-dd-yyyy');
    return $this->probation_start_date=$st;
  }
  public function setContractStartDate($contractStart)
  {
    $st = CDateTimeParser::parse($contractStart, 'MMM-dd-yyyy');
    return $this->contract_start_date=$st;
  }

  public function setUserEndProbationDate($user_official_start_date,$user_official_probation_length)
  {
    $probation_end_date = '';
    if($user_official_start_date && $user_official_probation_length) {
      $probation_end_date = strtotime("+".$user_official_probation_length." months", strtotime($user_official_start_date)); // returns timestamp
    }
    $this->probation_end_date = $probation_end_date;
    return $this->probation_end_date;
  }
  public function setUserEndContractDate($user_official_start_date,$user_official_contract_length)
  {
    $contract_end_date = '';
    if($user_official_start_date && $user_official_contract_length) {
      $contract_end_date = strtotime("+".$user_official_contract_length." months", strtotime($user_official_start_date)); // returns timestamp
    }
    $this->contract_end_date = $contract_end_date;
    return $this->contract_end_date;
  }

  public function getYearlyDate($user_id)
  {

    $contract = Yii::app()->db->createCommand()
    ->select('id, contract_start_date, employee_id')
    ->from('Contract c')
    ->where('contract_stop_date is null')
    ->where('employee_id=:id', array(':id'=>$user_id))
    ->order('id desc')
    ->limit(1)
    ->queryRow();

    return $contract;
  }

  public function getUserId($fullname)
  {
    $users= User::model()->findAll();
    foreach($users as $row)
      if($row['fullname'] == $fullname)
        return $row['id'];
  }

  function getContract() {
    $id = Yii::app()->user->id;
    $contract = Yii::app()->db->createCommand()
      ->select('id, contract_start_date, employee_id')
      ->from('Contract c')
      ->where('contract_stop_date is null')
      ->where('employee_id=:id', array(':id'=>$id))
      ->order('id desc')
      ->limit(1)
      ->queryRow();
    return $contract['id'];
  }

}