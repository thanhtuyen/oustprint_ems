<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="toolbar">
</div>

<?php /* echo '<pre>';
	  print_r($model);
	  echo '</pre>';*/
	//$dataProvider = $model->search();
	date_default_timezone_set("Asia/Saigon");
?>

<?php if(Yii::app()->user->hasFlash('work_status')):?>
	<h3 class="flash_info">
        <?php echo Yii::app()->user->getFlash('work_status'); ?>
    </h3>
<?php endif; ?> 

<?php 
	$profile = Profile::model()->findByPk($model->user_id);
?>
<?php if(Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('manager')):?>
	<?php if($profile->user_status==0):?>
		<a href="<?php echo Yii::app()->createUrl('/user/move', array('id'=>$model->user_id));?>" class="ico-edit" style="float:right; clear: both;">Move to Non-working list</a>   
	<?php endif; ?>
	<?php if($profile->user_status==1):?>
		<a href="<?php echo Yii::app()->createUrl('/user/unmove', array('id'=>$model->user_id));?>" class="ico-edit" style="float:right; clear: both;">Move to Working list</a>   
	<?php endif; ?>
<?php endif; ?>

<?php

?>


<h3 class="title">Profile of <?php echo $model->user->user_full_name; ?></h3>

<script>
	$(document).ready(function(){
		if($('.p_name:empty')) $('.p_name:empty').html('-');
		if($('.p_name2:empty')) $('.p_name2:empty').html('-');	
	});
</script> 


<div class="img_avatar">	
	<a href='<?php echo Yii::app()->createUrl('/profile/changeAvatar', array('id'=>$model->getPrimaryKey())); ?>'>
	</a>
	<span class="img_avatar">
		<?php 
			$imagestring = file_get_contents(Yii::app()->params['imagePath'] . $model->getPrimaryKey());
			if(!$imagestring)
			{
				$imagestring = file_get_contents(Yii::app()->params['imagePath'] . '0');
			}
			//print_r(imagecreatefromstring($imagestring));exit;
			$en = base64_encode($imagestring);
			//$mime='image/png';
			$binary_data='data:' . $mime . ';base64,' . $en . '';
			echo CHtml::image($binary_data);
		?>
	</span>
</div>
<div class="img_cv" style="float: right;">
<?php if(isset($model->user_cv)) echo CHtml::link("<div class=\"has_cv\"></div>", Yii::app()->createUrl('/profile/downloadCV', array('id'=>$model->getPrimaryKey())),array("title"=>"My CV")); else echo "<div class=\"no_cv\" >No CV</div>"; ?>
</div>

