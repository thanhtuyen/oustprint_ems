<?php
/* @var $this EmployeeController */
/* @var $model Employee */
/* @var $form CActiveForm */
?>

<!-- <div class="form">
 -->
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'employee-form',
  'type'=>'horizontal',
	'enableAjaxValidation'=>true,
  'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
	<div class="employee_avatar_update">
		<span class="img_avatar_update">
			<?php 
			if($model->avatar) {
				$imagestring = Yii::app()->request->baseUrl.'/media/images/thumbnails/'.$model->avatar;
			} else {
				$imagestring = Yii::app()->request->baseUrl.'/media/images/thumbnails/noAvatar.png';
			}
			echo CHtml::image($imagestring);

			if($model->cv) {
				$cv = Yii::app()->request->baseUrl.'/media/cv/has_cv.png';
			} else {
				$cv = Yii::app()->request->baseUrl.'/media/cv/no_cv.png';
			}
			echo CHtml::image($cv);
	
			?>
		</span>
	</div>


<p class="help-block">Fields with <span class="required">*</span> are required.</p>
	<div class="space5">
		<?php //echo $form->errorSummary($model); ?>

		<?php echo $form->fileFieldRow($model, 'avatar'); ?>
		<?php echo $form->fileFieldRow($model, 'cv'); ?>
		<?php echo $form->dropDownListRow($model,'job_title', $model->getJobTitleOption(),array('empty'=>"Please select Job Title", 'class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->dropDownListRow($model,'degree', $model->getDegreeOption(), array('empty'=>"Please select Type Degree", 'class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'degree_name',array('class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'background',array('class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'personal_email',array('class'=>'span3','maxlength'=>255)); ?>

    <?php echo $form->textFieldRow($model,'telephone',array('class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'mobile',array('class'=>'span3','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'homeaddress',array('class'=>'span4','maxlength'=>255)); ?>
		<?php echo $form->dropDownListRow($model,'department_id', $model->getDepartmentOption(),array('empty'=>"Please select Department", 'class'=>'span3','maxlength'=>255)); ?>
    <div class="div_white"></div>
		 <?php
		  $this->widget('bootstrap.widgets.TbTabs', array(
		    'type'=>'tabs', // 'tabs' or 'pills'
		    'tabs'=>array(
		      array('label'=>'Education', 'content'=> ''.$form->ckEditorRow($model, 'education', array('options'=>array('fullpage'=>'js:true', 'width'=>'600', 'resize_maxWidth'=>'600','resize_minWidth'=>'320'))).'', 'active'=>true),
		      array('label'=>'Skill', 'content'=> ''.$form->ckEditorRow($model, 'skill',  array('options'=>array('fullpage'=>'js:true', 'width'=>'600', 'resize_maxWidth'=>'600','resize_minWidth'=>'320'))).''),
		      array('label'=>'Experience', 'content'=>''.$form->ckEditorRow($model, 'experience', array('options'=>array('fullpage'=>'js:true', 'width'=>'600', 'resize_maxWidth'=>'600','resize_minWidth'=>'320'))).''),
		      array('label'=>'Notes', 'content'=>''.$form->ckEditorRow($model,'notes', array('options'=>array('fullpage'=>'js:true', 'width'=>'600', 'resize_maxWidth'=>'600','resize_minWidth'=>'320'))).'')
		    ),
		  ));
		  ?>

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
	            'url'=>'../../employee/admin',
	        ));
	    	}
	    	?>
		
		</div>
	</div>
<?php $this->endWidget(); ?>
	