<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager')):?>
	<div class="row">  
		<?php echo $form->label($model,'user_id'); ?>
		<div class="ui-widget">
		<span  style="width:20px;"><?php echo $form->textField($model,'user_id'); ?></span>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="row">
		<?php echo $form->label($model,'request_day'); ?>
		<?php //echo $form->textField($model,'request_day'); ?>
		<?php echo $form->dropDownList($model,'re_month',$model->get_monthsearch()); ?>
		<?php echo $form->dropDownList($model,'re_day',$model->get_daysearch()); ?>
		<?php echo $form->dropDownList($model,'re_year',$model->getyearsearch()); ?>
		<?php /*
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'attribute'=>'request_day',
			    // additional javascript options for the date picker plugin
			    'options'=>array(
			        'showAnim'=>'fold',
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'dateFormat'=>'mm-dd-yy',
		            'yearRange'=>'c-100:c+100',
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;',
			    ),
			)); 
		*/?>
		<?php echo "<i class=\"help_info\">(mm-dd-yyyy)</i>"; ?>
	</div>	

	<div class="row">
		<?php echo $form->label($model,'start_day'); ?>
		<?php //echo $form->textField($model,'start_day'); ?>
		<?php echo $form->dropDownList($model,'st_month',$model->get_monthsearch()); ?>
		<?php echo $form->dropDownList($model,'st_day',$model->get_daysearch()); ?>
		<?php echo $form->dropDownList($model,'st_year',$model->getyearsearch()); ?>
		<?php /*
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'attribute'=>'start_day',
			    // additional javascript options for the date picker plugin
			    'options'=>array(
			        'showAnim'=>'fold',
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'dateFormat'=>'mm-dd-yy',
		            'yearRange'=>'c-100:c+100',
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;',
			    ),
			)); 
		*/?>
		<?php echo "<i class=\"help_info\">(mm-dd-yyyy)</i>"; ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reason'); ?>
		<?php //echo $form->textField($model,'reason',array('size'=>20,'maxlength'=>500)); ?>
		<?php echo $form->dropDownList($model,'reason', $model->getReasonSearchArr()); ?>	
	</div>

<?php /*
	<?php if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager')):?>
	<div class="row">
		<?php echo $form->label($model,'total'); ?>
		<?php echo $form->textField($model,'total'); ?>
		<?php echo "<i class=\"help_info\">(days)</i>"; ?>
	</div>
		
	<?php endif; ?>

*/?>
<?php /*	
	<div class="row">
		<?php echo $form->label($model,'end_day'); ?>
		<?php //echo $form->textField($model,'end_day'); ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'attribute'=>'end_day',
			    // additional javascript options for the date picker plugin
			    'options'=>array(
			        'showAnim'=>'fold',
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'dateFormat'=>'mm-dd-yy',
		            'yearRange'=>'c-100:c+100',
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;',
			    ),
			)); 
		?>
		<?php echo "<i class=\"help_info\">(mm-dd-yyyy)</i>"; ?>
	</div>
*/?>
<?php /*
	<?php if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager')):?>
	<div class="row">
		<?php echo $form->label($model,'more_reason'); ?>
		<?php echo $form->textField($model,'more_reason',array('size'=>60,'maxlength'=>1000)); ?>
	</div>
	
	<?php endif; ?>
	*/?>
	
	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php //echo $form->textField($model,'status',array('size'=>20,'maxlength'=>1000)); ?>
		<?php echo $form->dropDownList($model,'status', $model->getStatusArr()); ?>
		
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<script>
	$(function() {
		var availableUser = [          		
			<?php  $model->getListUserSearch(); ?>
		];
		
		$( "#Vacation_user_id" ).autocomplete({
			source: availableUser,
		});
				
	});
</script>
