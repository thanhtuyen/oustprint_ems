<?php
$this->breadcrumbs=array(
	'Vacations'=>array('index'),
	$model->vacation_id=>array('view','id'=>$model->vacation_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Vacation', 'url'=>array('index')),
	array('label'=>'Create Vacation', 'url'=>array('create')),
	array('label'=>'View Vacation', 'url'=>array('view', 'id'=>$model->vacation_id)),
	array('label'=>'Manage Vacation', 'url'=>array('admin')),
);
?>

<h3 class="title">Updating Vacation #<?php echo $model->vacation_id; ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'user'=>$user)); ?>