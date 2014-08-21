<?php
/* @var $this VacationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vacations',
);

$this->menu=array(
	array('label'=>'Create Vacation', 'url'=>array('create')),
	array('label'=>'Manage Vacation', 'url'=>array('admin')),
);
?>

<h1>Vacations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
