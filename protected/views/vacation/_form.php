
<?php  
  $cs = Yii::app()->getClientScript();
 // $cs->registerScriptFile('/js/yourscript.js', CClientScript::POS_END);
  $cs->registerCssFile('/css/vacation.css');
?>
<?php
/* @var $this VacationController */
/* @var $model Vacation */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'vacation-form',
  	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>
<p class="help-block">Fields with <span class="required">*</span> are required.</p>
<p>Total remaining vation: <?php
  if($employee_vacation){
    echo $employee_vacation->remaining_vacation;
  } else {
    echo "12";
  }
 ?></p>
	<?php //echo $form->errorSummary($model); ?>
	<div class="space5">
		<?php 

			if($model->isNewRecord)
				echo app()->user->getState('fullName')." <span class=\"you\">YOU</span>"; 
			else
			{
				if(($model->user_id)==(app()->user->id))
					echo app()->user->getState('fullName')." <span class=\"you\">YOU</span>"; 
				else
					echo "You're editing the other's vacation";
			}
		?>
		<div class="control-group">
		Request_date:<span style="margin-left:20px;"><?php echo date('m-d-Y');?></span>
		</div>
		<div class="control-group">
	    	<?php if($model->isNewRecord):?>
		      	<?php echo $form->labelEx($model,'start_date', array('class'=> "control-label required")); ?>
		    	<div class="controls">
		      		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		              'model'=>$model,
		              'attribute'=>'start_date',
		              // additional javascript options for the date picker plugin
		              'options'=>array(
		                  'showAnim'=>'fold',
                      'dateFormat'=>'mm-dd-yy',
		                  'changeYear'=>'true',
		                  'changeMonth'=>'true',
		                  'yearRange'=>'c-100:c+100',

		              ),
		              'htmlOptions'=>array(
		                  'style'=>'height:20px;',
		                  'value' =>  date('m-d-Y'),
		              ),
		          	));
		      	  	?>
		      		<?php echo $form->error($model,'start_date'); ?>
		    	</div>
		   	<?php else: ?>
		    	<?php echo $form->labelEx($model,'start_date', array('class'=> "control-label required")); ?>
		    	<div class="controls">
		      		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		              'model'=>$model,
		              'attribute'=>'start_date',
		              // additional javascript options for the date picker plugin
		              'options'=>array(
		                  'showAnim'=>'fold',
                      'dateFormat'=>'mm-dd-yy',
		                  'changeYear'=>'true',
		                  'changeMonth'=>'true',
		                  'yearRange'=>'c-100:c+100'
		              ),
		              'htmlOptions'=>array(
		                  'style'=>'height:20px;',
		                  'value' => date('m-d-Y',$model->start_date),
		              ),
		          	));
		          	?>
		      		<?php echo $form->error($model,'start_date'); ?>
		    	</div>
		    <?php endif; ?>
	  	</div>

		<?php echo $form->radioButtonListInlineRow($model, 'time', array('am' => 'Morning', 'pm' => 'Afternoon')); ?>
    <?php echo $form->dropDownListRow($model,'type', Vacation::getReasonArr(),array(
      'empty' => array("Type"),
      'onchange' => CHtml::ajax(array(
          'type' => 'POST',
          'url' => CController::createUrl('Vacation/total'),
          'update' => '#'.CHtml::activeId($model, 'total'),
        )
      ),
    )); ?>
    <div style="margin-bottom: 10px; display: none" class="control_group add_note">
    <span style="margin-right: 20px">Medical Certificate</span>
      <?php echo $form->checkBox($model, 'medical_certificate'); ?>
    </div>


		<?php echo $form->dropDownListRow($model,'total',Vacation::gettotalsarr($model->type), array('class' => 'span2')); ?>
    <?php echo $form->dropDownListRow($model, 'approve_id', User::getListUserSearch(), array('class' => 'span2'));?>
		<?php echo $form->ckEditorRow($model, 'reason', array('class'=>'span3', 'type' => 'raw'));?>

		<div class="form-actions">
    	<?php $this->widget('bootstrap.widgets.TbButton', array(
    	'buttonType'=>'submit',
    	'type'=>'primary',
    	'label'=>$model->isNewRecord ? 'Create' : 'Save',
		));

    	if($model->isNewRecord){
        	$this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'reset',
            'htmlOptions'=>array('style'=>'margin-left: 10px;'),
            'label'=>'Reset',
        	));
    	} else {
        $this->widget('bootstrap.widgets.TbButton', array(
            //'buttonType'=>'link',
            'label'=>'Cancel',
            'htmlOptions'=>array('style'=>'margin-left: 10px;'),
            'url'=>'../../Vacation/Admin',
        ));
    	}
    	?>
	</div>
	</div>

<?php  $this->endWidget();?>
<script language="javascript">
  $(document).ready(function() {
    $("#Vacation_type").change(function(){
      if($(this).val() == 2) {
        $('.add_note').show();
      } else {
        $('.add_note').hide();
      }
    });
    $('#Vacation_type').trigger('change');
  });
</script>