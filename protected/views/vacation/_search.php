
<?php
/* @var $this VacationController */
/* @var $model Vacation */
/* @var $form CActiveForm */
?>

<div class="search_user">
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'type'=>'horizontal',
    'method'=>'get',
  )); ?>
<!--  --><?php //echo Yii::app()->createUrl($this->route);?>
  <div class="space5">
    <div class="control-group ">
      <label class="control-label required" for="User_email" style="width:100px">
        Fullname
      </label>
      <div class="controls">
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
          'model'=> $model,
          'attribute' => 'user_id',
          'source'=> User::model()->getListUserSearchVacation(),
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
    <div class="control-group">
      <?php echo $form->label($model,'request_day', array('class'=>"control-label", 'style'=> "width:100px")); ?>
      <div class="controls">
        <?php echo $form->dropDownList($model,'re_month',$model->get_monthsearch(), array('class' => 'month_span')); ?>
        <?php echo $form->dropDownList($model,'re_day',$model->get_daysearch(), array('class' => 'day_span')); ?>
        <?php echo $form->dropDownList($model,'re_year',$model->getyearsearch(), array('class' => 'year_span')); ?>

        <?php echo "<i class=\"help_info\">(mm-dd-yyyy)</i>"; ?>
      </div>
    </div>

    <div class="control-group">
      <?php echo $form->label($model,'start_day', array('class'=>"control-label", 'style'=> "width:100px")); ?>
      <div class="controls">
        <?php echo $form->dropDownList($model,'st_month',$model->get_monthsearch(), array('class' => 'month_span')); ?>
        <?php echo $form->dropDownList($model,'st_day',$model->get_daysearch(), array('class' => 'day_span')); ?>
        <?php echo $form->dropDownList($model,'st_year',$model->getyearsearch(), array('class' => 'year_span')); ?>
        <?php echo "<i class=\"help_info\">(mm-dd-yyyy)</i>"; ?>
      </div>
    </div>

    <div class="control-group">
      <?php echo $form->label($model,'type', array('class'=>"control-label",  'style'=> "width:100px")); ?>
      <div class="controls">
        <?php echo $form->dropDownList($model,'type', $model->getReasonSearchArr()); ?>
      </div>
    </div>


<!--    --><?php //echo $form->textFieldRow($model,'email',array('class'=>'span3','maxlength'=>255)); ?>
<!--    --><?php //echo $form->dropDownListRow($model,'roles', $roles,array('empty'=>"Please select role", 'class'=>'span3','maxlength'=>255)) ; ?>

    <div class="form-actions" style="margin-left: 70px">
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

