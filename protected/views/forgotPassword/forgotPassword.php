<div class="form" style="padding-top: 100px; width: 500px;margin-left: 150px">
  <?php
  Yii::app()->clientScript->registerCoreScript('jquery');
  Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/jquery.validate.min.js");
  ?>
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'user-form',
    'type'=>'horizontal',
    'enableAjaxValidation'=>false,
    'htmlOptions'=> array('class'=>'ajaxValid,form'),
  )); ?>
  <?php //echo $form->errorSummary($model); ?>


  <fieldset>
    <legend style="border-bottom: 0px solid #e5e5e5;">Forgot Password</legend>
    <?php
    if(app()->user->hasFlash('error'))
      echo app()->user->getFlash('error');
    ?>
    <?php if($model->status != 'success'):?>
      <dl>
        <dt>&nbsp;</dt>
        <dd>Fields with <span class="required">*</span> are required.</dd>
      </dl>
      <dl>
        <dt><?php echo $form->labelEx($model,'email'); ?></dt>
        <dd><?php echo $form->textField($model,'email',array('size'=>32,'maxlength'=>255)); ?>
          <?php echo $form->error($model,'email'); ?></dd>
      </dl>
    <?php endif; ?>
    <?php if($model->status === 'success'):?>
      <div class="msg success">An e-mail sent to your INBOX, please check your e-mail.</div>
    <?php endif; ?>

  <?php if($model->status != 'success'):?>
    <p class="ac">
      <?php echo CHtml::submitButton('Send',array('class'=>'submit')); ?>
    </p>
  <?php endif; ?>
  </fieldset>
  <?php $this->endWidget(); ?>

</div><!-- form -->
