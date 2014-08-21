<?php
class GlandoreHelper {
	
	public static function date($time) {
		$temp  = date('d  M  y');
		$input = date('d  M  y', $time);
		return ($input == $temp) ? "Today" : Yii::app()->dateFormatter->format(Yii::app()->user->getState('dateFormat'), $time);
	}
	
	public static function shortDate($time) {
		$temp  = date('d  M  y');
		$input = date('d  M  y', $time);
		return ($input == $temp) ? "Today" : Yii::app()->dateFormatter->format(Yii::app()->params['shortDateFormat'], $time);
	}
	
	public static function ajaxScript() {
		if (!Yii::app()->request->getIsAjaxRequest()) {
			return;
		}
		$c = Yii::app()->getController();
		echo '<script type="text/javascript" src="' . Yii::app()->request->baseUrl . '/js/' . $c->id . '.js' . '"></script>';
		if ($c && $c->action) {
			$a = "vs.{$c->id}.{$c->action->id}";
			echo "<script>$(function() {if (vs.{$c->id} != undefined && $a != undefined) $a()})</script>";
		}
	}
	
	public static function getNWord($str, $number, $extra="") {
		$wordArr = explode(' ',$str);
		$output = "";
		for($i=0;$i<$number;$i++){
			$output .= " ".$wordArr[$i];
		}
		return $output.$extra;
	}
	
	public static function getPathVideo($video){
		if($video!='')
			return Yii::app()->params['packageVideosPath'].$video;
		return ' -- ';
	}
	
	public static function formatModelErrors($model) {
		$str = array();
		foreach($model->getErrors() as $err) {
			$str[] = implode('. ', $err);
		}
		return implode('\n', $str);
	}
	# -------
	public static function getCategory3List(){
		return array(
					1 => "Live Job",
					2 => "Generic Search",
					3 => "Daily"		
				);
	}
	# -------
	public static function getCandidateList(){
		return array(
					1 => "Active and passive candidates",
					2 => "Active candidates only",
					3 => "Passive candidates only");
	}
	
	# -------
	public static function getBoolList(){
		return array(
					0 => "No",
					1 => "Yes");		
	}
	public static function getJobCategory3($id){
		$category3 = GlandoreHelper::getCategory3List();
		return $category3[$id];
	}
	public static function getJobCandidateType($id){
		$candidateType = GlandoreHelper::getCandidateList();
		return $candidateType[$id];
	}
	# -------	
	public function renderOptgroupSelect($name, array $arr, $selected = '--', $allText = '', $allTextValue = '--', $disabled = null, $extraAttrs = null)
	{
		if (!is_array($selected)) {
			$selected = array($selected);
		}	
		$html = '<select name="'. $name .'" '.$extraAttrs.'>';
		if (strlen($allText) > 1) 
			$html .= '<option value="'.$allTextValue.'">'.$allText.'</option>';
		foreach ($arr as $key=>$subarr) {
			$html .= '<optgroup label="'. $key .'">';
			foreach($subarr as $r) {
				$tmp = null;
				if (in_array($r['value'], $selected)) {
					$tmp = 'selected="selected"';
				}
				$html .= '<option value="'. $r['value'] .'" '.$tmp.'>'. $r['label'] .'</option>';
			}
			$html .= '</optgroup>';
		}
		$html .= '</select>';
		return $html;
	}
	# -------	
	public function sortArr($inArr = array(), $field)
	{			
		$sortArr = array();
		foreach ($inArr as $temp) {	
			$sortArr[$temp[$field]][] = $temp;
		}
		return $sortArr;
	}	
	
	public function getFileType($filename){
		if($filename!=''){
			$fileArr = explode(".",$filename);
			return ".".$fileArr[count($fileArr)-1];
		}
		return false;
	}
	
