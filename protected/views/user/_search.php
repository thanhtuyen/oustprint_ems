<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<fieldset>
	<legend>User filter</legend>
	<dl>
		<dt><?php echo $form->label($model,'user_role'); ?></dt>
		<dd><?php echo $form->dropdownList($model,'user_role',array_merge(array(''=>'- select role -'),$roles)); ?></dd>
	</dl>
	
	<dl>
		<dt><?php echo $form->label($model,'user_full_name'); ?></dt>
		<div class="ui-widget">
		<span  style="width:20px;"><?php echo $form->textField($model,'user_full_name'); ?></span>
		</div>
	</dl>
	<dl>
		<dt><?php //echo $form->label($model,'user_company'); ?></dt>
		<dd><?php //echo $form->dropdownList($model,'user_company',$company); ?></dd>
	</dl>
	<dl>
		<dt><?php echo $form->label($model,'user_email'); ?></dt>
		<dd><?php echo $form->textField($model,'user_email',array('size'=>60,'maxlength'=>255)); ?></dd>
	</dl>
</fieldset>
	<p class="ac">
		<?php echo CHtml::submitButton('Search',array('class'=>'submit')); ?>
	</p>

<?php $this->endWidget(); ?>

<!-- search-form -->
<script>
	$(function() {
		var availableUser = [          		
			<?php  $model->getListUserSearch(); ?>
		];
		
		$( "#User_user_full_name" ).autocomplete({
			source: availableUser,
		});
				
	});
</script>