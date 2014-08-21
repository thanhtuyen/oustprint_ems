<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="search_user">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'action'=>Yii::app()->createUrl($this->route),
	  	'type'=>'horizontal',
		'method'=>'get',
	)); ?>
		<div class="space5">
      <div class="control-group ">
        <label class="control-label required" for="User_email">
          Fullname
        </label>
        <div class="controls">
          <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
               'model'=> $model,
               'attribute' => 'fullname',
               'source'=> User::model()->getListUserSearch(),
               // additional javascript options for the autocomplete plugin
               'options'=>array(
                 'minLength'=>'2',
               ),
               'htmlOptions'=>array(
                 'style'=>'height:20px;',
               ),
            ));
           ?>
          </div>
      </div>
      <div class="control-group ">
        <label class="control-label required" for="User_email">
          Email
        </label>
        <div class="controls">
          <?php
          $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'model'=> $model,
            'attribute' => 'email',
            'source'=> User::model()->getListEmailSearch(),
            // additional javascript options for the autocomplete plugin
            'options'=>array(
              'minLength'=>'2',
            ),
            'htmlOptions'=>array(
              'style'=>'height:20px;',
            ),
          ));
          ?>
        </div>
      </div>
			<?php echo $form->dropDownListRow($model,'roles', $roles,array('empty'=>"Please select role", 'class'=>'span3','maxlength'=>255)) ; ?>

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

</div>
	<!-- <div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>255)); ?>
	</div> -->

	<!-- <div class="row">
		<?php echo $form->label($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fullname'); ?>
		<?php echo $form->textField($model,'fullname',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dob'); ?>
		<?php echo $form->textField($model,'dob'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'activkey'); ?>
		<?php echo $form->textField($model,'activkey',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lastvisit'); ?>
		<?php echo $form->textField($model,'lastvisit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'roles'); ?>
		<?php echo $form->textField($model,'roles'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div> -->

<!-- search-form -->