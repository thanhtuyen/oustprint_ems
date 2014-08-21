<div class="wide form">
<?php date_default_timezone_set('UTC'); ?>
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
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
          'attribute' => 'employee',
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

    <div class="control-group">
      <?php echo $form->label($model,'contract_start_date', array('class'=>"control-label", 'style'=> "width:100px")); ?>
      <div class="controls">
        <?php echo $form->dropDownList($model,'s_month',$model->get_monthsearch(), array('class' => 'month_span')); ?>
        <?php echo $form->dropDownList($model,'s_day',$model->get_daysearch(), array('class' => 'day_span')); ?>
        <?php echo $form->dropDownList($model,'s_year',$model->getyearsearch(), array('class' => 'year_span')); ?>

        <?php echo "<i class=\"help_info\">(mm-dd-yyyy)</i>"; ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo $form->label($model,'contract_length', array('class'=>"control-label", 'style'=> "width:100px")); ?>
      <div class="controls">
      <?php echo $form->textField($model,'contract_length',array('class'=>'span3','maxlength'=>255)); ?>
      <?php echo "<i class=\"help_info\">month(s)</i>"; ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo $form->label($model,'contract_end_date', array('class'=>"control-label", 'style'=> "width:100px")); ?>
      <div class="controls">
        <?php echo $form->dropDownList($model,'e_month',$model->get_monthsearch(), array('class' => 'month_span')); ?>
        <?php echo $form->dropDownList($model,'e_day',$model->get_daysearch(), array('class' => 'day_span')); ?>
        <?php echo $form->dropDownList($model,'e_year',$model->getyearsearch(), array('class' => 'year_span')); ?>

        <?php echo "<i class=\"help_info\">(mm-dd-yyyy)</i>"; ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo $form->label($model,'contract_stop_date', array('class'=>"control-label", 'style'=> "width:100px")); ?>
      <div class="controls">
        <?php echo $form->dropDownList($model,'st_month',$model->get_monthsearch(), array('class' => 'month_span')); ?>
        <?php echo $form->dropDownList($model,'st_day',$model->get_daysearch(), array('class' => 'day_span')); ?>
        <?php echo $form->dropDownList($model,'st_year',$model->getyearsearch(), array('class' => 'year_span')); ?>

        <?php echo "<i class=\"help_info\">(mm-dd-yyyy)</i>"; ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo $form->label($model,'contract_status', array('class'=>"control-label", 'style'=> "width:100px")); ?>
      <div class="controls">
        <?php echo  $form->dropDownList($model,'contract_status',$model->getStatusArr()); ?>
      </div>
    </div>

<!--    <div class="control-group ">-->
<!--      <label class="control-label required" for="User_email">-->
<!--        Fullname-->
<!--      </label>-->
<!--      <div class="controls">-->
<!--        --><?php
//        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
//          'model'=> $model,
//          'attribute' => 'created_id',
//          'source'=> User::model()->getListUserSearch(),
//          // additional javascript options for the autocomplete plugin
//          'options'=>array(
//            'minLength'=>'2',
//          ),
//          'htmlOptions'=>array(
//            'style'=>'height:20px;',
//          ),
//        ));
//        ?>
<!--      </div>-->
<!--    </div>-->

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
