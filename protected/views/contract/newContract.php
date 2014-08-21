
<?php if($model->isNewRecord): ?>
  <?php if(Yii::app()->user->getState('roles') == 'admin' || Yii::app()->user->getState('roles') == 'manager'): ?>

    <h3 class="title">

      <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'profile-form',
        'enableAjaxValidation'=>false,
      )); ?>
      <?php if($model->getFullNameActive()): ?>
        <h3 class="title" style="font-size: 15px;text-align: center">
         <?php  echo "Please specify user to create contract";?>
         <?php echo $form->dropDownList($model,'employee_id', $model->getFullNameActive());?>
         <span style="padding-top: 0px;">
           <?php echo CHtml::button('Choose', array('submit' => array('contract/newContract'))); ?>
<!--           --><?php // echo CHtml::submitButton('Choose');?><!--</span>-->

        </h3>

      <?php else: ?>
        <?php $link = Yii::app()->createUrl('user/create'); ?>
        <?php echo "Please "; ?>
        <?php echo "<a href=\"".$link."\">Create New Users</a>"; ?>
        <?php echo " before create profile for them"; ?>
      <?php endif; ?>
      <?php $this->endWidget(); ?>


    </h3>

  <?php endif; ?>
<?php endif; ?>