<?php if(($model->user_id == Yii::app()->user->id) || (($model->user_id != Yii::app()->user->id) && Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager'))): ?>

	<?php 
		$end_alert = strtotime($model->user_end_contract_date?$model->getUserEndContractDate():null) - strtotime(date('M-d-Y')) ; 
		$end_alert = $end_alert / 2592000 ; 
		//print_r($end_alert); exit;
	?>
	
<div class="profile_info2">
	<br> 
	<span class="p_title_fix" style=""><?php echo "Probation Start: "; ?></span> 
	<span class="p_name_fix" style=""><?php echo $model->user_probation_start_date?$model->getUserProbationStartDate():'-'; ?></span>  
	<span class="p_name_fix" style=""><?php echo $model->user_probation_length?"In ".$model->user_probation_length." days":'-'; ?></span> 
	<br> 
	<br> 
	<span class="p_title_fix" style="">
		<?php echo "Official Start: "; ?>
	</span>  
	<span class="p_name_fix" style="">
		<?php echo $model->user_official_start_date?$model->getUserOfficialStartDate():'-'; ?>
	</span>  
	<span class="p_name_fix" style="">
		<?php echo $model->user_official_contract_length?"In ".$model->user_official_contract_length." months":'-'; ?>
	</span> 
 
	<span class="p_title_fix" style="<?php if($end_alert>0 && $end_alert<3) echo "border-radius: 4px 0px 0px 4px; background: gold; color: #333;"; ?>">
		<?php echo "End Contract: "; ?>
	</span>   
	<span class="p_name_fix" style="<?php if($end_alert>0 && $end_alert<3) echo "border-radius: 0px 4px 4px 0px; background: gold; color: #333;"; ?>">
		<?php echo $model->user_end_contract_date?$model->getUserEndContractDate():'-'; ?>
	</span> 
	<br> 	
	<br> 	
	
	<?php if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager')):?>
	
	<span class="p_title_fix" style="">
		<?php echo "Petrol Allowance: "; ?>
	</span>  
	<span class="p_name_fix" style="">
		<?php echo $model->user_petrol_allowance?$model->user_petrol_allowance:'-'; ?>
	</span> 
	
	<span class="p_name_fix" style="">
		<?php echo "&nbsp;"; ?>
	</span>  
	<span class="p_title_fix" style="">
		<?php echo "Net Salary: "; ?>
	</span>  
	<span class="p_name_fix" style="">
		<?php echo $model->user_net_salary?$model->user_net_salary:'-'; ?>
	</span>  
		
	<br> 
	<span class="p_title_fix" style="">
		<?php echo "Other Allowance: "; ?>
	</span>  
	<span class="p_name_fix" style="">
		<?php echo $model->user_other_allowance?$model->user_other_allowance:'-'; ?>
	</span>  
	
	<?php endif; ?>
	
</div> 

<?php endif; ?>

<div class="profile_info">
	<span class="p_title"><?php echo "Name: "; ?></span>
	<span class="p_name"><?php echo $model->user->getFullName(); ?></span> 

	<span class="p_name2"><?php echo $model->user_full_name; ?></span>
	<span class="p_title2"><?php echo "Full Name: "; ?></span>
</div> 

<div class="profile_info">
	<span class="p_title"><?php echo "Code: "; ?></span>
	<span class="p_name"><?php echo $model->user_code; ?></span>

	<span class="p_name2"><?php echo $model->getUserDob(); ?></span>
	<span class="p_title2"><?php echo "Birthday: "; ?></span>
</div> 

<div class="profile_info">
	<span class="p_title"><?php echo "Function: "; ?></span>
	<span class="p_name"><?php echo $model->user_job_function; ?></span>

	<span class="p_name2"><?php echo $model->user_job_title; ?></span>
	<span class="p_title2"><?php echo "Title: "; ?></span>
</div>  

<div class="profile_info">&nbsp;</div> 

<div class="profile_info">
	<span class="p_title"><?php echo "Background: "; ?></span>
	<span class="p_name"><?php echo $model->user_background; ?></span>

	<span class="p_name2"><?php echo $model->user_email; ?></span> 
	<span class="p_title2"><?php echo "Email: "; ?></span>
</div> 

<div class="profile_info">
	<span class="p_title"><?php echo "Degree Type: "; ?></span>
	<span class="p_name"><?php echo $model->user_degree_type; ?></span> 

	<span class="p_name2"><?php echo $model->user_telephone_number; ?></span> 
	<span class="p_title2"><?php echo "Phone: "; ?></span>
</div> 

<div class="profile_info">
	<span class="p_title"><?php echo "Degree Name: "; ?></span>
	<span class="p_name"><?php echo $model->user_degree_name; ?></span> 

	<span class="p_name2"><?php echo $model->user_home_address; ?></span> 
	<span class="p_title2"><?php echo "Address: "; ?></span>
</div>  


<?php if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager')): ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(	 
		array(
			'name'=>'user_education',
			'type'=>'raw',
		     'value'=>$model->user_education?$model->user_education:'-', 
		),
		array('name'=>'user_skill',
				'type'=>'raw',
		      'value'=>$model->user_skill?$model->user_skill:'-', 
		),
		array('name'=>'user_employment',
				'type'=>'raw',
		      'value'=>$model->user_employment?$model->user_employment:'-', 
		),
		array('name'=>'user_notes',
				'type'=>'raw',
		      'value'=>$model->user_notes?$model->user_notes:'-', 
		), 
	),
)); ?>

<?php elseif(Yii::app()->user->checkAccess('input_user') || Yii::app()->user->checkAccess('user')): ?>
  
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(	 
		array(
			'name'=>'user_education',
			'type'=>'raw',
		     'value'=>$model->user_education?$model->user_education:'-', 
		),
		array('name'=>'user_skill',
				'type'=>'raw',
		      'value'=>$model->user_skill?$model->user_skill:'-', 
		),
		array('name'=>'user_employment',
				'type'=>'raw',
		      'value'=>$model->user_employment?$model->user_employment:'-', 
		), 
	),
)); ?>
 
<?php endif; ?>

<!-- User's Vacations -->
<!--
<h1>Vacations History</h1>
-->
<?php 
/*
$date = Yii::app()->dateFormatter;
foreach ($vacations as $va) { 
	echo 'From ' . $date->formatDateTime($va->start_day).' to '.$date->formatDateTime($va->end_day);
	echo "<br />";
}
*/
?>
<!-- End User's Vacations -->

</br>  

