
<?php //date_default_timezone_set('Asia/Saigon'); ?>
<div class="create_contract">
<?php
$this->breadcrumbs=array(
  'Contract'=>array('index'),
  $model->id,
);

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contract-form',
  'type'=>'horizontal',
	'enableAjaxValidation'=>false,	
)); ?>

	<h3 class="title">	
	<?php echo 'Stopping contract with: &nbsp;&nbsp;&nbsp;'.$model->employee->user->fullname; ?>
	</h3>
	
<!--	--><?php //echo '<br><b>From:</b> '.date('M-d-Y',$user->user_official_start_date)."&nbsp;(<b>".$user->user_official_contract_length." months</b>)"; ?>
<!--	--><?php //echo $form->labelEx($model,'Contract Within &nbsp;',array('style'=>'text-align: right; line-height: 2.5em;')); ?><!-- -->
<!--	--><?php //echo '<br><b>To:</b> &nbsp;&nbsp;&nbsp;&nbsp;'.date('M-d-Y',$user->contract_end_date); ?>
	
	
	<div  class="control-group">
    <?php echo $form->labelEx($model,'Stop Contract On:',array('class'=> "control-label")); ?>
    <div class="controls">
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model'=>$model,
        'attribute'=>'contract_stop_date',
        // additional javascript options for the date picker plugin
        'options'=>array(
            'showAnim'=>'fold',
            'dateFormat'=>'mm-dd-yy',
            'changeYear'=>'true',
            'changeMonth'=>'true',
            'yearRange'=>'c-1:c+2'
        ),
        'htmlOptions'=>array(
            'style'=>'height:20px; width: 85px;  background: gold;',
            'value'=>date('m-d-Y'),
        ),
      )); ?>
		  <?php echo "<i class=\"help_info\"> (mm-dd-yyyy)</i>"; ?>
      <?php echo $form->error($model,'contract_stop_date',array('style'=>'margin-left: 200px;')); ?>
    </div>
  </div>
<!--	<div style="clear:left; float: left; margin-left: 10px; width: 90%;" class="row">-->
<!--		--><?php //echo $form->textField($model,'contract_stop_reason',array('style'=>'width:90%','placeholder'=>'Comment')); ?><!-- </br>-->
    <?php echo $form->textField($model,'contract_stop_reason',array('class'=> 'input_comment','placeholder'=>'Contract Stop Reason')); ?>
	  </br>
  <p style="text-align: center; margin-top: 20px">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
      'buttonType'=>'submit',
      'type'=>'primary',
      'label'=> 'Save',

    ));
    $this->widget('bootstrap.widgets.TbButton', array(
      //'buttonType'=>'link',
      'label'=>'Cancel',
      'htmlOptions'=>array('style'=>'margin-left: 10px;'),
      'url'=>'../../Contract/',
    ));
    ?>
  </p>
<?php $this->endWidget(); ?>
</br>
</br>
</div><!-- form -->