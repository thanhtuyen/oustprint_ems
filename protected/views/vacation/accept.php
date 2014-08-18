<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vacation-form',
	'enableAjaxValidation'=>false,	
)); ?>
 

	<?php //echo $form->errorSummary($model); ?>
	
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
	 
	<div style="clear:left; float: left; margin-left: 200px; width: 50%;" class="row"> 
		<?php echo $form->textField($model,'comment_one',array('style'=>'width:100%','placeholder'=>'Comment')); ?>
		<?php echo $form->error($model,'comment_one'); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::app()->controller->action->id : 'Submit'); ?>
	</div> 

<?php $this->endWidget(); ?>

</div><!-- form -->