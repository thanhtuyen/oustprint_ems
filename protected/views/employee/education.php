<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'user-form',
    'type'=>'horizontal',
    'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->ckEditorRow($model, 'education', array('fullpage'=>'js:true', 'width'=>'600', 'resize_maxWidth'=>'600','resize_minWidth'=>'320'));?>
<?php  $this->endWidget();?>