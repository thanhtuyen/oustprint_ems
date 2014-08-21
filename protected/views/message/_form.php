<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'message-form',
  'type'=>'horizontal',
  'enableAjaxValidation'=>true,
  'htmlOptions' => array('enctype' => 'multipart/form-data'),
));?>
<?php //echo $form->errorSummary($model); ?>
<?php echo app()->user->getState('fullName');?>[<em><?php echo ($model->isNewRecord ? date('d-M-Y') : date('d-M-Y', $model->created_date)); ?></em>]
  <div class="select_type">
    <?php
    echo $form->dropDownList($model, 'types', $model->listTypes(), array('class' => 'span_select'));
    echo $form->dropDownList($model,'status', $model->getStatusArr(),array('class' => 'span_select',
      //'empty' => array(""),
      'onchange' => CHtml::ajax(array(
          'type' => 'POST',
          'url' => CController::createUrl('Message/modUser'),
          'update' => '#'.CHtml::activeId($model, 'mod_user_id'),
        )
      ),
    ));
    echo 'To:';
    echo $form->dropDownList($model, 'mod_user_id', Message::getListUserSendMessage($model->status), array('class' => 'span_select_user'));?>
  </div>

  <?php echo $form->textField($model,'title',array('class'=> 'span5','maxlength'=>256, 'placeholder'=>'Title')); ?>
  <?php echo $form->ckEditorRow($model, 'message_info');?>
  <div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
      'buttonType'=>'submit',
      'type'=>'primary',
      'label'=>'Create',
    ));
    ?>
  </div>
<?php $this->endWidget()?>
