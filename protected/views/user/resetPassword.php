<div class="create_user">
  <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>false,
    'htmlOptions'=> array('class'=>'ajaxValid,form'),
  )); ?>
  <fieldset style="margin: 0 auto; width: 50%;  padding: 20px; border-top: 0;">
    <h3 class="title">Reset User Password</h3>
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
  <?php $this->endWidget(); ?>
</div>