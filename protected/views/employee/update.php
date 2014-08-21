<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>
<div class="update_employee">
<h1> <?php echo $model->user->fullname; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'departmentName' => $departmentName)); ?>
</div>