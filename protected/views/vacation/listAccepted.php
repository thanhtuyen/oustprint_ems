<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vacation-accepted-grid',
	'dataProvider'=>$model_accepted->search_accepted(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		array('name' => 'fullname',
			'value' => '$data->user->fullname',
			'htmlOptions'=>array('width'=>150,'align'=>'center'),),
//		array('name' => 'request_day',
//			'value' => '$data->getrequestDay()'),
		array('name' => 'start_date',
			'value' => '$data->getstartDate()'),
		array('name' => 'end_date',
			'value' => '$data->getEnddate()'),
		'total',
		'type',
		array('name' => 'status',
			'value' => '$data::getStatusName($data->status)'),
    array('name' => 'approve_id',
      'value' => 'User::getUserName($data->approve_id)'),
		//'reason',
		/*
		'user_id',
		'approve_id',
		'created_date',
		'status',
		'updated_date',
		*/
		array(
					'class'=>'CButtonColumn',
					'template'=>'{update} {view}',
					'header'=>'Actions',
					'buttons'=>array(
									'update' => array(    									   
										'imageUrl'=>Yii::app()->request->baseUrl.'/images/ico_edit.png',
			                            'url'=>'Yii::app()->createUrl("vacation/update",array("id"=>$data->id))',
									), 
			                        'view' => array(
			                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
			                            'url'=>'Yii::app()->createUrl("vacation/view",array("id"=>$data->id))',
			                        ),
	                ),
					'htmlOptions'=>array('width'=>100,'align'=>'center'),
	         ),
	),
)); ?>
<?php
$this->widget('bootstrap.widgets.TbButton',array(
  'label' => 'Export to Excel',
  'type' => 'submit',
  'size' => 'small',
  'url'  => array('vacation/excelAccepted'),
));
?>