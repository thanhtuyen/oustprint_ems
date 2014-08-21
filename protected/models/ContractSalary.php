<?php
/**
 * This is the model class for table "contract".
 *
 * The followings are the available columns in table 'contract':
 * @property integer $id
 * @property integer $contract_id
 * @property integer $gross_salary
 * @property string $net_salary
 * @property integer $petrol_allowance
 * @property integer $lunch_allowance
 * @property integer $other_allowance
 */
class ContractSalary extends CActiveRecord {

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
    return 'contract_salary';
  }

  public function rules()
  {
    return array(
      array(' gross_salary, net_salary','required'),
      array('gross_salary, net_salary, petrol_allowance, lunch_allowance, other_allowance', 'numerical', 'integerOnly'=>true),
      array('contract_start_date, contract_end_date', 'safe', 'on'=>'search'),
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
      'contract' => array(self::BELONGS_TO, 'Contract', 'contract_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id'          => 'ID',
      'contract_start_date' => 'Contract Start',
      'contract_end_date' => 'Contract End',
      'contract_id' => 'Contract ID',
      'gross_salary' => 'Gross Salary',
      'net_salary' => 'Net Salary',
      'petrol_allowance' => 'Petrol Allowance',
      'lunch_allowance' => 'Lunch Allowance',
      'other_allowance'  => 'Other Allowance',
    );
  }
  public function beforeValidate()
  {
    $this->gross_salary = str_replace(",","",$this->gross_salary);
    $this->petrol_allowance = str_replace(",","",$this->petrol_allowance);
    $this->net_salary = str_replace(",","",$this->net_salary);
    $this->lunch_allowance = str_replace(",","",$this->lunch_allowance);
    $this->other_allowance = str_replace(",","",$this->other_allowance);
    return parent::beforeValidate();
  }

  public static function exec_CurrentUSD() {
    $data=file_get_contents("http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx");
    $p = xml_parser_create();
    xml_parse_into_struct($p,$data , $xmlData);
    xml_parser_free($p);
    $rate = 20840;
    for($i = 0; $i<= count($xmlData); $i++)
    {
      if($xmlData[$i]['attributes']['CURRENCYCODE'] == "USD")
      {
        //echo $xmlData[$i]['attributes']['CURRENCYCODE']." ";
        //echo number_format($xmlData[$i]['attributes']['BUY']);
        $rate = $xmlData[$i]['attributes']['BUY'];
      }
    }
    return $rate;
  }

  public static function get_CurrentUSD($format = 0) {
    ini_set("display_errors", 1);

    $cache = new CFileCache;
    if ($cache->get('rate')) {
      $rate = $cache->get('rate');
    }
    else {
      $rate = ContractSalary::exec_CurrentUSD();
      $cache->set('rate', $rate, 0);
    }

    if($format == 0)
      return $rate;
    else
      return number_format($rate);

  }

}