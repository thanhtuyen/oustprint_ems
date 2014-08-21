<?php
$this->breadcrumbs=array(
	'Activity Logs',
);

$this->menu=array(
	array('label'=>'Create ActivityLog', 'url'=>array('create')),
	array('label'=>'Manage ActivityLog', 'url'=>array('admin')),
);
?>

<h1>Activity Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
