<?php date_default_timezone_set('Asia/Saigon'); ?> 
<?php
$this->breadcrumbs=array(
	'Activity Logs'=>array('index'),
	$model->activity_id,
);

$this->menu=array(
	array('label'=>'List ActivityLog', 'url'=>array('index')),
	array('label'=>'Create ActivityLog', 'url'=>array('create')),
	array('label'=>'Update ActivityLog', 'url'=>array('update', 'id'=>$model->activity_id)),
	array('label'=>'Delete ActivityLog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->activity_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ActivityLog', 'url'=>array('admin')),
);
?>

<h1>View ActivityLog #<?php echo $model->activity_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'activity_id',
		'activity_date',
		'user_id',
		'activity_type',
		'action_id',
	),
)); ?>
