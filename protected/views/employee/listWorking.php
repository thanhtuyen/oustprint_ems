<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employee-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array('name' => 'fullname',
			    'value' => '$data->user->fullname'),

    array('name' => 'job_title',
          'value' => '$data->job_title'),

		'degree',
		array('name' => 'degree_name',
			    'value' => '$data->degree_name'),
		//'background',
		//'telephone',
		array('name' => 'telephone',
			    'value' => '$data->telephone?"0".$data->telephone:""'),
		array('name' => 'department_id',
			    'value' => '$data->getDepartmentName($data->department_id)'),

		array(
      'class'=>'CButtonColumn',
      'template'=>'{update} {view}',
      'header'=>'Actions',
      'buttons'=>array(
        'update' => array(
          'imageUrl'=>Yii::app()->request->baseUrl.'/images/ico_edit.png',
          'url'=>'Yii::app()->createUrl("employee/update",array("id"=>$data->id))',
        ),
          'view' => array(
            'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
            'url'=>'Yii::app()->createUrl("employee/view",array("id"=>$data->id))',
          ),
        ),
      'htmlOptions'=>array('width'=>100,'align'=>'center'),
      ),
	),
)); ?>
<?php
if(Yii::app()->user->getState('roles') =="admin" || (Yii::app()->user->getState('roles') =="manager" )):
$this->widget('bootstrap.widgets.TbButton',array(
  'label' => 'Export to Excel',
  'type' => 'submit',
  'size' => 'small',
  'url'  => array('employee/excelWorking'),
));endif;
?>