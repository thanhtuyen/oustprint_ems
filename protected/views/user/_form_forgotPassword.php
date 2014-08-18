<div class="form">
<?php 
Yii::app()->clientScript->registerCoreScript('jquery');  
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/jquery.validate.min.js");
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=> array('class'=>'ajaxValid,form'),
)); ?>
	<?php //echo $form->errorSummary($model); ?>
	<fieldset>
		<legend>Forgot Password</legend>
		<?php if($model->status != 'success'):?>
		<dl>
			<dt>&nbsp;</dt>
			<dd>Fields with <span class="required">*</span> are required.</dd>
		</dl>	
		<dl>
			<dt><?php echo $form->labelEx($model,'user_email'); ?></dt>
			<dd><?php echo $form->textField($model,'user_email',array('size'=>32,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'user_email'); ?></dd>
		</dl>
		<?php endif; ?>
		<?php if($model->status === 'success'):?>
		<div class="msg success">An e-mail sent to your INBOX, please check your e-mail.</div>
		<?php endif; ?>
	</fieldset>
	<?php if($model->status != 'success'):?>
	<p class="ac">
		<?php echo CHtml::submitButton('Send',array('class'=>'submit')); ?>
	</p>
	<?php endif; ?>
	
<?php $this->endWidget(); ?>

</div><!-- form -->
