<?php
/* @var $this VacationController */
/* @var $model Vacation */

$this->breadcrumbs=array(
	'Vacations'=>array('index'),
	'Create',
);

// $this->menu=array(
// 	array('label'=>'List Vacation', 'url'=>array('index')),
// 	array('label'=>'Manage Vacation', 'url'=>array('admin')),
// );
?>
<div class="update_vacation">

<h1>Create Vacation</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,  'employee_vacation' => $employee_vacation)); ?>
</div>