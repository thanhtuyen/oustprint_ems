<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

// $this->menu=array(
// 	array('label'=>'Create User', 'url'=>array('create')),
// 	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Change Password', 'url'=>array('changePassword', 'id'=>$model->id)),
// 	array('label'=>'Manage User', 'url'=>array('admin')),
// );
?>
<?php echo $this->renderPartial('_deactive', array('model'=>$model)); ?>