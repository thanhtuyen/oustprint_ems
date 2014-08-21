<?php
Yii::import('application.models.Behavior');

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property string $id
 * @property string $job_title
 * @property string $degree
 * @property string $degree_name
 * @property string $background
 * @property string $telephone
 * @property string $mobile
 * @property string $homeaddress
 * @property string $education
 * @property string $skill
 * @property string $experience
 * @property string $notes
 * @property string $avatar
 * @property string $cv
 * @property integer $department_id
 * @property integer $created_date
 * @property integer $updated_date
 * @property string $personal_email
 *
 * The followings are the available model relations:
 * @property Contract[] $contracts
 * @property Contract[] $contracts1
 * @property Contract[] $contracts2
 * @property User $user
 * @property EmployeeVacation[] $employeeVacations
 * @property Message[] $messages
 * @property Message[] $messages1
 * @property Salary[] $salaries
 * @property Vacation[] $vacations
 * @property Vacation[] $vacations1
 * @property Department[] $departments
 */
class Employee extends CActiveRecord
{

	const HR_Executive = 'HR Executive';
  const Jr_Developer = 'Jr Developer';
  const Developer_I = 'Developer I';
  const Developer_II = 'Developer II';
  const Developer_III = 'Developer III';
  const Senior_Developer = 'Senior Developer';
  const Jr_Tester = 'Jr Tester';
  const Test_Engineer_I = 'Test Engineer I';
  const Test_Engineer_II = 'Test Engineer II';
  const Test_Engineer_III = 'Test Engineer III';
  const Senior_Test_Engineer = 'Senior Test Engineer';
  const Business_Analyst = 'Business Analyst';
  const Jr_Designer = 'Jr Designer';
  const Designer = 'Designer';
  const Senior_Designer = 'Senior Designer';
  const Artist_2D = '2D Artist';
  const Artist_3D = '3D Artist';
  const Admin_staff = 'Admin Staff';
  const Receptionist = 'Receptionist';
  const Accountant_Manager = 'Accountant Manager';
  const Accountant = 'Accountant';
  const Chief_Accountant = 'Chief Accountant';
  const Project_Manager = 'Project Manager';
  const Operation_Manager = 'Operation Manager';
  const Managing_Director = 'Managing Director';
  const Marketing = 'Marketing';

  const S_THUMBNAIL = '/media/images/thumbnails/';
  const S_IMAGES      = '/media/images/';
  const S_CVS   = '/media/cv/';

  const Bussiness = 1;
  const Programming = 2;
  const Sotfware = 3;
  const HR       = 4;
  const Reception = 5;

