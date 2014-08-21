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
	
	<?php if($_GET['status'] != 'changedPassword'):?>
	
	<fieldset style="margin: 0 auto; width: 50%;  padding: 20px; border-top: 0;">

		<?php if(Yii::app()->user->hasFlash('wrongPassword')): ?>
    <h3 class="warn_info">
			<?php echo Yii::app()->user->getFlash('wrongPassword'); ?>
    </h3>
		<?php endif; ?>

		<?php if(Yii::app()->user->hasFlash('changedPassword')):?>
      <h3 class="yes_info">
			  <?php echo Yii::app()->user->getFlash('changedPassword');?>
      </h3>
    <?php endif; ?>

		<h3 class="title">Change User Password</h3>

		<div class="" style="clear:both;float: left;">
			<span class="mod_title" style="float: left;">
				[<?php echo $model->email; ?>]
				<?php echo $model->getFullName(); ?>
			</span>
		</div>
		<div class="" style="clear:both;float: left;">&nbsp;</div>

		<div class="" style="clear:both;float: left;">
			<span class="mod_title" style="float: left;">
				<?php echo $form->passwordField($model,'old_password',array('placeholder'=>'Old Password')); ?>
			</span>
			<span class="help_inline" style="float: left;">
				<?php echo $form->error($model,'old_password'); ?>
			</span>
		</div>

		<div class="" style="clear:both;float: left;">
			<span class="mod_title" style="float: left;">
				<?php echo $form->passwordField($model,'password',array('placeholder'=>'New Password','value'=>'')); ?>
			</span>
			<span class="help_inline" style="float: left;">
				<?php echo $form->error($model,'password'); ?>
			</span>
		</div>

		<div class="" style="clear:both;float: left;">
			<span class="mod_title" style="float: left;">
				<?php echo $form->passwordField($model,'password_repeat',array('placeholder'=>'Confirm Password')); ?>
			</span>
			<span class="help_inline" style="float: left;">
				<?php echo $form->error($model,'password_repeat'); ?>
			</span>
		</div>

		<div class="" style="clear:both; ">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'submit')); ?>
		</div>

	</fieldset>

	<?php endif; ?>

	<?php if($_GET['status'] === 'changedPassword'):?>
		<label>Your new password is saved</label>
	<?php endif; ?>
	
<?php $this->endWidget(); ?>

<!-- form -->
<script type="text/javascript">
$().ready(function() {
	// validate signup form on keyup and submit
	$("#user-form").validate({
		rules: {
			'User[password]': {
				required: true
			},
			'User[old_password]': {
                required: true
            },
			'User[password_repeat]': {
				required: true,
				equalTo: "#User_password"
			}
		}
	});
	
});
</script>