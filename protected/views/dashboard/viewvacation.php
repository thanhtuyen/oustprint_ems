<?php

?>
<?php //date_default_timezone_set('Asia/Saigon'); ?><!-- -->
<div style="width: 500px;">
<h3>
<?php 
	if($model->getdaysnumber()>1)
		echo '<sub>'.$model->getdaysnumber().' days</sub> ';
	if($model->getdaysnumber()<=1)
		echo '<sub>'.$model->total.' day</sub> ';
?>
<?php echo $model->getReasonName(); ?>
<?php echo ' <sup><i>'.$model->user->user_full_name.'</i></sup>'; ?>
<?php echo ' <sub>from '.date("H",$model->start_day)."h".date("i",$model->start_day)." ".date("D",$model->start_day).' '.$model->getStartDay().'  '.' to '.date("H",$model->end_day)."h".date("i",$model->end_day)." ".date("D",$model->end_day).' '.$model->getEndDay().'</sub>'; ?>
</h3>

<?php if($model->status==2 || $model->status==3 || $model->status==4 || $model->status==5) :?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'more_reason',
			'type'=>'raw',
		     'value'=>$model->getMoreReason(), 
		),
		array(
			'label'=>'Comment',
			'type'=>'raw',
			'value'=>($model->status==2)? $model->comment_two : $model->comment_one, 
		),
	),
)); ?>

<?php elseif($model->status==1) :?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'more_reason',
			'type'=>'raw',
		     'value'=>$model->getMoreReason(), 
		),
	),
)); ?>
 

<?php endif;?>

<div class="request_vacation">
<?php 
	if($model->status==1)		//	new vacation awaiting
	{
		echo '<p class="msg fair-game"><strong>The vacation is awaiting</strong></p>';
		if(($model->user_id)==(Yii::app()->user->id))		//	dung nguoi
		{
			echo CHtml::button('Widthdraw', array('submit' => array('vacation/withdraw','id'=>$model->vacation_id,'view'=>"quick")));
		}
		//print_r($model->user->getUserRole(Yii::app()->user->id));exit;
		//if(($model->user->getUserRole(Yii::app()->user->id))<>"user")		//	co quyen admin/manager
		if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager'))		//	co quyen admin/manager
		{
			echo CHtml::button('Accept', array('submit' => array('vacation/accept','id'=>$model->vacation_id,'view'=>"quick")));
			echo CHtml::button('Decline', array('submit' => array('vacation/decline','id'=>$model->vacation_id,'view'=>"quick")));		
		}
	}
	if($model->status==3)		//	request cancel from accept
	{
		echo '<p class="msg acc"><strong>The vacation is accepted</strong></p>';
		 
		$tmp_date = date('m-d-Y');		
		$withdraw_date = CDateTimeParser::parse($tmp_date,'MM-dd-yyyy');
		$tmp_end_day = $model->end_day;
		 
		if(($model->user_id)==(Yii::app()->user->id) && ($tmp_end_day >= $withdraw_date))		//	dung nguoi
			echo CHtml::button('Request Cancel', array('submit' => array('vacation/request','id'=>$model->vacation_id,'view'=>"quick")));
		 
	}	
	if($model->status==2)		//	cancel from request cancel
	{
		echo '<p class="msg awa"><strong>The vacation is requested to cancel</strong></p>';
		//if(($model->user->getUserRole(Yii::app()->user->id))<>"user")		//	co quyen admin/manager
		if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager'))		//	co quyen admin/manager		
			echo CHtml::button('Cancel', array('submit' => array('vacation/cancel','id'=>$model->vacation_id,'view'=>"quick")));
	}
	if($model->status==5)		//	declined
	{
		echo '<p class="msg rej"><strong>The vacation is declined</strong></p>';
	}	
	if($model->status==4)		//	cancelled
	{
		echo '<p class="msg rej"><strong>The vacation is cancelled</strong></p>';
	}			
		
	
?>
</div>
</div>