  const ASSOCIATES = 'Associates';
  const DIPLOMA = 'Diploma/Certificate';
  const BACHELORS = 'Bachelors';
  const MASTER = 'Masters';
  const DOCTORATE = 'Doctorate';
  const NA     = 'N/A';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employee the static model class
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
		return 'employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, job_title', 'required', 'on' => 'update, create'),
			array('created_date, updated_date', 'numerical', 'integerOnly'=>true),
			array('telephone, mobile', 'length', 'max'=>11),
      array('telephone, mobile', 'length', 'min'=>10),
			array('job_title, degree, degree_name, background, homeaddress, avatar, cv, department_id, personal_email', 'length', 'max'=>255),
			array('education, skill, experience, notes', 'safe'),
			array('personal_email', 'email'),
			array('telephone, mobile', 'numerical'),
			array('avatar', 'file',
			        'types' => 'gif, jpg, png',
			        'maxSize' => 1024 * 1024 * 2,
			        'wrongType'=>'Please upload only images in the format jpg, gif, png',
			        'tooLarge' => 'The file was larger than 2MB. Please upload a smaller file.',
			        'allowEmpty' => true,'on' => 'update' ),
		    array('cv', 'file',
			        'types'=>'doc, pdf, docx',
			        'maxSize'=>1024*1024*2,
			        'wrongType'=>'Please upload only cv in the format doc, pdf, docx',
			        'tooLarge'=>'The file was larger than 2MB. Please upload a smaller file.',
			        'allowEmpty'=>true, 'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, job_title, degree, degree_name, background, telephone, mobile, homeaddress, education, skill, experience, notes, avatar, cv, department_id, created_date, updated_date, personal_email', 'safe', 'on'=>'search'),
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
			'contracts' => array(self::HAS_MANY, 'Contract', 'employee_id'),
			'contracts1' => array(self::HAS_MANY, 'Contract', 'created_id'),
			'contracts2' => array(self::HAS_MANY, 'Contract', 'updated_id'),
			'user' => array(self::BELONGS_TO, 'User', 'id'),
			'employeeVacations' => array(self::HAS_MANY, 'EmployeeVacation', 'employee_id'),
			'messages1' => array(self::HAS_MANY, 'Message', 'mod_sender_id'),
			'vacations' => array(self::HAS_MANY, 'Vacation', 'user_id'),
			'vacations1' => array(self::HAS_MANY, 'Vacation', 'approve_id'),
			'departments' => array(self::HAS_ONE, 'Department', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'job_title' => 'Job Title',
			'degree' => 'Degree',
			'degree_name' => 'Degree Name',
			'background' => 'Background',
			'telephone' => 'Telephone',
			'mobile' => 'Mobile',
			'homeaddress' => 'Homeaddress',
			'education' => 'Education',
			'skill' => 'Skill',
			'experience' => 'Experience',
			'notes' => 'Notes',
			'avatar' => 'Avatar',
			'cv' => 'Cv',
			'department_id' => 'Department',
			'created_date' => 'Created Date',
			'updated_date' => 'Updated Date',
			'personal_email' => 'Personal Email',
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
    $role = User::getRole();
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->with = array('user',  );
		$criteria->together = true; // ADDED THIS
    $criteria->compare('job_title',$this->job_title,true);
    $criteria->compare('degree',$this->degree,true);
    $criteria->compare('degree_name',$this->degree_name,true);
    $criteria->compare('background',$this->background,true);
    $criteria->compare('telephone',$this->telephone,true);
    $criteria->compare('department_id',$this->department_id,true);
    $criteria->addCondition("user.status = 1");
    $criteria->addCondition("user.roles >= ".$role);

    $employees =  new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
    ));
    $employee_export = new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
      'pagination' => false

    ));

    $_SESSION['employee_working'] = $employee_export;

    return $employees;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search1()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
    $role = User::getRole();
    $criteria=new CDbCriteria;
    $criteria->compare('id',$this->id,true);
    $criteria->with = array('user',  );
    $criteria->together = true; // ADDED THIS
    $criteria->compare('job_title',$this->job_title,true);
    $criteria->compare('degree',$this->degree,true);
    $criteria->compare('degree_name',$this->degree_name,true);
    $criteria->compare('background',$this->background,true);
    $criteria->compare('telephone',$this->telephone,true);
    $criteria->compare('department_id',$this->department_id,true);
    $criteria->addCondition("user.status = 0");
    $criteria->addCondition("user.roles >= ".$role);

    $employees =  new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
    ));
    $employee_export = new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
      'pagination' => false

    ));

    $_SESSION['employee_not_working'] = $employee_export;

    return $employees;
	}


	public function getDepartmentOption() 
	{
		$departments = Department::model()->findAll();
	
		$listDepartments = array();
		foreach ($departments as  $value) {
		
			$listDepartments[$value['id']] = $value['name'];
		}

		
		return $listDepartments;
	}

	 /**
     * get Job title options
     * return List Job title
     */
   public function getJobTitleOption() {
        return array(
            self::HR_Executive => 'HR Executive',
            self::Jr_Developer => 'Jr Developer',
            self::Developer_I => 'Developer I',
            self::Developer_II => 'Developer II',
            self::Developer_III => 'Developer III',
            self::Senior_Developer => 'Senior Developer',
            self::Jr_Tester => 'Jr Tester',
            self::Test_Engineer_I => 'Test Engineer I',
            self::Test_Engineer_II => 'Test Engineer II',
            self::Test_Engineer_III => 'Test Engineer III',
            self::Senior_Test_Engineer => 'Senior Test Engineer',
            self::Business_Analyst => 'Business Analyst',
            self::Jr_Designer => 'Jr Designer',
            self::Designer => 'Designer',
            self::Senior_Designer => 'Senior Designer',
            self::Artist_2D => '2D Artist',
            self::Artist_3D => '3D Artist',
            self::Admin_staff => 'Admin Staff',
            self::Receptionist => 'Receptionist',
            self::Accountant_Manager => 'Accountant Manager',
            self::Accountant => 'Accountant',
            self::Chief_Accountant => 'Chief Accountant ',
            self::Project_Manager => 'Project Manager',
            self::Operation_Manager => 'Operation Manager',
            self::Managing_Director => 'Managing Director',
        );
   }


 public function getDepartmentName($ali) {
        $jobFunctions = $this->getDepartmentOption();

        return isset($jobFunctions[$ali]) ?  $jobFunctions[$ali] : "unknown job function ({$ali})";
    }

    public function setDepartment($depart){
        return $this->department = $this->getDepartmentName($depart);
    }
    public function getDepartment(){
        return $this->department;
    }

    /**
     * get Job title options
     * return List Job title
     */
    public function getDepartmentList($departmentId = '') {
      switch($departmentId){
        case $departmentId == self::Bussiness:
          return array(
            self::Business_Analyst => 'Business Analyst',
            self::Marketing => 'Marketing',
          );
          break;
        case $departmentId == self::Programming:
          return array(
            self::Jr_Developer => 'Jr Developer',
            self::Developer_I => 'Developer I',
            self::Developer_II => 'Developer II',
            self::Developer_III => 'Developer III',
            self::Senior_Developer => 'Senior Developer',
            self::Jr_Designer => 'Jr Designer',
            self::Designer => 'Designer',
            self::Senior_Designer => 'Senior Designer',


              );
          break;
        case $departmentId == self::Sotfware:
          return array(
            self::Jr_Tester => 'Jr Tester',
            self::Test_Engineer_I => 'Test Engineer I',
            self::Test_Engineer_II => 'Test Engineer II',
            self::Test_Engineer_III => 'Test Engineer III',
            self::Senior_Test_Engineer => 'Senior Test Engineer',
          );
          break;
        case $departmentId == self::HR;
          return array(
            self::HR_Executive => 'HR Executive',
            self::Accountant_Manager => 'Accountant Manager',
            self::Accountant => 'Accountant',
            self::Chief_Accountant => 'Chief Accountant ',
            self::Project_Manager => 'Project Manager',
            self::Operation_Manager => 'Operation Manager',
            self::Managing_Director => 'Managing Director',
          );
          break;
        case $departmentId == self::Reception;
          return array(
            self::Receptionist => 'Receptionist',
          );
          break;
          default :
            return array(
              self::HR_Executive => 'HR Executive',
              self::Jr_Developer => 'Jr Developer',
              self::Developer_I => 'Developer I',
              self::Developer_II => 'Developer II',
              self::Developer_III => 'Developer III',
            );
          break;
      }
    }

  /**
   * get Job title options
   * return List Job title
   */
  public function getDegreeOption() {
    return array(
      self::ASSOCIATES => 'Associates',
      self::DIPLOMA => 'Diploma/Certificate',
      self::BACHELORS => 'Bachelors',
      self::MASTER => 'Masters',
      self::DOCTORATE => 'Doctorate',
      self::NA     => 'N/A',
    );
  }

}