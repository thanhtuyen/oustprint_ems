<?php
/* @var $this MessageController */
/* @var $model Message */

$this->breadcrumbs=array(
	'Messages'=>array('index'),
	$model->title,
);

//$this->menu=array(
//	array('label'=>'List Message', 'url'=>array('index')),
//	array('label'=>'Create Message', 'url'=>array('create')),
//	array('label'=>'Update Message', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Message', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Message', 'url'=>array('admin')),
//);
//?>

<div class="view_message">
  <h3 class="title"><?php echo  $model->getTypeName($model->types); ?></h3>
  <?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
      array(
        'name' => 'status',
        'value'=> $model->getStatusName($model->status),
        'type' => 'raw',
      ),
      array(
        'name' => 'title',
        'value' => $model->title,
        'type' => 'raw',
      ),
      array(
        'name' => 'message_info',
        'value'=> $model->message_info,
        'type' => 'raw',
      ),
      array(
        'name' => 'mod_sender_id',
        'value'=> $model->modSender->user->getFullName(),
      ),
      array(
        'name' => 'mod_user_id',
        'value'=> $model->modUser? $model->modUser->user->getFullName():'Public',
      ),
      array(
        'name' => 'created_date',
        'value' => $model->created_date? date('M-d-Y',$model->created_date):''),
    ),
  )); ?>
  <p>&nbsp;</p>
</div>
