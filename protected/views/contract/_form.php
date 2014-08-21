<style>
   label.control-label {
    width: 150px !important;
  }
  .helper_info{
    margin-left: 400px;
    margin-top: 5px;;
    position: fixed;
    z-index:-1;

  }
</style>
<button style="float: right; margin-right: 5px;"><a target="_blank" href="<?php print Yii::app()->createUrl('/contract/calculate');?>">caculator salary</a></button>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'contract-form',
  'type'=>'horizontal',
  //'enableAjaxValidation'=>true,
  'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php //echo $form->errorSummary($model); ?>
<?php //echo $form->errorSummary($modelContractSalary); ?>
<p class="help-block">Fields with <span class="required">*</span> are required.</p>
  <div class="space5">
    <?php echo $form->dropDownListRow($model,'type', $model->getListType(), array('empty'=>"Please select Type Contract", 'class'=>'span3','maxlength'=>255)); ?>
    <div class="control-group probation" >
      <?php echo $form->labelEx($model,'probation_start_date', array('class'=> "control-label")); ?>
      <div class="controls">
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
          'model'=>$model,
          'attribute'=>'probation_start_date',
          // additional javascript options for the date picker plugin
          'options'=>array(
            'showAnim'=>'fold',
            'dateFormat'=>'M-dd-yy',
            'changeYear'=>'true',
            'changeMonth'=>'true',
            'yearRange'=>'c-100:c+100'
          ),
          'htmlOptions'=>array(
            'style'=>'height:20px;',
            'value' => '',
          ),
        ));
        ?>
        <?php echo $form->error($model,'probation_start_date'); ?>
      </div>
    </div>
      <i><span class="helper_info contract" >(month)s</span></i>
    <div class="control-group probation" >
      <?php echo $form->textFieldRow($model,'probation_length', array('class'=> "span3")); ?>

    </div>

    <div class="control-group contract" >
      <?php echo $form->labelEx($model,'contract_start_date', array('class'=> "control-label required")); ?>
      <div class="controls">
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
          'model'=>$model,
          'attribute'=>'contract_start_date',
          // additional javascript options for the date picker plugin
          'options'=>array(
            'showAnim'=>'fold',
            'dateFormat'=>'M-dd-yy',
            'changeYear'=>'true',
            'changeMonth'=>'true',
            'yearRange'=>'c-100:c+100'
          ),
          'htmlOptions'=>array(
            'style'=>'height:20px;',
            'value' => '',
          ),
        ));
        ?>
        <?php echo $form->error($model,'contract_start_date'); ?>
      </div>
    </div>
    <i><span class="helper_info contract" >(month)s</span></i>
    <div class="control-group contract" >
      <?php echo $form->textFieldRow($model,'contract_length',array('class'=>'span3','maxlength'=>255)); ?>
    </div>
    <i><span class="helper_info">VND</span></i>
    <div class="control-group">
      <?php echo $form->textFieldRow($modelContractSalary,'gross_salary',array('class'=>'span3','maxlength'=>255)); ?>
    </div>
    <i><span class="helper_info">VND</span></i>
    <div class="control-group">
      <?php echo $form->textFieldRow($modelContractSalary,'net_salary',array('class'=>'span3','maxlength'=>255)); ?>
    </div>
    <i><span class="helper_info">VND</span></i>
    <div class="control-group">
      <?php echo $form->textFieldRow($modelContractSalary,'petrol_allowance',array('class'=>'span3','maxlength'=>255)); ?>
    </div>
    <i><span class="helper_info">VND</span></i>
    <div class="control-group">
      <?php echo $form->textFieldRow($modelContractSalary,'lunch_allowance',array('class'=>'span3','maxlength'=>255)); ?>
    </div>
    <i><span class="helper_info">VND</span></i>
    <div class="control-group">
      <?php echo $form->textFieldRow($modelContractSalary,'other_allowance',array('class'=>'span3','maxlength'=>255)); ?>
    </div>
    <div class="form-actions">
      <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? 'Create' : 'Save',
      ));


      $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'reset',
        'htmlOptions'=>array('style'=>'margin-left: 10px;'),
        'label'=>'Reset',
      ));

      ?>
    </div>
  </div>
<?php $this->endWidget();?>