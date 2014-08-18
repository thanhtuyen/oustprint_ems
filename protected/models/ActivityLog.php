<?php

/**
 * This is the model class for table "activity_log".
 *
 * The followings are the available columns in table 'activity_log':
 * @property string $activity_id
 * @property integer $activity_date
 * @property integer $user_id
 * @property integer $activity_type
 * @property integer $action_id
 * @property string $action_group

 */
class ActivityLog extends CActiveRecord
{
		public function getActivityId(){
		return $this->activity_id;
	}
	public function setActivityId($activity_id){
		return $this->activity_id = $activity_id;
	}
	public function getActivityDate(){
		return date('M-d-Y h:i:s A',$this->activity_date);
	}
	public function setActivityDate($activity_date){
		return $this->activity_date = $activity_date;
	}
		public function getUserId(){
		return $this->user_id;
	}
	public function setUserId($user_id){
		return $this->user_id = $user_id;
	}
		public function getActivityType(){
		return $this->activity_type;
	}
	public function setActivityType($activity_type){
		return $this->activity_type = $activity_type;
	}
		public function getActionId(){
		return $this->action_id;
	}
	public function setActionId($action_id){
		return $this->action_id = $action_id;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return ActivityLog the static model class
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
		return 'activity_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('activity_date, user_id, activity_type, action_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('activity_id, activity_date, user_id, activity_type, action_id, action_group', 'safe', 'on'=>'search'),
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
            'type' => array(self::BELONGS_TO, 'ActivityType', 'activity_type'),
		    'user' => array(self::BELONGS_TO, 'User', 'user_id'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'activity_id' => 'ID',
			'activity_date' => 'Time',
			'user_id' => 'Actor',
			'activity_type' => 'Action',
			'action_id' => 'Object',
			'action_group' => 'Type',
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

		$criteria->compare('activity_id',$this->activity_id,true);
		$criteria->compare('activity_date',$this->activity_date);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('activity_type',$this->activity_type);
		$criteria->compare('action_id',$this->action_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'activity_date desc'),
		    'pagination'=>array(
                'pageSize'=>Yii::app()->user->pageSize,
            ),
		));
	}
}