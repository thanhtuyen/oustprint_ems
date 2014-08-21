<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(

		array(
        'name' => 'fullname',
				'value' => '$data->fullname',
        'htmlOptions'=>array('align'=>'center'),
        ),
		array(
        'name' => 'email',
        'htmlOptions'=>array('align'=>'center'),
      ),
		array('name'=>'dob',
      'value'=>'date("M-d-Y","$data->dob")',
      'htmlOptions'=>array('align'=>'center'),
			),
		array('name'=>'created_date',
      'value'=>'date("M-d-Y","$data->created_date")',
      'htmlOptions'=>array('align'=>'center'),
			),
		array('name' => 'roles',
      'value' => '($data->getUserRole($data->id))?$data->getUserRole($data->id): "-"',
      'filter' => false,
      'htmlOptions'=>array('align'=>'center'),
				
			),

		array(
      'class'=>'CButtonColumn',
      'template'=>'{deactive} {change_pass} {update} {view}',
      'header'=>'Actions',
      'buttons'=>array(
        'deactive' => array(
          'label'=>'Deactive',
          'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
          'url'=>'Yii::app()->createUrl("user/deactive",array("id"=>$data->id))',
        ),
        'change_pass' => array(
              'label'=>'Change password',
              'url'=>'Yii::app()->createUrl("user/changePassword",array("id"=>$data->id))',
              'imageUrl'=>Yii::app()->request->baseUrl.'/images/change_password.png',
                  ),
        'update' => array(
          'imageUrl'=>Yii::app()->request->baseUrl.'/images/ico_edit.png',
                        'url'=>'Yii::app()->createUrl("user/update",array("id"=>$data->id))',
        ),
                    'view' => array(
                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                        'url'=>'Yii::app()->createUrl("user/view",array("id"=>$data->id))',
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
  'url'  => array('user/excelActive'),
));
endif;
?>