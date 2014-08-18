<?php
$this->breadcrumbs=array(
	'Vacations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Vacation', 'url'=>array('index')),
	array('label'=>'Manage Vacation', 'url'=>array('admin')),
);
?>
 
<h3 class="title">Creating New Vacation</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'user'=>$user)); ?>