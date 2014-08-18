<?php

/**
 * This is the model class for table "vacation".
 *
 * The followings are the available columns in table 'vacation':
 * @property integer $vacation_id
 * @property integer $start_day
 * @property integer $end_day
 * @property decimal $total
 * @property string $reason
 * @property string $more_reason
 * @property string $user_id
 * @property integer $request_day
 *
 * The followings are the available model relations:
 * @property VvUser $user
 */
class Vacation extends CActiveRecord
{
	const REASON_VACATION = 1;
	const REASON_ILLNESS = 2;
	const REASON_WEDDING = 3;
	const REASON_BEREAVEMENT = 4;
	const REASON_MATERNITY = 5;
	
	const STATUS_WAITING=1;			//	Waiting
	const STATUS_REQUEST_CANCEL=2;	//	Request Cancel
	const STATUS_ACCEPT=3;			//	Accept
	const STATUS_CANCEL=4;			// 	Cancel
	const STATUS_DECLINE=5;			// 	Decline
	
	const AM = 'am';
    const PM = 'pm';
	
    public $days;
    public $re_day;
	public $re_month;
	public $re_year;
	public $st_day;
	public $st_month;
	public $st_year;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Vacation the static model class
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
		return 'vacation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_day, total, reason', 'required'),
			array('reason', 'in', 'range'=>array(self::REASON_VACATION,self::REASON_ILLNESS,self::REASON_WEDDING,self::REASON_BEREAVEMENT,self::REASON_MATERNITY)),
			array('status', 'in', 'range'=>array(self::STATUS_WAITING,self::STATUS_REQUEST_CANCEL,self::STATUS_ACCEPT, self::STATUS_CANCEL, self::STATUS_DECLINE)),
			array('start_day, end_day, request_day, reason, status', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical', 'min'=>0.25, 'max'=>999.75, 'tooBig'=>'Long Time', 'tooSmall'=>'Invalid Number' ),
		 
			array('more_reason', 'length'),
			array('user_id', 'length', 'max'=>12),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('vacation_id, start_day, st_day, st_month, st_year, request_day, re_day, re_month, re_year, end_day, total, reason, user_id, status, time', 'safe', 'on'=>'search'),
			/*array('start_day','compare','compareAttribute'=>'end_day','operator'=>'<=', 
              'allowEmpty'=>false , 'message'=>'You entered the end date less than the start date. ','on'=>'create,update'),
			array('total','compare','compareAttribute'=>'days','operator'=>'<=', 
              'allowEmpty'=>false , 'message'=>'Your day-off is out of range. ','on'=>'create,update'),*/
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'daysoffquota' => array(self::HAS_MANY, 'DaysOffQuota', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'vacation_id' => 'Vacation',
			'start_day' => 'From',
			'end_day' => 'To',
			'total' => 'Day(s)',
			'reason' => 'Type',
			'more_reason' => 'Reason',
			'user_id' => 'User',
			'request_day' => 'Request On',
			'status'=> 'Status',
			'time'=> 'Time',
			'comment_one'=>'Comment',
			'comment_two'=>'Comment',
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
		// fix date search
		$id=Yii::app()->user->id;
		/*$request_start= CDateTimeParser::parse($this->request_day,'MM-dd-yyyy', array('hour'=>0,'minute'=>0, 'second'=>0));
		$request_end= CDateTimeParser::parse($this->request_day,'MM-dd-yyyy', array('hour'=>23,'minute'=>59, 'second'=>59));
		$start_start= CDateTimeParser::parse($this->start_day,'MM-dd-yyyy', array('hour'=>0,'minute'=>0, 'second'=>0));
		$start_end= CDateTimeParser::parse($this->start_day,'MM-dd-yyyy', array('hour'=>23,'minute'=>59, 'second'=>59));
		$end_start= CDateTimeParser::parse($this->end_day,'MM-dd-yyyy', array('hour'=>0,'minute'=>0, 'second'=>0));
		$end_end= CDateTimeParser::parse($this->end_day,'MM-dd-yyyy', array('hour'=>23,'minute'=>59, 'second'=>59));		
		$criteria->compare('t.start_day',CDateTimeParser::parse($this->start_day, 'MM-dd-yyyy'));
		$criteria->compare('t.end_day',CDateTimeParser::parse($this->end_day, 'MM-dd-yyyy'));		
		$criteria->compare('t.request_day',CDateTimeParser::parse($this->request_day,'MM-dd-yyyy'));*/
		
		// begin code search vacation for user
		if(!Yii::app()->user->checkAccess("admin")&&!Yii::app()->user->checkAccess("manager"))
		{
			$criteria=new CDbCriteria(array(
			'condition'=>"t.user_id = $id AND t.status!=4",
			));
			
			
			if($_GET['Vacation']['request_day']!=null)
				{
					$criteria->addBetweenCondition('t.request_day', $request_start, $request_end, 'AND');
				}
			$criteria->compare('t.reason',$this->reason);
			if($_GET['Vacation']['start_day']!=null)
				{
					$criteria->addBetweenCondition('t.start_day', $start_start, $start_end, 'AND');
				}
			if($_GET['Vacation']['end_day']!=null)
				{
					$criteria->addBetweenCondition('t.end_day', $end_start, $end_end, 'AND');
				}
			$criteria->compare('t.status',$this->status);
		}
		// End code search vacation for user
		
		// begin code search vacation for Admin/Manager
		else
		{
			$criteria=new CDbCriteria(array(
			'with'=>array('user'),
			'condition'=>"t.status!=4",
			));						
			
			// begin code search for Request Day
			if($this->re_month)
			{				
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.request_day), "%m") = :month_re');
				$criteria->params = array(':month_re'=>$this->re_month);							
			}
			if($this->re_day)
			{				
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.request_day), "%d") = :day_re');
				$criteria->params[':day_re'] = $this->re_day;
			}	
			if($this->re_year)
			{
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.request_day), "%Y") = :year_re');
				$criteria->params[':year_re'] = $this->re_year;
				//CVarDumper::dump($this->re_year);
			}
			// End code search for Request Day
			
			// begin code search for Start Day
			if($this->st_day)
			{
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.start_day), "%d") = :day_st');
				$criteria->params[':day_st'] = $this->st_day;
			}
			if($this->st_month)
			{
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.start_day), "%m") = :month_st');
				$criteria->params[':month_st'] = $this->st_month;
			}
			if($this->st_year)
			{
				$criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(t.start_day), "%Y") = :year_st');
				$criteria->params[':year_st'] = $this->st_year;
			}
			// End code search for Start Day
			$criteria->compare('user.user_full_name',$this->user_id,true);
			$criteria->compare('t.reason',$this->reason);
			$criteria->compare('t.status',$this->status);
			
			//CVarDumper::dump(DATE_FORMAT(t.request_day, "%d"));
			//print_r($this->user_id);exit;
			/*if($this->user_id)
				{
					$criteria->compare('t.user_id',$this->user_id);	
					$criteria->condition = 't.user_id=:id';
					$criteria->params = array(':id'=>$this->user_id);
				}
			
			if($_GET['Vacation']['request_day']!=null)
				{
					$criteria->addBetweenCondition('t.request_day', $request_start, $request_end, 'AND');
				}
			$criteria->compare('t.total',$this->total);
			$criteria->compare('t.reason',$this->reason);
			if($_GET['Vacation']['start_day']!=null)
				{
					$criteria->addBetweenCondition('t.start_day', $start_start, $start_end, 'AND');
				}
			if($_GET['Vacation']['end_day']!=null)
				{
					$criteria->addBetweenCondition('t.end_day', $end_start, $end_end, 'AND');
				}
			*/
		}
		// begin code search vacation for user
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'vacation_id desc',
		),
			
		));
	}
