<?php

/**
 * This is the model class for table "employee_vacation".
 *
 * The followings are the available columns in table 'employee_vacation':
 * @property integer $id
 * @property integer $yearly_date
 * @property integer $remaining_vacation
 * @property string $employee_id
 * @property integer $year
 * @property integer $total_day_off
 * @property integer $pre_year_date
 * @property integer $flag
 *
 * The followings are the available model relations:
 * @property Employee $employee
 */
class EmployeeVacation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'employee_vacation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' year', 'numerical', 'integerOnly'=>true),
      array('total_day_off, pre_year_date, yearly_date, remaining_vacation', 'numerical', 'min'=>0.25, 'max'=>999.75, 'tooBig'=>'Long Time', 'tooSmall'=>'Invalid Number' ),
			array('employee_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, yearly_date, remaining_vacation, employee_id, year, total_day_off, pre_year_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'yearly_date' => 'Yearly Date',
			'remaining_vacation' => 'Remaining Vacation',
			'employee_id' => 'Employee',
			'year' => 'Year',
			'total_day_off' => 'Total Day Off',
			'pre_year_date' => 'Pre Year Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('yearly_date',$this->yearly_date);
		$criteria->compare('remaining_vacation',$this->remaining_vacation);
		$criteria->compare('employee_id',$this->employee_id,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('total_day_off',$this->total_day_off);
		$criteria->compare('pre_year_date',$this->pre_year_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmployeeVacation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

  public function getEmployeeByMaxId($user_id)
  {
    $employee_vacation = Yii::app()->db->createCommand()
      ->select('*')
      ->where('employee_id=:employee_id', array(':employee_id'=>$user_id))
      ->andWhere('flag=0')
      ->from('Employee_vacation')
      ->order('id desc')
      ->limit(1)
      ->queryRow();

    return $employee_vacation;
  }


}