	# -------
	public function getDegreeList()
	{
		return array(
			'Bachelors'=>'Bachelors',
			'Masters'=>'Masters',
			'Doctorate'=>'Doctorate',
			'Certificate/Diploma'=>'Certificate/Diploma',
			'Associates' => 'Associates',
			'N/A' => 'N/A'
		);
	}
	# -------
	function getJobTitleyears()
	{
		return array(
			'Noinfo'=>'No info',
			'0to5'=>'0 to 5 years',
			'5to10'=>'5 to 10 years',
			'10to15'=>'10 to 15 years',
			'15Plus'=>'15+'
		);
	}	
	# -------
	function inputValue($input)
	{
		if(isset($input) && $input!='')
			return $input;
		return '';
	}	
	
	# -------
	function getGMapPoint($zipcode, $country, $location)
	{	$geo = array();
		$sql = "SELECT latitude, longitude FROM geoname " .
			"WHERE ".
				"(REPLACE(REPLACE(:postalCode, ' ', ''), '-', '') LIKE CONCAT(REPLACE(REPLACE(postal_code, ' ', ''), '-', ''), '%') " .
					"AND (country_code = :countryCode " .
					"OR country_name = :countryName " .
					"OR country_iso3 = :countryIso3 " .
					"OR country_iso_numeric = :countryIsoNumeric " .
					"OR country_fips = :countryFips)) " .
				" OR ".
				"(REPLACE(REPLACE(:cityName, ' ', ''), '-', '') LIKE CONCAT(REPLACE(REPLACE(admin_name1, ' ', ''), '-', ''), '%') " .
					"AND (country_code = :countryCode " .
					"OR country_name = :countryName " .
					"OR country_iso3 = :countryIso3 " .
					"OR country_iso_numeric = :countryIsoNumeric " .
					"OR country_fips = :countryFips) " .
				") ".
			"ORDER BY LENGTH(postal_code) " .
			"LIMIT 1;";
			
			$command = Yii::app()->db->createCommand($sql);
			$command->bindValue(":postalCode", $zipcode, PDO::PARAM_STR);
			$command->bindValue(":countryCode", $country, PDO::PARAM_STR);
			$command->bindValue(":countryName", $country, PDO::PARAM_STR);
			$command->bindValue(":countryIso3", $country, PDO::PARAM_STR);
			$command->bindValue(":countryIsoNumeric", $country, PDO::PARAM_INT);
			$command->bindValue(":countryFips", $country, PDO::PARAM_STR);
			$command->bindValue(":cityName", $location, PDO::PARAM_INT);
			
			$coordinates = $command->queryAll();
			
			$geo['latitude'] = $coordinates[0]['latitude'];
			$geo['longitude'] = $coordinates[0]['longitude'];
			
			return $geo;
	}	
	
	function viewRank($rank=0){
		$rank = round($rank);
		if($rank){
			for($i=1;$i<=5;$i++){
				if($rank==$i){
					echo "<input type='radio' name='rate_avg' value='$i' disabled='disabled' checked='checked' />";
				}else{
					echo "<input type='radio' name='rate_avg' value='$i' disabled='disabled' />";
				}
			}
		}
	}
	
	function arrToStr($arr,$comma=','){
		if(!empty($arr)){
			return implode($comma,$arr);
		}
		return '';
	}
	
	function setFavourite($favourite){
		if($favourite=='' || $favourite == 'None'){
			return "<img src='".Yii::app()->request->baseUrl."/images/not-like1.png' />&nbsp;";
		}else{
			return "<img src='".Yii::app()->request->baseUrl."/images/like1.png' class='view-favourite' />&nbsp;";
		}
	}
	
	function setFeature($status=0,$id){
		if($status){
			return "<a href='".Yii::app()->createUrl('package/setFeature',array('id'=>$id))."' class='featured' title='Featured' ></a>";
		}else{
			return "<a href='".Yii::app()->createUrl('package/setFeature',array('id'=>$id))."' class='not-featured' title='Not featured'></a>";
		}
	}
	
	function getJobYearsElement($key){
		$arrYears = GlandoreHelper::getJobTitleyears();
		return $arrYears[$key];
	}
	
	public function candResubmit($flag, $reason)
	{
		$arr = array(
			1 => "<strong>Resubmitted</strong> " . $reason,
			2 => "<strong>Updated</strong> " . $reason,
		);
		if ($flag) {
			return '<div class="msg help">' . $arr[$flag] . '</div>';
		} else if ($reason) {
			return '<div class="msg help"><strong>New</strong> &raquo; ' . nl2br(CHtml::encode($reason)) . '</div>';
		}
		return null;
	}
	
