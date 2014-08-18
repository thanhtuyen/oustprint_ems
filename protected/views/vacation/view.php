<?php
	date_default_timezone_set('Asia/Saigon');
?>

<div style="width: 100%;">

<h3 class="title">
<?php echo ' <span style="float: left; padding-left: 10px;"><strong>'.$model->user->user_full_name.': </strong></span>'; ?>
<?php 
	if($model->getdaysnumber()>1)
		echo '<span> '.$model->getdaysnumber().' days</span> ';
	if($model->getdaysnumber()<=1)
		echo '<span> '.$model->total.' day</span> ';
?>
<?php echo $model->getReasonName(); ?>
<?php echo ' <span>from '.date("H",$model->start_day)."h".date("i",$model->start_day)." ".date("D",$model->start_day).' <strong>'.$model->getStartDay().'</strong>  '.' to '.date("H",$model->end_day)."h".date("i",$model->end_day)." ".date("D",$model->end_day).' <strong>'.$model->getEndDay().'</strong></span>'; ?>
</h3>


<?php if($model->status==2 || $model->status==3 || $model->status==4 || $model->status==5) :?>
	<?php if($model->more_reason): ?>
	<h3 class="flash_info">
		<span style="float:left; background: whiteSmoke; padding: 2px; margin: -4px; border-radius: 4px; border: solid gold 2px; width: 100px;">Reason</span>
		<?php echo $model->getMoreReason(); ?>
	</h3> 
	<?php endif; ?>
	<?php if($model->comment_one): ?>
	<h3 class="yes_info">
		<span style="float:left; background: whiteSmoke; padding: 2px; margin: -4px; border-radius: 4px; border: solid gold 2px; width: 100px;">Comment</span>
		<?php echo $model->comment_one; ?>
	</h3>  
	<?php endif; ?>
	<?php if($model->comment_two): ?>
	<h3 class="yes_info">
		<span style="float:left; background: whiteSmoke; padding: 2px; margin: -4px; border-radius: 4px; border: solid gold 2px; width: 100px;">Comment</span>
		<?php echo $model->comment_two; ?>
	</h3>  
	<?php endif; ?>
<?php elseif($model->status==1) :?>
	<?php if($model->more_reason): ?>
	<h3 class="flash_info">
		<span style="float:left; background: whiteSmoke; padding: 2px; margin: -4px; border-radius: 4px; border: solid gold 2px; width: 100px;">Reason</span>
		<?php echo $model->getMoreReason(); ?>
	</h3> 
	<?php endif; ?> 
<?php endif;?>


<h3 class="title">
<?php 
	if($model->status==1)		//	new vacation awaiting
	{
		echo '<span id="title await"><strong>The vacation is awaiting</strong></span>';
		if(($model->user_id)==(Yii::app()->user->id))		//	dung nguoi
		{
			echo CHtml::button('Widthdraw', array('submit' => array('vacation/withdraw','id'=>$model->vacation_id)));
		}
		//print_r($model->user->getUserRole(Yii::app()->user->id));exit;
		//if(($model->user->getUserRole(Yii::app()->user->id))<>"user")		//	co quyen admin/manager
		if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager'))		//	co quyen admin/manager
		{
			echo CHtml::button('Accept', array('submit' => array('vacation/accept','id'=>$model->vacation_id)));
			echo CHtml::button('Decline', array('submit' => array('vacation/decline','id'=>$model->vacation_id)));		
		}
	}
	if($model->status==3)		//	request cancel from accept
	{
		echo '<span id="title acc"><strong>The vacation is accepted</strong></span>';
		 
		$tmp_date = date('m-d-Y');		
		$withdraw_date = CDateTimeParser::parse($tmp_date,'MM-dd-yyyy');
		$tmp_end_day = $model->end_day;
		 
		if(($model->user_id)==(Yii::app()->user->id) && ($tmp_end_day >= $withdraw_date))		//	dung nguoi
			echo CHtml::button('Request Cancel', array('submit' => array('vacation/request','id'=>$model->vacation_id)));
		 
	}	
	if($model->status==2)		//	cancel from request cancel
	{
		echo '<span id="title req"><strong>The vacation is requested to cancel</strong></span>';
		//if(($model->user->getUserRole(Yii::app()->user->id))<>"user")		//	co quyen admin/manager
		if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager'))		//	co quyen admin/manager		
			echo CHtml::button('Cancel', array('submit' => array('vacation/cancel','id'=>$model->vacation_id)));
	}
	
	if($model->status==5)		//	declined
	{
		echo '<span id="title dec"><strong>The vacation is declined</strong></span>';
	}	
	if($model->status==4)		//	cancelled
	{
		echo '<span id="title can"><strong>The vacation is cancelled</strong></span>';
	}			
		
	
?>
</h3>

</div>