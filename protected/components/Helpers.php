<?php
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);


/**
 * It will return our WebApp.
 * to remove the code at our WebApp Yii::app()
 * Returns the application singleton, null if the singleton has not been created yet.
 * @return CApplication the application singleton, null if the singleton has not been created yet.
 */
function app()
{
  return Yii::app();
}

/*
 * convert string to lower case
 */
function textlower ($text){
  return strtolower($text);
}

/**
 * @param $value
 * @return string
 */
function encrypt($value) {
  return md5($value);
}

// Find the position of the first occurrence of a substring in a string
function startsWith($haystack, $needle)
{
  return strpos($haystack, $needle);
}

/*
 * return unix timestamp of current date
 */
function gettime(){
  return time();
}

/*
 *
 */
function get_date($date, $format){
  if(!$format) {
    $date = date('M-d-Y',$date);
  } else {
    $date = date($format,$date);
  }
  return $date;
}

/*
 * This function tries to return a string with all NUL bytes, HTML and PHP tags stripped from a given string
 */
function Clean($arr){
  foreach($arr as $key=>$value){
    $arr[$key] = strip_tags($value);
  }
  return $arr;
}

/*
 *
 */
function TimetoUnit($time, $format='MM-dd-yyyy'){

  $result = CDateTimeParser::parse ($time,$format);
  return $result;
}

 function getRole() {
  $id = Yii::app()->user->id;
  $user = User::model()->findByPk($id);

  return $user->roles;
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

?>
