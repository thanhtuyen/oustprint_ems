<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $user_id
 * @property string $user_username
 * @property string $user_first_name
 * @property string $user_last_name
 * @property string $user_full_name
 * @property integer $user_company
 * @property string $user_email
 * @property string $user_password
 * @property string $user_lastvisit
 * @property string $user_active
 * @property string $user_token
 * @property int $user_created_day
 *
 * The followings are the available model relations:
 * @property Job[] $jobs
 */
class User extends CActiveRecord {
    const ADMIN = 'admin';
    const MANAGER = 'manager';
    const INPUT_USER = 'input_user';
    const USER = 'user';

    const ACTIVE = '1';
    const DEACTIVE = '0';

    public $user_password_repeat;
    public $user_old_password;
    public $user_role;
    public $pageSize;

    //public $jobs=array();
    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_username, user_email', 'unique', 'message' => '{attribute}:{value} already exists, please choose a different one.', 'on' => 'add'),
            array('user_username, user_email, user_password_repeat', 'required', 'on' => 'add'),
            array('user_email', 'required', 'on' => 'add, update'),
            array('user_first_name, user_last_name, user_full_name, user_password', 'required', 'on' => 'add, update'),
            array('user_company', 'numerical', 'integerOnly' => true),
            array('user_username', 'length', 'max' => 32),
            array('user_first_name', 'length', 'max' => 20),
            array('user_last_name', 'length', 'max' => 30),
            array('user_full_name', 'length', 'max' => 255),
            array('user_email', 'length', 'max' => 255),
            array('user_email', 'email'),
            array('user_password', 'match', 'pattern' => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,16}$/', 'message' => 'Passwords are 6-16 characters with uppercase letters, lowercase letters and at least one number.', 'on' => 'add, changePassword'),
            array('user_username,user_first_name,user_last_name', 'match', 'pattern' => '/^[a-zA-Z0-9 - . \' ,]/', 'message' => 'Please don\'t put invalid value', 'on' => 'add, update'),
            array('user_password_repeat', 'compare', 'compareAttribute' => 'user_password', 'on' => 'add'),
            //array('user_active', 'length', 'max'=>1),
            array('user_lastvisit', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, user_username, user_first_name, user_last_name, user_full_name, user_email, user_lastvisit, user_active', 'safe', 'on' => 'search'),
                //array('user_password, user_old_password', 'safe', 'on'=>'changePassword'),
        );
    }

    /**
     * perform one-way encryption on the password before we store it in the database
     */
    protected function afterValidate() {
        parent::afterValidate();
        if (in_array($this->getScenario(), array('add', 'changePassword', 'resetPassword'))) {
            $this->user_password = $this->encrypt($this->user_password);
        }
    }

    public function onAfterSave($event) {
        $log = new Logs;
        $log->merchant_id = 1;
        $log->name = Yii::app()->user->getState('fullName');
        $log->date = date();
        $log->save(FALSE);
    }

    public function encrypt($value) {
        return md5($value);
    }

    public function setUserFirstName($firstname) {
        $this->user_first_name = $firstname;
    }

    public function setUserLastName($lastname) {
        $this->user_last_name = $lastname;
    }

    public function setUserFullName($fullname) {
        $this->user_full_name = $fullname;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //'jobs' => array(self::MANY_MANY, 'Job', 'job_acl(job_id, vv_user_id)'),
            //'company' => array(self::BELONGS_TO, 'Company', 'user_company'),
            'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
            'role' => array(self::HAS_MANY, 'Authassignment', 'userid', 'together' => true),
            'vacations' => array(self::HAS_MANY, 'Vacation', 'user_id'),
            'days_off_quota' => array(self::HAS_ONE, 'DaysOffQuota', 'user_sid'),
            'logs' => array(self::HAS_MANY, 'ActivityLog', 'user_id')
        );
    }

    public function hasRole($name) {
        foreach ($this->role as $r) {
            if ($r->itemname === $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => 'User',
            'user_username' => 'Username',
            'user_first_name' => 'First Name',
            'user_last_name' => 'Last Name',
            'user_full_name' => 'Full Name',
            'user_email' => 'Email',
            'user_password' => 'Password',
            'user_lastvisit' => 'Last visit',
            'user_active' => 'Status',
            'user_password_repeat' => 'Confirm Password',
            'user_old_password' => 'Old Password',
            'user_role' => 'Role',
            'user_created_date' => 'Created date'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();
        $criteria->with = array('profile', 'role'); 
		

        if ($_GET['User']['user_role'] != '') {
            $criteria->addCondition("role.itemname ='" . $_GET['User']['user_role'] . "'");
        }
        if ($this->user_full_name) {
            $criteria->compare('t.user_full_name', $this->user_full_name,true);
        }
        $criteria->compare('t.user_email', $this->user_email, true);
        $criteria->addCondition("user_active = 1");
		/*
		if ($_GET['status_list'] == 'deactive') {
            $criteria->addCondition("user_active = 0");
        } else if ($_GET['status_list'] == 'nw') {
            $criteria->addCondition("profile.user_status = 1");
        } else {
            $criteria->addCondition("user_active = 1");
        }
		*/
        //return new CActiveDataProvider(get_class($this), array(
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'attributes' => array('profile.user_job_function', 'user_username'),
                        'defaultOrder' => array('profile.user_job_function' => FALSE),
                    ),
                    'pagination' => array(
                        'pageSize' => $this->pageSize,
                    ),
                ));
    }
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search1() {
        $criteria = new CDbCriteria();
        $criteria->with = array('profile', 'role'); 
		

        if ($_GET['User']['user_role'] != '') {
            $criteria->addCondition("role.itemname ='" . $_GET['User']['user_role'] . "'");
        }
        if ($this->user_full_name) {
            $criteria->compare('t.user_full_name', $this->user_full_name,true);
        }
        $criteria->compare('t.user_email', $this->user_email, true);
		$criteria->addCondition("user_active = 0");
		/*
		if ($_GET['status_list'] == 'deactive') {
            $criteria->addCondition("user_active = 0");
        } else if ($_GET['status_list'] == 'nw') {
            $criteria->addCondition("profile.user_status = 1");
        } else {
            $criteria->addCondition("user_active = 1");
        }
		*/
        //return new CActiveDataProvider(get_class($this), array(
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'attributes' => array('profile.user_job_function', 'user_username'),
                        'defaultOrder' => array('profile.user_job_function' => FALSE),
                    ),
                    'pagination' => array(
                        'pageSize' => $this->pageSize,
                    ),
                ));
    }
	
	public function search2() {
        $criteria = new CDbCriteria();
        $criteria->with = array('profile', 'role');  

        if ($_GET['User']['user_role'] != '') {
            $criteria->addCondition("role.itemname ='" . $_GET['User']['user_role'] . "'");
        }
        if ($this->user_full_name) {
            $criteria->compare('t.user_full_name', $this->user_full_name,true);
        }
        $criteria->compare('t.user_email', $this->user_email, true);
		 $criteria->addCondition("profile.user_status = 1");
		/*
		if ($_GET['status_list'] == 'deactive') {
            $criteria->addCondition("user_active = 0");
        } else if ($_GET['status_list'] == 'nw') {
            $criteria->addCondition("profile.user_status = 1");
        } else {
            $criteria->addCondition("user_active = 1");
        }
		*/
        //return new CActiveDataProvider(get_class($this), array(
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'attributes' => array('profile.user_job_function', 'user_username'),
                        'defaultOrder' => array('profile.user_job_function' => FALSE),
                    ),
                    'pagination' => array(
                        'pageSize' => $this->pageSize,
                    ),
                ));
    }
    /**
     * get role options
     */
    public function getRoleOptions() {
        return array(
            self::USER => 'User',
            self::MANAGER => 'Manager',
            self::INPUT_USER => 'Input User',
            self::ADMIN => 'Administrator',
        );
    }
	public function getAdminRoleOptions() {
        return array( 
            self::ADMIN => 'Administrator',
        );
    }
	public function getManagerRoleOptions() {
        return array( 
            self::ADMIN => 'Manager',
        );
    }
    /*
     * get role name by role value
     */

    public function getRoleText($roleValue) {
        $roleOptions = $this->getRoleOptions();
        return isset($roleOptions[$roleValue]) ? $roleOptions[$roleValue] : "unknown role ({$roleValue})";
    }

    /*
     * get role of user
     */

    public function getRoleName() {
        foreach ($this->role as $r) {
            return $this->getRoleText($r->itemname);
        }
        return "";
    }

    /*
     * get role of user
     */

    public function getRoleValue() {
        foreach ($this->role as $r) {
            return $r->itemname;
        }
        return "";
    }

    public function getJobFunction() {
        //print_r($this->profile->getUserJobFunction());exit;
        if ($this->profile)
            return $this->profile->getUserJobFunction();
        return "N/A";
        //return $this->profile->user_job_function;
    }

    /*
     * get all of users with role
     */

    public function getUsersWithRole($role) {
        $users = Yii::app()->db->createCommand()
                ->select('user_id, user_first_name, user_last_name, user_full_name, user_email')
                ->from('user u')
                ->join('AuthAssignment au', 'u.user_id = au.userid')
                //->where(array('in', 'au.itemname', array($role)))
                ->where('u.user_active = 1 and au.itemname IN (:roles)', array(':roles' => $role))
                ->order('user_first_name ASC')
                ->limit(50)
                ->queryAll();
        return $users;
    }

    /*
     * get role of User
     */

    public function getRoleOfUser() {
        $role = Authassignment::model()->find(array(
            'select' => '*',
            'condition' => 'userid =:userId',
            'params' => array(':userId' => $this->user_id),
                ));
        return $role->itemname;
    }

    public function getUserRole($id) {
        $role = Authassignment::model()->find(array(
            'select' => '*',
            'condition' => 'userid =:userId',
            'params' => array(':userId' => $id),
                ));
        return $role->itemname;
    }

    /*
     * get user by id
     */

    public function getUserById($id) {
        $user = User::model()->find(array(
            'select' => 'user_id, user_first_name, user_last_name, user_full_name',
            'condition' => 'user_id=:userId',
            'params' => array(':userId' => $id),
                ));
        return $user;
    }

    /*
     * get user by token
     */

    public function findUserByToken() {
        $token = $this->user_token;
        $user = User::model()->find(array(
            'select' => '*',
            'condition' => 'user_token=:token',
            'params' => array(':token' => $token),
                ));
        return $user;
    }

    public function getUsers() {
        $users = $this->getUsersWithRole('user');
        $us = array();
        foreach ($users as $user) {
            $us[$user['user_id']] = $user['user_first_name'] . " " . $user['user_last_name'];
        }
        return $us;
    }

    /*
     * Get list email of user have role
     */

    public function getEmailListRole($role) {
        $sql = "SELECT user_email 
				FROM user 
				INNER JOIN AuthAssignment ON userid = user_id 
				WHERE itemname = '$role'";
        $command = Yii::app()->db->createCommand($sql);
        $result = $command->queryAll();
        $emailList = array();
        if ($result) {
            foreach ($result as $user) {
                $emailList[] = $user['user_email'];
            }
        }
        return $emailList;
    }

    /**/

    /**
     * Get status array
     * @return array
     */
    public function getStatusArr() {
        return array(
            self::ACTIVE => 'Active',
            self::DEACTIVE => 'Deactive',
        );
    }

    /**
     * Convert Status from Array to string
     * @return Name Status
     */
    public function getStatusName() {
        $arr = $this->getStatusArr();
        return $arr[$this->user_active];
    }

    /*
     * 
     */

    public function getStatusNumber($str) {
        $arr = $this->getStatusArr();
        return array_search($str, $arr);
    }

    public function setStatus($status) {
        $this->user_active = $status;
    }

    /**/

    public function getUserFirstName() {
        return $this->user_first_name;
    }

    public function getUserLastName() {
        return $this->user_last_name;
    }

    public function getFullName() {
        return "$this->user_first_name $this->user_last_name";
    }

    public function getUserFullName() {
        return $this->user_full_name;
    }

	public function getUserName() {
        return $this->user_username;
    }
    public function getCreatedDate() {
        return date('M-d-Y h:i:s A', $this->user_created_date);
    }

    /*
     * converts from date/time to timestamp 
     */

    public function setCreatedDate($date) {
        $this->user_created_date = CDateTimeParser::parse($date, 'MM-dd-yyyy');
    }

    public function getListFullUsers() {
        $users = User::model()->findAll();
        $list[] = "--- select all ---";
        foreach ($users as $row) {
            $list[$row['user_id']] = $row['user_full_name'];
        }

        return $list;
    }
    
    /**
     * Get vacation days based on user_official_start_date 
     */
    public function getVacationDays() {
    	/*
        $startDate = $this->profile->user_official_start_date;
        $month = date('n', $startDate);
        return (13 - $month);
        */
    	$num = 12;
    	$signDate = date('Y',$this->profile->user_official_start_date);
    	$startlength = date('n',$this->profile->user_official_start_date);
    	$endDate = date('Y',$this->profile->user_end_contract_date);
    	$endlength = date('n',$this->profile->user_end_contract_date);
    	$now = date("Y");
    	if($endDate == $now)
    	{
    		if($signDate == $now)
    			return $this->profile->user_official_contract_length;
    		else
    			return $endlength;
    	}
    	if($endDate > $now)
    	{
    		if($signDate == $now)
    			return (13 - $startlength);
    		else
    			return $num;
    	}
    	
    }
    
    /**
     * Get sick days based on user_official_start_date
     */
    public function getSickDays() {
        $vacation = $this->getVacationDays();
        if($vacation)
        	return (0.25 * $vacation);
        else
        	return null;
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
}