	public function create_tag_cloud($array,$limit_top_size = 38,$limit_low_size = 18)
	{	
		// Create the return array
		$return_array = array();
		// Duplicate for minor actions
		$array_temp = $array;
		// Sort on reverse order maintaining original keys
		arsort($array_temp);
		// Get max and min values
		$max_value = current($array_temp);
		$min_value = end($array_temp);
		// It's always good to keep system memory clear when we finish our job :)
		unset($array_temp);
		// Now we go over all the values and determine what size they should have
		while (list($key, $value) = each($array)) {
			// If we're talking about the max value it will the take the supplied max value
			if($value == $max_value)
				$return_array[$key] = $limit_top_size;
			// If the minimum
			else if($value == $min_value) {
				$return_array[$key] = $limit_low_size;
			}
			// Or if it's somewhere in the middle
			else {
				// Simple math calculation that gives the size taking in account the proportion of the max value
				$return_array[$key] = ceil(($value*$limit_top_size)/$max_value);
			}
		}
		// Our job is done :)
		return($return_array);
	}
	
	static function clean($arr){
		foreach($arr as $key=>$value){
			$arr[$key] = strip_tags(trim($value));
		}
		return $arr;
	}
	
	function getYearsEx($toYear){
		$i = 1;
		$years = array();
		for($i;$i<=$toYear;$i++){
			$years[$i] = $i;
		}
		return $years;
	}
	
	function getMonthEx($toMonth){
		$i = 1;
		$months = array();
		for($i;$i<=$toMonth;$i++){
			$months[$i] = $i;
		}
		return $months;
	}
	
	function getDaysReminder($sEndDate,$sStartDate){
	  	$days = abs((strtotime($sEndDate) - strtotime($sStartDate)) / (60 * 60 * 24));
	  	if($days>0)
			return $days;
		return 0; 
	}
	
	function getDaysReminderColor($day){
		$color = "#009B66";
	  	if($day<=3){
	  		$color =  "#fc0202";
	  	}elseif($day<=15 && $day>3){
	  		$color =  "#FDE101";
	  	}
	  	return $color;
	}
	
	function getDays(){
		$i = 1;
		$days = array();
		for($i;$i<=31;$i++){
			$days[$i] = $i;
		}
		return $days;
	}
	
	function getMonths(){
		$i = 1;
		$months = array();
		for($i;$i<=31;$i++){
			$months[$i] = $i;
		}
		return $months;
	}
	
	function getYears(){
		$i = date("Y");
		$to = $i+5;
		$years = array();
		for($i;$i<=$to;$i++){
			$years[$i] = $i;
		}
		return $years;
	}
	
	function add_date($mth=0) {
      	$cd = strtotime(date('Y-m-d'));
      	$retDAY = date('Y-m-d', mktime(0,0,0,date('m',$cd)+$mth,date('d',$cd),date('Y',$cd)));
  		return $retDAY; 
	}
	
	public function substr($string, $start = 0, $length = 0, $append = '')
    {
        $stringLast = "";
		
        if (substr($string, 0, 1)=="<")		//	in case rich text format
        {
            $stringLast = "a very important thing";   
			$stringLast .= $append;
        }
		else 
		
		if ($start < 0 || $length < 0 || strlen($string) <= $length)
        {
            $stringLast = $string;
        }
        else
        {
            $i = 0;
            while ($i < $length)
            {
                $stringTMP = substr($string, $i, 1);
                if ( ord($stringTMP) >=224 )
                {
                    $stringTMP = substr($string, $i, 3);
                    $i = $i + 3;
                }
                elseif( ord($stringTMP) >=192 )
                {
                    $stringTMP = substr($string, $i, 2);
                    $i = $i + 2;
                }
                else
                {
                    $i = $i + 1;
                }
                $stringLast[] = $stringTMP;
            }
            $stringLast = implode("",$stringLast);
            if(!empty($append))
            {
                $stringLast .= $append;
            }
        }
        return $stringLast;
    }
	
}