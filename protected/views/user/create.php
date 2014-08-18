<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model, 'roles'=>$roles)); ?>