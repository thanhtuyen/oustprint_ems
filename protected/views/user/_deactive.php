<?php 
Yii::app()->clientScript->registerCoreScript('jquery');   
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/jquery.validate.min.js");
?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-form',
		'enableAjaxValidation'=>true,
		'htmlOptions'=> array('class'=>'ajaxValid,form'),
		
	)); ?>
	
		<fieldset style="margin: 0 auto; width: 250px; border-radius: 4px; border: solid thick whiteSmoke; padding: 20px; border-top: 0;">
		<h3 class="title">Deactive user</h3>
		
		
		<?php if($model->profile!=null): ?> 
			<h3 class="yes_info" style="padding: 4px;"> 
				<?php echo "User is "; ?>
				<?php echo ($model->profile->user_status==0)?'Working':'Non working'; ?>
			</h3>  
		<?php endif; ?>	
		
		<div class="" style="clear:both;float: left; text-align: center; width: 100%;"> 		 
				[<?php echo $model->user_username; ?>]	 
				<?php echo $model->user_first_name." ".$model->user_last_name; ?>	
		</div>
		
		<div class="" style="clear:both;float: left; text-align: center; width: 100%;"> 
				<?php echo $model->user_email; ?>
		</div>
		
		<div class="" style="clear:both;float: left; text-align: center; width: 100%;"> 
				<?php echo $model->user_full_name; ?>	
		</div>
		
		<input type="hidden" name="Deactive" value="true"/>
		
		<div class="" style="clear:both; float: right;">
			<?php echo CHtml::submitButton('Deactive',array('class'=>'submit')); ?>
		</div> 	 		
	
	</fieldset>
	
	<?php $this->endWidget(); ?>
	
<!-- form -->
