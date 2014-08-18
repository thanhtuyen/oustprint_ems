<?php 
Yii::app()->clientScript->registerCoreScript('jquery');  
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/jquery.validate.min.js");
?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-form',
		'enableAjaxValidation'=>true,
		'htmlOptions'=> array('class'=>'ajaxValid,form'),
		
	)); ?>
	<fieldset style="margin: 0 auto; width: 470px; border-radius: 4px; border: solid thick whiteSmoke; padding: 20px; border-top: 0;">
		 
		<?php if($model->isNewRecord):?>  
			<div class="" style="clear:both;float: left;"> 
				<span class="mod_title" style="float: left;"> 
					<?php echo $form->textField($model,'user_username',array('style'=>'width:100%','placeholder'=>'Username')); ?>
				</span>
				<span class="help_inline" style="float: left;">
					<?php echo $form->error($model,'user_username'); ?>
				</span>
			</div>
		
		<?php else:?>  
			<div class="" style="clear:both;float: left;">  
				<span class="mod_title"> 
					<?php echo $model->user_username; ?>
				</span>
			</div>		
		<?php endif; ?>
		
			
			<div class="" style="clear:both;float: left;"> 
				<span class="mod_title" style="float: left;"> 
					<?php echo $form->textField($model,'user_first_name',array('style'=>'width:100%','placeholder'=>'First Name')); ?>
				</span>
				<span class="help_inline" style="float: left;">
					<?php echo $form->error($model,'user_first_name'); ?>
				</span>
			</div>
			
			<div class="" style="clear:both;float: left;"> 
				<span class="mod_title" style="float: left;"> 
					<?php echo $form->textField($model,'user_last_name',array('style'=>'width:100%','placeholder'=>'Last Name')); ?>
				</span>
				<span class="help_inline" style="float: left;">
					<?php echo $form->error($model,'user_last_name'); ?>
				</span>
			</div>
			
			
			<div class="" style="clear:both; float: left;"> 
				<span class="mod_title" style="float: left;"> 
					<?php echo $form->textField($model,'user_full_name',array('style'=>'width:100%','placeholder'=>'Full Name')); ?>
				</span>
				<span class="help_inline" style="float: left;">
					<?php echo $form->error($model,'user_full_name'); ?>
				</span>
			</div>
			
			<div class="" style="clear:both; float: left;"> 
				<span class="mod_title" style="float: left;"> 
					<?php echo $form->textField($model,'user_email',array('style'=>'width:100%','placeholder'=>'Email')); ?>
				</span>
				<span class="help_inline" style="float: left;">
					<?php echo $form->error($model,'user_email'); ?>
				</span>
			</div>
			
	
		 <?php if($model->isNewRecord):?>		
			<div class="" style="clear:both; float: left;"> 
				<span class="mod_title" style="float: left;">
					<?php echo $form->passwordField($model,'user_password',array('style'=>'width:100%','placeholder'=>'Password', 'value'=>'')); ?>
				</span>
				<span class="help_inline" style="float: left;">
					<?php echo $form->error($model,'user_password'); ?>
				</span>
			</div>
			<div class="" style="clear:both; float: left;"> 
				<span class="mod_title" style="float: left;">
					<?php echo $form->passwordField($model,'user_password_repeat',array('style'=>'width:100%','placeholder'=>'Repeat Password')); ?>
				</span>
				<span class="help_inline" style="float: left;">
					<?php echo $form->error($model,'user_password_repeat'); ?>
				</span>
			</div>			
		<?php endif;?>
		
			<div class="" style="clear:both; float: left;">
				<h3 id="help_title" style="float: left; padding: 2px 6px; border-radius: 4px; border: solid thin whiteSmoke; background: whiteSmoke; color: #99999B;">
					<?php //echo $form->error($model,'user_role'); ?>
					<?php echo "ROLE"; ?>
				</h3>
				<span class="mod_title" style="float: left;"> 
					<?php echo $form->dropDownList($model,'user_role',$roles); ?>	
				</span>
			</div>
		 	
		<div class="" style="clear:both; float: right;">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'submit')); ?>
		</div>
			
	</fieldset>
	
	<?php $this->endWidget(); ?>
	
<!-- form -->
<script type="text/javascript">
$().ready(function() {
	// validate signup form on keyup and submit
	$("#user-form").validate({
		rules: {
			'User[user_password_repeat]': {
				
			}
		}
	});
	
});
</script>