/* ------------ Begin Here ------------*/	
	
	/*
	 * 
	 */
	public function beforeValidate()
	{		
		//print_r($this->getScenario()); exit;
		if($this->isNewRecord)
		{							
			$sum = $this->total;
			$startday = CDateTimeParser::parse($this->start_day, 'MM-dd-yyyy');
			$morning = 27000;
			$afternoon = 45000;
						
			if($sum<1){ 
				if($this->time=="am")
				{
					$startday= $startday+$morning;
					$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
					$endday = $endday+18000;
				}
				elseif($this->time=="pm")
				{
					$startday= $startday+$afternoon;
					$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
					$endday = $endday+12600;
				}
			}
			else
			{ 
			
				if($this->time=="am")
				{
					$startday= $startday+$morning;
					if(($sum/0.5)%2==0)
					{
						$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
						$endday = $endday-55800;
					}
					elseif(($sum/0.5)%2==1)
					{
						$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
						$endday = $endday+18000;
					}
					if(date("l",$endday)=="Saturday") $endday = $endday+(2*86400);
					elseif(date("l",$endday)=="Sunday")$endday = $endday+86400;
					if(date("m-d",$endday)=="01-01" || date("m-d",$endday)=="09-02")$endday = $endday+86400;
					if(date("m-d",$endday)=="04-30")$endday = $endday+86400;
					if(date("m-d",$endday)=="05-01")$endday = $endday+86400;
				}
				elseif($this->time=="pm")
				{
					$startday= $startday+$afternoon;
					if(($sum/0.5)%2==0)
					{
						$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
						$endday = $endday;
					}
					elseif(($sum/0.5)%2==1)
					{
						$endday = $this->addDays_one($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
						$endday = $endday+12600;
					}
					if(date("l",$endday)=="Saturday") $endday = $endday+(2*86400);
					elseif(date("l",$endday)=="Sunday")$endday = $endday+86400;
					if(date("m-d",$endday)=="01-01" || date("m-d",$endday)=="09-02")$endday = $endday+86400;
					if(date("m-d",$endday)=="04-30")$endday = $endday+86400;
					if(date("m-d",$endday)=="05-01")$endday = $endday+86400;
					
				}
			}
			$requestday = CDateTimeParser::parse(date('m-d-Y H:i:s'), 'MM-dd-yyyy HH:mm:ss');	
			//$this->days = (($endday-$startday)/86400)+1;
			// set the create date, last updated date and the user doing the creating
			$this->start_day=$startday;
			$this->end_day=$endday;
			$this->request_day=$requestday;	
		}
		elseif($this->getScenario()=='edit') 
		{
						$sum = $this->total; 
			$startday = CDateTimeParser::parse($this->start_day, 'MM-dd-yyyy');
			$morning = 27000;
			$afternoon = 45000;
						
			if($sum<1){ 
				if($this->time=="am")
				{
					$startday= $startday+$morning;
					$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
					$endday = $endday+18000;
				}
				elseif($this->time=="pm")
				{
					$startday= $startday+$afternoon;
					$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
					$endday = $endday+12600;
				}
			}
			else
			{ 
			
				if($this->time=="am")
				{
					$startday= $startday+$morning;
					if(($sum/0.5)%2==0)
					{
						$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
						$endday = $endday-55800;
					}
					elseif(($sum/0.5)%2==1)
					{
						$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
						$endday = $endday+18000;
					}
					if(date("l",$endday)=="Saturday") $endday = $endday+(2*86400);
					elseif(date("l",$endday)=="Sunday")$endday = $endday+86400;
					if(date("m-d",$endday)=="01-01" || date("m-d",$endday)=="09-02")$endday = $endday+86400;
					if(date("m-d",$endday)=="04-30")$endday = $endday+86400;
					if(date("m-d",$endday)=="05-01")$endday = $endday+86400;
				}
				elseif($this->time=="pm")
				{
					$startday= $startday+$afternoon;
					if(($sum/0.5)%2==0)
					{
						$endday = $this->addDays_two($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
						$endday = $endday;
					}
					elseif(($sum/0.5)%2==1)
					{
						$endday = $this->addDays_one($startday,$sum,array("Saturday","Sunday"),array("01-01","04-30","05-01","09-02"));
						$endday = $endday+12600;
					}
					if(date("l",$endday)=="Saturday") $endday = $endday+(2*86400);
					elseif(date("l",$endday)=="Sunday")$endday = $endday+86400;
					if(date("m-d",$endday)=="01-01" || date("m-d",$endday)=="09-02")$endday = $endday+86400;
					if(date("m-d",$endday)=="04-30")$endday = $endday+86400;
					if(date("m-d",$endday)=="05-01")$endday = $endday+86400;
					
				}
			}
			$requestday = CDateTimeParser::parse(date('m-d-Y H:i:s'), 'MM-dd-yyyy HH:mm:ss');	
			//$this->days = (($endday-$startday)/86400)+1;
			// set the create date, last updated date and the user doing the creating
			$this->start_day=$startday;
			$this->end_day=$endday;
			$this->request_day=$requestday;
			//$this->days = (($this->end_day-$this->start_day)/86400)+1;
			//print_r($this->days); exit;
		}
		
		
		//print_r($requestday);print_r("-----");print_r($startday);print_r("--------");print_r($endday);exit;
		//var_dump(date("Y-m-d H:i(worry) a", $endday));die;
		return parent::beforeValidate();
	}
	
	/*
	 * Get start day follow fomat M-d-y
	 */
	
	public function getStartDay()
	{
		return date('M-d-Y',$this->start_day);
	}

	
	/*
	 * converts from date/time to timestamp 
	 */
	public function setStartDay($start)
	{
		$this->start_day=CDateTimeParser::parse($start,'MM-dd-yyyy');
	}
	
	/**
	 * Get End day follow fomat M-d-y
	 * @return unknown_type
	 */
	public function getEndDay()
	{
		return date('M-d-Y',$this->end_day);
	}
	
	/*
	 * converts from date/time to timestamp 
	 */
	public function setEndDay($end)
	{
		$this->end_day=CDateTimeParser::parse($end,'MM-dd-yyyy');
	}
	
	/**
	 * Get request day follow fomat M-d-y
	 * @return unknown_type
	 */
	public function getrequestDay()
	{
		return date('M-d-Y',$this->request_day);
	}
	
	/*
	 * converts from date/time to timestamp 
	 */
	public function setrequestDay($request)
	{
		$this->request_day=CDateTimeParser::parse($request,'MM-dd-yyyy');
	}
	
	/*
	 * 
	 */
	public function getMoreReason()
	{
		$more_reason = $this->more_reason;
		return $more_reason;
	}
	/**
	 * Get reason array
	 * @return array
	 */
	public static function getReasonArr()
	{
		return array(
			//''=>'All Type',
			self::REASON_VACATION => 'Vacation',
			self::REASON_ILLNESS => 'Illness',
			self::REASON_WEDDING => 'Wedding',
			self::REASON_BEREAVEMENT => 'Bereavement',
			self::REASON_MATERNITY => 'Maternity',
		);
	}
	/**
	 * Get reason array for Search
	 * @return array
	 */
	public function getReasonSearchArr()
	{
		return array(
			''=>'All Type',
			self::REASON_VACATION => 'Vacation',
			self::REASON_ILLNESS => 'Illness',
			self::REASON_WEDDING => 'Wedding',
			self::REASON_BEREAVEMENT => 'Bereavement',
			self::REASON_MATERNITY => 'Maternity',
		);
	}

	/**
	 * Convert Reason from Array to string
	 * @return Name Reason
	 */
	public function getReasonName()
	{
		$arr=$this->getReasonArr();
		return $arr[$this->reason];	
	}
	
	/*
	 * 
	 */
	public function getReasonNumber($str) {
		$arr = $this->getReasonArr();
		return array_search($str, $arr);
	}
	
	/*
	 * Get status array
	 * @return array
	 */
	public function getStatusArr() {
		return array(
			''=>'All Status',
			self::STATUS_WAITING 		=> 'Waiting',
			self::STATUS_REQUEST_CANCEL => 'Requested Cancel',
			self::STATUS_ACCEPT 		=> 'Accepted',
			self::STATUS_DECLINE 		=> 'Declined',
		);
	}
	/*
	 * Convert Status from Array to string
	 */
	public function getStatusName()
	{
		$arr=$this->getStatusArr();
		return $arr[$this->status];	
	}

	/*
	 * 
	 */
	public function getStatusNumber($str) {
		$arr = $this->getStatusArr();
		return array_search($str, $arr);
	}
	
	public function setStatus($status) {
		$this->status = $status;
	}

	/*
	 * 
	 */
	public static  function gettotalsarr($total='')
	{
		switch($total){
			case self::REASON_VACATION:
			case self::REASON_ILLNESS:
			case self::REASON_WEDDING:
			case self::REASON_BEREAVEMENT:
				return array(
				//''=>'---',
				'0.5'=>'0.5',
				'1.0'=>'1',
				'1.5'=>'1.5',
				'2.0'=>'2',
				'2.5'=>'2.5',
				'3.0'=>'3',
				'3.5'=>'3.5',
				'4.0'=>'4',
				'4.5'=>'4.5',
				'5.0'=>'5',
				'5.5'=>'5.5',
				'6.0'=>'6',
				'6.5'=>'6.5',
				'7.0'=>'7',
				'7.5'=>'7.5',
				'8.0'=>'8',
				'8.5'=>'8.5',
				'9.0'=>'9',
				'9.5'=>'9.5',
				'10.0'=>'10',
				'10.5'=>'10.5',
				'11.0'=>'11',
				'11.5'=>'11.5',
				'12.0'=>'12',
				'12.5'=>'12.5',
				'13.0'=>'13',
				'13.5'=>'13.5',
				'14.0'=>'14',
				'14.5'=>'14.5',
				'15.0'=>'15',
				'15.5'=>'15.5',
				'16.0'=>'16',
				'16.5'=>'16.5',
				'17.0'=>'17',
				'17.5'=>'17.5',
				'18.0'=>'18',
				'18.5'=>'18.5',
				'19.0'=>'19',
				'19.5'=>'19.5',
				'20.0'=>'20',
				'20.5'=>'20.5',
				'21.0'=>'21',
				'21.5'=>'21.5',	
				'22.0'=>'1 month',
				'44.0'=>'2 months',
				'66.0'=>'3 months',
				'88.0'=>'4 months',
				'110.0'=>'5 months',
				'132.0'=>'6 months',
				);
				break;	
			case self::REASON_MATERNITY:
				return array(
				//''=>'---',	
				'110.0'=>'5 months',
				'22.0'=>'1 month',
				'44.0'=>'2 months',
				'66.0'=>'3 months',
				'88.0'=>'4 months',
				'132.0'=>'6 months',
				/*
				'5.00'=>'1 week',
				'10.00'=>'2 weeks',
				'15.00'=>'3 weeks',
				'20.00'=>'4 weeks',
				'25.00'=>'5 weeks',
				'30.00'=>'6 weeks',
				'35.00'=>'7 weeks',
				'40.00'=>'8 weeks',
				'45.00'=>'9 weeks',
				'50.00'=>'10 weeks',
				'55.00'=>'11 weeks',
				'60.00'=>'12 weeks',
				'65.00'=>'13 weeks',
				'70.00'=>'14 weeks',
				'75.00'=>'15 weeks',
				'80.00'=>'16 weeks',
				'85.00'=>'17 weeks',
				'90.00'=>'18 weeks',
				'95.00'=>'19 weeks',
				'100.00'=>'20 weeks',
				'105.00'=>'21 weeks',
				'110.00'=>'22 weeks',	// duplicate voi 5 months
				'115.00'=>'23 weeks',
				'120.00'=>'24 weeks',
				'125.00'=>'25 weeks',
				'130.00'=>'26 weeks',
				'135.00'=>'27 weeks',
				'140.00'=>'28 weeks',
				*/
				);
				break;
			default :
			//return array();
			return array(
				'0.5'=>'0.5',
				'1.0'=>'1',
				'1.5'=>'1.5',
				'2.0'=>'2',
				'2.5'=>'2.5',
				'3.0'=>'3',
				'3.5'=>'3.5',
				'4.0'=>'4',
				'4.5'=>'4.5',
				'5.0'=>'5',
				'5.5'=>'5.5',
				'6.0'=>'6',
				'6.5'=>'6.5',
				'7.0'=>'7',
				'7.5'=>'7.5',
				'8.0'=>'8',
				'8.5'=>'8.5',
				'9.0'=>'9',
				'9.5'=>'9.5',
				'10.0'=>'10',
				'10.5'=>'10.5',
				'11.0'=>'11',
				'11.5'=>'11.5',
				'12.0'=>'12',
			);
			break;
		};
		
	}
	
	/*
	 * 
	 */
	public function getyearsearch()
	{
		$now = getdate();
		$range = 10;	//	+/- 5 years
		
    	$currentYear = $now["year"];
     //	print_r($currentYear);exit;
		$year = $currentYear - $range/2;
		$list[]= "Year";
		$list[$year] = $year;
		for($i=2;$i<=$range;$i++)
		{
			$year++;
			$list[$year] = $year;
		}
		return $list;
	}
	
	/*
	 * Get day for Search Day on Vaction
	 */
	public function get_monthsearch() {
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
	public function get_daysearch() {
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
	
	/*
	 * Get sum days in a Vacation
	 */
	public function getdaysnumber()
	{ 
		$daynumber = $this->total;
			return $daynumber;
	}

	/*
	 * Get List User
	 */
	public function getListUserfullname() {
			$users= User::model()->findAll();			
			$list[]= "--- select all ---";	
			foreach($users as $row)
			{					
				$list[$row['user_id']]= $row['user_full_name'];	
			}
			return $list;
		}
	/*
	 * Get List User for Search
	 */
		public function getListUserSearch() {
			$users= User::model()->findAll();	 
			foreach($users as $row)
			{					
				echo "\"".$row['user_full_name']."\", ";
			}
			
			return $row;
		}
		 	
	/*
	 *  Get option time in Vacation (AM or PM)
	 */
	public function getTimeVacationOption() {
        return array(
           self::AM => 'am',
           self::PM => 'pm',
        );
    }
    
	/*
	 *  Get Name of option time in Vacation (AM or PM)
	 */
    public function getTimeVacationName($number) {
        $timevacationName = $this->getTimeVacationOption();
        return isset($timevacationName[$number]) ?  $timevacationName[$number] : "unknown Time ({$number})";
    }
    
	/*
	 * Save option time in DataBase
	 */
    public function setTimeVacation($time_vacation){
        return $this->time = $this->getTimeVacationName($time_vacation);
    }
    
	/*
	 * calculate Vacation
	 */
	public function addDays_one($timestamp, $days, $skipdays=array(), $skipdates=array()){ 
	    // $skipdays: array (Monday-Sunday) eg. array("Saturday","Sunday") 
	    // $skipdates: array (YYYY-mm-dd) eg. array("2012-05-02","2015-08-01"); 
	    date_default_timezone_set('Asia/Saigon');
		$i = 1; 
	     
	    while($days >= $i){ 
	    	$timestamp = strtotime("+1 day" ,$timestamp);
	        if(in_array(date("l",$timestamp), $skipdays) || in_array(date("m-d",$timestamp), $skipdates)){ 
	            $days++; 
	        }
	        if(in_array(date("l",$timestamp), $skipdays) && in_array(date("m-d",$timestamp), $skipdates)){ 
	            $days++; 
	        }
	        $i++; 
	    } 
	    
	    return $timestamp; 
	}

	/*
	 * calculate Vacation
	 */
	public function addDays_two($timestamp, $days, $skipdays=array(), $skipdates=array()){ 
	    // $skipdays: array (Monday-Sunday) eg. array("Saturday","Sunday") 
	    // $skipdates: array (YYYY-mm-dd) eg. array("2012-05-02","2015-08-01"); 
	    date_default_timezone_set('Asia/Saigon');
		$i = 1;  
	    while($days >= $i){ 
	        if(in_array(date("l",$timestamp), $skipdays) || in_array(date("m-d",$timestamp), $skipdates)){ 
	            $days++; 
	        }
	        if(in_array(date("l",$timestamp), $skipdays) && in_array(date("m-d",$timestamp), $skipdates)){ 
	            $days++; 
	        }
	        $timestamp = strtotime("+1 day" ,$timestamp);
	        $i++; 
	    } 
	    
	    return $timestamp; 
	}
	/*
	 * show "day" OR "days" based on  remaing day
	 */
	public function showday($day)
	{
		if($day>1) return " days";
		else return " day";
	}
	
	public function getUserName($id)
	{
		$users= User::model()->findByPk($id);
		//if($this->mod_status==2) //as private
		{
	   		return $users->user_full_name;
		}
	}
	
	
}

