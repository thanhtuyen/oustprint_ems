
<div class = "view_employee">

  <h3 class="title"><?php echo $model->employee->user->fullname;?></h3>
  <?php
  $this->breadcrumbs=array(
    'Contract'=>array('index'),
    $model->id,
  );
  $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(

      array('name' => 'Full name',
        'value' => $model->employee->user->fullname),

      array('name' => 'Birthday',
        'value' => date('M/d/Y',$model->employee->user->dob)),

      array('name' => 'probation_start_date',
        'value' => $model->probation_start_date? date('M/d/Y',$model->probation_start_date):""),

      array('name' => 'probation_end_date',
        'value' => $model->probation_end_date ? date('M/d/Y',$model->probation_end_date):""),

      array('name' => 'contract_start_date',
        'value' => $model->contract_start_date ? date('M/d/Y',$model->contract_start_date):""),

      array('name' => 'contract_end_date',
        'value' => $model->contract_end_date ? date('M/d/Y',$model->contract_end_date):""),

      array('name'=> 'gross_salary',
        'value' => number_format($model->contract_salary->gross_salary).'  VND',),

      array('name'=> 'net_salary',
        'value' => number_format($model->contract_salary->net_salary).'  VND'),

      array('name'=> 'petrol_allowance',
        'value' => $model->contract_salary->petrol_allowance? number_format($model->contract_salary->petrol_allowance).'    VND':""),

      array('name'=> 'lunch_allowance',
        'value' => $model->contract_salary->lunch_allowance?number_format($model->contract_salary->lunch_allowance).'    VND':""),

      array('name'=> 'other_allowance',
        'value' => $model->contract_salary->other_allowance ? number_format($model->contract_salary->lunch_allowance).'    VND':""),

      array('name' => 'type',
         'value' => $model->type),

      array('name' => 'contract_stop_date',
        'value' => $model->contract_stop_date ? date('M/d/Y', $model->contract_stop_date):"",
        'visible' => $model->contract_stop_date !==null),

      array('name' => 'contract_stop_reason',
        'value' => $model->contract_stop_reason ? $model->contract_stop_reason:"",
        'visible' => $model->contract_stop_reason !==null),

      array('name' => 'created_id',
        'value' => $model->user->fullname),

      array('name' => 'updated_id',
        'value' => $model->updated_id,
        'visible' => $model->updated_id !==null),


    ),
  )); ?>
  <?php
  $this->widget('bootstrap.widgets.TbButton',array(
    'label' => 'Export PDF',
    //'type' => 'danger',
    'size' => 'small',
    'url'  => array('contract/pdf','id'=>$model->id),
  ));

  ?>
</div>