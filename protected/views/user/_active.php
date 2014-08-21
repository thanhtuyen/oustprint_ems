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
  <h3 class="title">Active user</h3>




  <div class="" style="clear:both;float: left; text-align: center; width: 100%;">
    [<?php echo $model->fullName; ?>]

  </div>

  <div class="" style="clear:both;float: left; text-align: center; width: 100%;">
    <?php echo $model->email; ?>
  </div>

  <div class="" style="clear:both;float: left; text-align: center; width: 100%;">
    <?php echo $model->fullName; ?>
  </div>

  <input type="hidden" name="Active" value="true"/>

  <div class="" style="clear:both; float: right;">

    <?php
      echo CHtml::submitButton('Active',array('class'=>'submit'));

    ?>
  </div>

</fieldset>

<?php $this->endWidget(); ?>

<!-- form -->
