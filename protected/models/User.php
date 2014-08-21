<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $firstname
 * @property string $lastname
 * @property string $fullname
 * @property string $email
 * @property integer $dob
 * @property string $password
 * @property string $activkey
 * @property string $status
 * @property integer $lastvisit
 * @property integer $created_date
 * @property string $type
 * @property integer $updated_date
 * @property integer $roles
 *
 * The followings are the available model relations:
 * @property ActivityLog[] $activityLogs
 * @property ActivityLog[] $activityLogs1
 * @property Employee $employee
 */
class User extends CActiveRecord
{

    const ADMIN = 1;
    const MANAGER = 2;
    const LEADER = 3;
    const USER = 4;
    const STATUS_ACTIVE = 1;

    public $password_repeat;
    public $old_password;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname, fullname, email, dob, roles', 'required', 'on' => 'create, update, resetPassword'),
			array('dob, lastvisit, created_date, updated_date, roles', 'numerical', 'integerOnly'=>true),
      //array('dob', 'type','type' =>'date','message' => '{attribute}: is not a date!', 'dateFormat' => 'M-dd-yy'),
			array('firstname, lastname, fullname, email', 'length', 'max'=>255),
      array('email', 'unique', 'message' => '{attribute}:{value} already exists.', 'on' => 'create'),
      array('email', 'email'),
			array('password, activkey', 'length', 'max'=>500),
			array('status', 'length', 'max'=>1),
			array('type', 'length', 'max'=>11),
      array('password', 'match', 'pattern' => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,16}$/',
        'message' => 'Passwords are 6-16 characters with uppercase letters, lowercase letters and at least one number.', 'on' => 'changePassword, resetPassword'),

      array('password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'resetPassword'),
             // array('dob','compare','compareAttribute'=>'working_age','operator'=>'<=', 
             //  'allowEmpty'=>false , 'message'=>'you are not in working age allowed','on'=>'create,update'),
			// The following rule is used by search().
      // Please remove those attributes that should not be searched.
			array('id, firstname, lastname, fullname, email, dob, password, activkey, status, lastvisit, created_date, type, updated_date, roles', 'safe', 'on'=>'search'),
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
			'activityLogs' => array(self::HAS_MANY, 'ActivityLog', 'user_id'),
			'activityLogs1' => array(self::HAS_MANY, 'ActivityLog', 'action_id'),
			'employee' => array(self::HAS_ONE, 'Employee', 'id'),
			'vacations' => array(self::HAS_MANY, 'Vacation', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'fullname' => 'Fullname',
			'email' => 'Email',
			'dob' => 'Dob',
			'password' => 'Password',
			'activkey' => 'Activkey',
			'status' => 'Status',
			'lastvisit' => 'Lastvisit',
			'created_date' => 'Created Date',
			'type' => 'Type',
			'updated_date' => 'Updated Date',
			'roles' => 'Roles',
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
    $role = $this->getRole();
		$criteria = new CDbCriteria;
    $criteria->compare('fullname',$this->fullname,true);
    $criteria->compare('email',$this->email,true);
    $criteria->compare('roles',$this->roles, true);
    $criteria->addCondition("status = 1");
    $criteria->addCondition("roles > ".$role);

		$user = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    $user_export =  new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
      'pagination' => false
    ));

    $_SESSION['user_active'] = $user_export;
    return $user;
	}

    public function search1()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $role = $this->getRole();
        $criteria=new CDbCriteria;
        $criteria->compare('fullname',$this->fullname,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('roles',$this->roles, true);
        $criteria->addCondition("status = 0");
        $criteria->addCondition("roles > ".$role);
        $user = new CActiveDataProvider($this, array(
          'criteria'=>$criteria,
        ));
        $user_export =  new CActiveDataProvider($this, array(
          'criteria'=>$criteria,
          'pagination' => false
        ));

        $_SESSION['user_deactive'] = $user_export;
        return $user;
    }
    // public function beforeValidate()
    // {
    //     $c_year = date("Y")-18;                              
    //     $c_age = date("m")."-".date("d")."-".$c_year;                                
    //     //$this->birth_year = date("Y",$this->user_dob);         
    //     $this->working_age = CDateTimeParser::parse($c_age,'MM-dd-yyyy');
    //     //print_r($this->working_age); exit;
    //     return parent::beforeValidate();
    // }
    
    /**
     * perform one-way encryption on the password before we store it in the database
     */
    protected function afterValidate() {
        parent::afterValidate();
        if (in_array($this->getScenario(), array('create', 'changePassword', 'resetPassword'))) {
         $this->password = $this->encrypt($this->password);
        }

    }
	
    /**
     * encrypt password
     *
     * @param $value
     * @return string
     */
    public function encrypt($value) {
        return md5($value);
    }

    /*
     *  Get User Fist Name
     *  return [FistName]
     */
    public function getFistName() {
        return $this->firstname;
    }

    /*
     *  Get User Last Name
     *  return [LastName]
     */
    public function getLastName() {
        return $this->lastname;
    }

    /*
     *  Get User Full Name
     *  return [FullName]
     */
    public function getFullName() {
        return $this->fullname;
    }

     /*
     *  Get User Fist Last Name
     *  return [FistName LastName]
     */
    public function getFistLastName() {
        return "$this->firstname $this->lastname";
    }

    /*
     * Get User Type
     * return [user type]
     */
    public function getUserType() {
        return $this->type;
    }


    /**
     * get roles options
     * return List roles
     */
    public function getRoleOptions() {
        return array(
            self::ADMIN => 'admin',
            self::MANAGER => 'manager',
            self::LEADER => 'leader',
            self::USER => 'user',
        );
    }
    /**
     * get role user login
     *
     * @param $id
     * @return mixed
     */
    public function getUserRole($id) {
        $role = User::model()->findByPk($id);
        $roles = $this->getRoleOptions();

        return $roles[$role->roles];
    }
    
    /*
     *  Auto General Password
     */
    public function autoGeneralPass() {
        $length = 10;
        $chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
        shuffle($chars);
        $password = implode(array_slice($chars, 0, $length));
        return $password;
    }

    /*
     * Set User's Date of Birth
     */
    public function setUserDob($dob){
        $bd = CDateTimeParser::parse($dob, 'MMM-dd-yyyy');
        return $this->dob=$bd;
    }

    public function getUserDob () {
        return date("M-d-Y",$this->dob);
    }

    public function getFullNameActive()
    {
      $users= User::model()->findAll(array('select' => 'id, fullname',
                                          'condition' => 'status =:status',
                                          'params' => array(':status' => self::ACTIVE)));
      $fullName = array();
      foreach($users as $user) {
        $fullName[] = $user['fullname'];
      }

      return $fullName;
    }

    public function getRole() {
      $id = Yii::app()->user->id;
      $user = User::model()->findByPk($id);
      return $user->roles;
    }

  /*
	 * Get List User for Search
	 */
  public function getListUserSearch() {
    $role = User::getRole();
    $users= User::model()->findAll(array('condition' => 'roles <='.$role.' AND status =:status', 'params' => array(':status'=>1)));

    $fullnames = array();
    foreach($users as $row)
    {
      $fullnames[$row->id] = $row['fullname'];
    }

    return $fullnames;

  }

  /*
     * Get List User for Search
     */
  public function getListUserSearchVacation() {
    $role = User::getRole();
    $users= User::model()->findAll(array('condition' => 'roles >'.$role.' AND status =:status', 'params' => array(':status'=>1)));
    $fullnames = array();
    foreach($users as $row)
    {
      $fullnames[] = $row['fullname'];
    }

    return $fullnames;

  }
  /*
	 * Get List Email for Search
	 */
  public function getListEmailSearch() {
    $role = $this->getRole();
    $users= User::model()->findAll(array('condition' => 'roles >'.$role));
    $emails = array();
    foreach($users as $row)
    {
      $emails[] = $row['email'];
    }

    return $emails;

  }
  public function getCreatedDate() {
    return date('M-d-Y h:i:s A', $this->created_date);
  }

  public function getUserName($id)
  {
    $users= User::model()->findByPk($id);
    //if($this->mod_status==2) //as private
    {
      return $users->fullname;
    }
  }
}