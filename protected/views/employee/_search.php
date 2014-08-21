<?php
/* @var $this EmployeeController */
/* @var $model Employee */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php
//  $form=$this->beginWidget('CActiveForm', array(
// 	'action'=>Yii::app()->createUrl($this->route),
// 	'method'=>'get',
// )); 
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
  	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<div class="space5">
		<?php echo $form->dropDownListRow($model,'job_title', $model->getJobTitleOption(),array('empty'=>"Please select Job Title", 'class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->dropDownListRow($model,'degree',$model->getDegreeOption(), array('empty'=>"Please select Type Degree",'class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'degree_name',array('class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'background',array('class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'telephone',array('class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->dropDownListRow($model,'department_id', $model->getDepartmentOption(),array('empty'=>"Please select Department", 'class'=>'span3','maxlength'=>255)); ?>
		
		<div class="form-actions">
	    	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    	'buttonType'=>'submit',
	    	'type'=>'primary',
	    	'label'=>'Search',
			));
			?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
	    	'buttonType'=>'reset',
	    	'type'=>'primary',
	    	'label'=>'Reset',
			));
			?>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->