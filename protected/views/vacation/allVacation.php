<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vacation-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
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
    array('name' => 'type',
      'value' => '$data::getReasonName($data->type)'),

		array('name' => 'status',
			'value' => '$data::getStatusName($data->status)'),
    array('name' => 'approve_id',
      'value' => 'User::getUserName($data->approve_id)'),
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
'url'  => array('vacation/excelAll'),
));
?>