<?php if(($model->user_id == Yii::app()->user->id) || (($model->user_id != Yii::app()->user->id) && Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager'))): ?>

<?php 
		$user_id = $model->user_id;
		$user = User::model()->findByPk($user_id);
		$vaca = Vacation::model()->findByPk($user_id);
		$vacation = Vacation::model();
		$doq_vacation_day = $user->getVacationDays()?$user->getVacationDays():0;
		$holidays=$doq_vacation_day;
		$doq_sick_day = $user->getSickDays()?$user->getSickDays():0;
		$sick_day=$doq_sick_day;
		 
		$vacation1 = Vacation::model()->findAll(array(
												'condition'=>'user_id=:id and status=3 and reason!=2',
												'params'=>array(':id'=>$user_id
												)
												));
		$vacation2 = Vacation::model()->findAll(array(
												'condition'=>'user_id=:id and status=3 and reason=2',
												'params'=>array(':id'=>$user_id
												)
												));
		// begin calculate vacation day
		foreach($vacation1 as $row)
		{	$list1[]= $row['attributes'];
		}
		$total =0;
		foreach($list1 as $l)
		{	$total+= $l['total'];}	
		// end calculation vacation day
		// begin calculation Sick day
		foreach($vacation2 as $row)
		{	$list2[]= $row['attributes'];
		}
		$total_sick =0;
		foreach($list2 as $l)
		{	$total_sick+= $l['total'];}	
		//end calculate Sick day
		
		if($vaca->reason==2)
		{
			if($sick_day>=$total_sick)	$sick_day = $sick_day - $total_sick;
			else{
				$tam = $total_sick - $sick_day;
				$holidays = $holidays - $tam;
			}
		}
		else
		{
			$holidays = $holidays - $total;
		}
		
		$doq_sick_day=$sick_day;
		$doq_vacation_day=$holidays;  
?>

<div style="">

<h3 class="title">Vacations History of <?php echo $model->user_full_name; ?></h3>

<?php if($user->getVacationDays()): ?>
<div style="background: lightblue; padding: 10px 0px;  float: left; clear: both; width: 100%; text-align: center; border-bottom: solid thin grey; border-radius: 4px 4px 0px 0px;">
<div style="float: left;   clear: left;  padding: 0px 25px; font-weight: bolder;">
<?php 
	if($doq_sick_day>=0) echo "You have ".$doq_sick_day.' '.$model->showday($doq_sick_day)." off quota for sick remaining";
	else echo "Your sick days off quota is over ";
?> 
</div>
<div style="float: right;  clear: right; padding: 0px 25px;font-weight: bolder; ">
<?php	
	if($doq_vacation_day>=0) echo "You have ".$doq_vacation_day.$model->showday($doq_vacation_day)." off quota remaining";
	else echo "Your vacation days off quota is over. You own the company ".abs($doq_vacation_day).$model->showday(abs($doq_vacation_day));
?>
</div>
</div>
<?php else: ?>
<h3 class="warn_info">Please ask your manager to set your days off quota</h3>
<?php endif; ?>

<div>
<?php 
$date = Yii::app()->dateFormatter;
foreach ($vacations as $va): 
?>
<li>
<a href="<?php echo Yii::app()->createUrl('/vacation/').'/'.$va->vacation_id; ?>" title="view vacation detail">
<?php if($va->user_id==$model->user_id && ($va->status==1||$va->status==2||$va->status==3)): ?>
	<span style="background: #E5F1F4; padding: 10px 25px;  float: left; width: 45.0%;  border: solid thin grey; border-radius:  0px ;">
	<?php 
		if($va->getStatusName()=="Accepted") echo "<b style=\"color:green\">[".$va->getStatusName()."]</b><br> ";
		elseif($va->getStatusName()=="Waiting") echo "<b style=\"color:blue\">[".$va->getStatusName()."]</b><br> ";
		else echo "<b style=\"color:green\">[".$va->getStatusName()."]</b><br> ";
		
		if(Vacation::model()->getdaysnumber()>1)
			echo '<b>'.$vacation->getdaysnumber().' days</b> ';
		if($vacation->getdaysnumber()<=1)
			echo '<b>'.$va->total.' day</b> ';
	?>
	<?php echo ' <b>'.$va->getReasonName().'</b>'; ?> 
	<?php //echo ' <sup><b>'.$va->user->user_full_name.'</b></sup>'; ?>
	<?php echo '  from '.date("H",$va->start_day)."h".date("i",$va->start_day)." ".date("D",$va->start_day).' <strong>'.$va->getStartDay().'</strong>  '.' to '.date("H",$va->end_day)."h".date("i",$va->end_day)." ".date("D",$va->end_day).' '.$va->getEndDay().'  '; ?>
	</span>

<?php endif; ?>
</a>
</li>
<?php endforeach; ?>

</div>

</div>

<?php endif; ?> 
<?php ?>


<?php ?>