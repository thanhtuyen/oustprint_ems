<?php

/**
 * This is the model class for table "activity_log".
 *
 * The followings are the available columns in table 'activity_log':
 * @property string $id
 * @property integer $activity_date
 * @property string $user_id
 * @property string $activity_type
 * @property string $action_group
 * @property string $action_id
 * @property string $ip_logged
 *
 * The followings are the available model relations:
 * @property User $user
 * @property User $action
 * @property ActivityType $activityType
 */
class ActivityLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
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
			array('activity_date, user_id, activity_type, action_group, action_id, ip_logged', 'required'),
			array('activity_date', 'numerical', 'integerOnly'=>true),
			array('user_id, activity_type, action_id', 'length', 'max'=>11),
			array('action_group, ip_logged', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, activity_date, user_id, activity_type, action_group, action_id, ip_logged', 'safe', 'on'=>'search'),
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
			'action' => array(self::BELONGS_TO, 'User', 'action_id'),
			'activityType' => array(self::BELONGS_TO, 'ActivityType', 'activity_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'activity_date' => 'Activity Date',
			'user_id' => 'Actor',
			'activity_type' => 'Action',
			'action_group' => 'Action Group',
			'action_id' => 'Action',
			'ip_logged' => 'Ip Logged',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('activity_date',$this->activity_date);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('activity_type',$this->activity_type,true);
		$criteria->compare('action_group',$this->action_group,true);
		$criteria->compare('action_id',$this->action_id,true);
		$criteria->compare('ip_logged',$this->ip_logged,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      'sort'=>array(
        'defaultOrder'=>'t.id DESC',
      ),
      'pagination' => array(
        'pageSize' => 25,
      ),
		));
	}

  public function getActivityDate()
  {
    return date('M-d-Y h:i:s A',$this->activity_date);
  }
}