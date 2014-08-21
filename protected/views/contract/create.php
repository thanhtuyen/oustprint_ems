<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
  'Contract'=>array('index'),
  'Create',
);

// $this->menu=array(
// 	array('label'=>'List User', 'url'=>array('index')),
// 	array('label'=>'Manage User', 'url'=>array('admin')),
// );
?>
<div class="create_contract">
  <?php echo $this->renderPartial('_form', array('model'=>$model, 'modelContractSalary' => $modelContractSalary)); ?>
</div>