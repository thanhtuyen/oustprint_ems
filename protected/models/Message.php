<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property string $id
 * @property string $types
 * @property string $status
 * @property integer $created_date
 * @property string $message_info
 * @property string $mod_user_id
 * @property string $mod_sender_id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property Employee $modUser
 * @property Employee $modSender
 */
class Message extends CActiveRecord
{

  const TYPE_NOTICE= 1;
  const TYPE_NEWS= 2;
  const TYPE_MESSAGE= 3;

  const STATUS_PUBLIC= 1;
  const STATUS_PRIVATE= 2;
  const STATUS_GROUP= 3;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
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
		return 'message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message_info', 'required'),
			array('created_date', 'numerical', 'integerOnly'=>true),
			array('types, status, mod_user_id, mod_sender_id', 'length', 'max'=>11),
			array('title', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, types, status, created_date, message_info, mod_user_id, mod_sender_id, title', 'safe', 'on'=>'search'),
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
			'modUser' => array(self::BELONGS_TO, 'Employee', 'mod_user_id'),
			'modSender' => array(self::BELONGS_TO, 'Employee', 'mod_sender_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'types' => 'Types',
			'status' => 'Status',
			'created_date' => 'Created Date',
			'message_info' => 'Message Info',
			'mod_user_id' => 'Mod User',
			'mod_sender_id' => 'Mod Sender',
			'title' => 'Title',
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

      $id = Yii::app()->user->id;
      $criteria=new CDbCriteria(array(
        'order'=>'created_date DESC',
        'condition'=>"mod_user_id = (".$id.") || mod_sender_id = (".$id.") || status = 1",
      ));

      if($this->mod_sender_id)
      {
        $criteria->compare('t.mod_sender_id', $this->mod_sender_id);
      }

		$criteria->compare('types',$this->types,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created_date',$this->created_date);
		$criteria->compare('message_info',$this->message_info,true);
//		$criteria->compare('mod_user_id',$this->mod_user_id,true);
//		$criteria->compare('mod_sender_id',$this->mod_sender_id,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

  public function listTypes()
  {
    return array(
      self::TYPE_NOTICE => 'Notice',
      self::TYPE_NEWS => 'News',
      self::TYPE_MESSAGE => 'Message',
    );
  }
  public function getTypeName($type) {
    $listTypes = $this->listTypes();

    return isset($listTypes[$type]) ?  $listTypes[$type] : "unknown type ({$type})";
  }
  public static function getStatusArr()
  {
    return array(
      //''=>'Status',
      self::STATUS_PUBLIC => 'Public',
      self::STATUS_PRIVATE => 'Private',
//      self::STATUS_GROUP => 'Group',
    );
  }
  public function getStatusName($status) {
    $listStatus= $this->getStatusArr();

    return isset($listStatus[$status]) ?  $listStatus[$status] : "unknown status ({$status})";
  }
  /*
    * Get List User for Search
    */
  public function getListUserSendMessage($status='') {
    $users= User::model()->findAll();
    $fullnames = array();
    foreach($users as $row)
    {
        $fullnames[$row['id']] = $row['fullname'];
    }
    switch($status){
      case self::STATUS_PUBLIC:
        return array(
          '' => 'Everyone',
        );
      break;
      case self::STATUS_PRIVATE:
        return $fullnames;

      break;
      default :
      return array(
        '' => 'Everyone',
      );
      break;
    }


   // return $fullnames;

  }
  public function setCreatedDate($created_date){
    $bd = CDateTimeParser::parse($created_date, 'MM-dd-yyyy');
    $this->created_date=$bd;
    //return $this->mod_date = $mod_date;
  }

  public function getUserName($id)
  {
    $users= User::model()->findByPk($id);
    //if($this->mod_status==2) //as private
    {
      return $users->fullname;
    }
  }

  public function getRole() {
    $id = Yii::app()->user->id;
    $user = User::model()->findByPk($id);

    return $user->roles;
  }
}