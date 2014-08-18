<div class="form">
<?php 
Yii::app()->clientScript->registerCoreScript('jquery');   
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/jquery.validate.min.js");
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php //echo $form->errorSummary($model); ?>
	<fieldset>
		<legend>Reset User Password</legend>
		<dl>
			<dt>&nbsp;</dt>
			<dd>Fields with <span class="required">*</span> are required.</dd>
		</dl>
		<dl>
			<dt><label class="required" for="User_user_password">New Password <span class="required">*</span></label></dt>
			<dd><?php echo $form->passwordField($model,'user_password',array('size'=>32,'maxlength'=>40,'value'=>'')); ?>
			<?php echo $form->error($model,'user_password'); ?></dd>
		</dl>
		<dl>
			<dt><label class="required" for="User_user_password_repeat">Confirm Password <span class="required">*</span></label></dt>
			<dd><?php echo $form->passwordField($model,'user_password_repeat',array('size'=>32,'maxlength'=>40)); ?>
			<?php echo $form->error($model,'user_password_repeat'); ?>
			</dd>
		</dl>
		<?php if(!$model->status):?>
		<dl>
			<dt>&nbsp;</dt>
			<dd><div class="errorMessage">Your token is invalid, please input right token.</div> </dd>
		</dl>
		<?php endif; ?>
	</fieldset>
	<?php if($model->status):?>
	<p class="ac">
		<?php echo CHtml::submitButton('Save', array('class'=>'submit')); ?>
	</p>
	<?php endif; ?>
	
<?php $this->endWidget(); ?>

</div><!-- form -->
