<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vacation-form',
	'enableAjaxValidation'=>false,	
)); ?>
<?php date_default_timezone_set('Asia/Saigon'); ?> 

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php
			if($model->isNewRecord)
				echo $user->getUserFullName()." <span class=\"you\">YOU</span>"; 
			else
			{
				if(($model->user_id)==($user->user_id))
					echo $user->getUserFullName()." <span class=\"you\">YOU</span>"; 
				else
					echo "You're editing the other's vacation";
			}
		?>
		<?php //echo $form->error($model,'user_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'request_day'); ?>
		<?php //echo $form->textField($model,'request_day'); ?>
		<?php echo ($model->isNewRecord ? date('m-d-Y') : date('m-d-Y', $model->request_day)); ?>
		<?php
			/*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'attribute'=>'request_day',
			    // additional javascript options for the date picker plugin
			    'options'=>array(
			        'showAnim'=>'false',
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'dateFormat'=>'mm-dd-yy',
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;',
			    	'value'=>($model->isNewRecord ? date('m-d-Y') : date('m-d-Y', $model->request_day)),						
					'readonly'=>'readonly'
			    ),
			)); 
		*/?>
		<?php echo $form->error($model,'request_day'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'start_day'); ?>
		<?php //echo $form->textField($model,'start_day'); ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'attribute'=>'start_day',
			    // additional javascript options for the date picker plugin
			    'options'=>array(
			        'showAnim'=>'fold',
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'dateFormat'=>'mm-dd-yy',
			        'yearRange'=>'c-1:c+1', 
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;',
			    	'value'=>($model->isNewRecord ? date('m-d-Y') : date('m-d-Y', $model->start_day)),
			    ),
			)); 
		?>
		<?php echo $form->error($model,'start_day'); ?>
		
	</div>
	
	<div class="row">
        <?php echo $form->labelEx($model, 'time'); ?>
 		<br>
            <div class="compactRadioGroup">
            <?php
                echo $form->radioButtonList($model, 'time',
                    array(  
                            'am' => 'Morning',
                            'pm' => 'Afternoon' ) );
            ?>
            </div>
            <?php echo $form->error($model, 'time'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->dropDownList($model,'reason', Vacation::getReasonArr(),array(
			'empty' => array("Type"),
			'onchange' => CHtml::ajax(array(
                    'type' => 'POST',
                    'url' => CController::createUrl('Vacation/total'),
                    'update' => '#'.CHtml::activeId($model, 'total'),
				)
			),
		)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>
   
	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo $form->dropDownList($model,'total',Vacation::gettotalsarr($model->reason)); ?>
		<?php echo $form->error($model,'total'); ?>
	</div>

<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'end_day'); ?>
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
                    'yearRange'=>'c-1:c+1' 
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;',
			    	'value'=>($model->isNewRecord ? '' : date('m-d-Y', $model->end_day)),
			    ),
			)); 
		?>
		<?php echo $form->error($model,'end_day'); ?>
	</div>
*/ ?>

	<div style="clear:left; float: left;">
		<?php echo $form->labelEx($model,'more_reason'); ?>
	</div>
	<div style="clear:left; float: left; margin-left: 200px;" class="row">
		<?php 
			$this->widget('application.extensions.ckkceditor.editor.CKkceditor',
				array(
					"model"=>$model,                # Data-Model
					"attribute"=>'more_reason',         # Attribute in the Data-Model
					"height"=>'200px', 
					"config"=>array(
						//'toolbar' => 'Basic', 
						'toolbar' => array(
							//array('Styles','Format','Font','FontSize'),
							array('Bold','Italic','Underline','Strike','-','TextColor','BGColor'), 
							array('-','NumberedList','BulletedList'),
							array('-','Outdent','Indent','Blockquote'),
							array('-','Undo','Redo','-','Link','Unlink'),
							array('-','Table','SpecialChar',),
							array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
							array('-','Maximize',),
						),
						'format_p' => array(
							'element' => 'p',
							'attributes' => null,
						),
						'ignoreEmptyParagraph' => true,
						'font_style' => array(
							'element' => null,
						),
					
					),					
					"filespath"=>(!$model->isNewRecord)?Yii::app()->basePath."/../media/paquetes/"."more_reason"."/":"",
					"filesurl"=>(!$model->isNewRecord)?Yii::app()->baseUrl."/media/paquetes/"."more_reason"."/":"",
				)
			);
		?> 
		<?php echo $form->error($model,'more_reason'); ?>
	</div>
	
	 
	
	<div style="clear:left; float: left;" class="row buttons">
		<?php 
			if($model->isNewRecord)
			{
				echo CHtml::submitButton('Create');
		 		echo CHtml::resetButton('Reset');
			}
			else
			{
				echo CHtml::submitButton('Update');
			} 
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<!-- Javascript  check defaul  time in create vacation, (da fix in action create of vacationcontroller) 
<script type="text/javascript">
	$("#Vacation_time_0").attr("checked", "checked");
</script>
-->