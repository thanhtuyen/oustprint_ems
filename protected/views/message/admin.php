<style>
  .span9 {
    width: 100%;
  }
</style>
<?php
/* @var $this MessageController */
/* @var $model Message */

$this->breadcrumbs=array(
	'Messages'=>array('index'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List Message', 'url'=>array('index')),
//	array('label'=>'Create Message', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#message-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<div class="search-form" style="display:none">-->
<?php //$this->renderPartial('_search',array(
//	'model'=>$model,
//)); ?>
<!--</div><!-- search-form -->
<?php $this->widget('zii.widgets.grid.CGridView', array(
  'id'=>'message-grid',
  'dataProvider'=>$model->search(),
  //'filter'=>$model,
  'columns'=>array(
    array(
      'name' => 'types',
      'value' => '$data->getTypeName($data->types)',
      'htmlOptions'=>array('align'=>'center'),
    ),
    array(
      'name' => 'status',
      'value' => '$data->getStatusName($data->status)',
      'htmlOptions'=>array('align'=>'center'),
    ),
    array(
      'name' => 'title',
      'value' => '$data->title',
      'htmlOptions'=>array('align'=>'center'),
    ),
    array(
      'name' => 'mod_sender_id',
      'value' => '$data->modSender->user->getFullName()',
      'htmlOptions'=>array('align'=>'center'),
    ),

    array(
      'name' => 'mod_user_id',
      'value' => '$data->modUser? $data->modUser->user->getFullName():"Public"',
      'htmlOptions'=>array('align'=>'center'),
    ),

    array(
      'name' => 'created_date',
      'value' => 'date("M-d-Y",$data->created_date)',
      'htmlOptions'=>array('align'=>'center'),
    ),

    array(
      'class'=>'CButtonColumn',
      'template'=>' {view}',
      'header'=>'Actions',
      'buttons'=>array(
        'view' => array(
          'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
          'url'=>'Yii::app()->createUrl("message/view",array("id"=>$data->id))',
        ),
      ),
      'htmlOptions'=>array('width'=>100,'align'=>'center'),
    ),

  )
));
?>
