
<style>
  table td, table th {
    padding: 9px 10px;
    text-align: center;
  }
</style>
<?php
$this->breadcrumbs=array(
	'Activity Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ActivityLog', 'url'=>array('index')),
	array('label'=>'Create ActivityLog', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').hide();

$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('activity-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php
//$this->renderPartial('_search',array(
//	'model'=>$model,
//));
?>
</div><!-- search-form -->
<?php date_default_timezone_set('Asia/Saigon'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'activity-log-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'template'=>'{items}{summary}{pager}',
    'pager'=>array(
         'class'=>'CLinkPager',
         'header'=>''
    ),
	'columns'=>array(

		array('name'=>'activity_date',
		      'value'=>'$data->getActivityDate()',
		      'htmlOptions'=>array('width'=>250,'align'=>'center', 'id' => 'activitylog'),
		),
		array('name'=>'user_id',
		      'value'=>'$data->user->fullname',
		      'htmlOptions'=>array('width'=>250,'align'=>'center'),
		),
		array('name'=>'activity_type',
		      'value'=>'ucfirst($data->activityType->activity_description)',
		      'htmlOptions'=>array('width'=>250,'align'=>'center'),
		),

		array('name'=>'ip_logged ',
		      'value'=>'ucfirst($data->ip_logged )',
		      'htmlOptions'=>array('width'=>100,'align'=>'center'),
		),
  //		array(
//      'class'=>'CButtonColumn',
//      'template'=>'{view}',
//      'header'=>'View',
//      'buttons'=>array(
//        'view' => array(
//          'label'=>'View',
//          'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
////					'url'=>'Yii::app()->createUrl($data->action_group,array("view"=>$data->action_id))',
//        ),
//      ),
//      'htmlOptions'=>array('width'=>100,'align'=>'center'),
//    ),
	),
)); ?>

<script language="javascript">

</script>