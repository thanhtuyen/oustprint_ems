
<?php
  $newModel=new Contract('create');
 echo $this->renderPartial('newContract', array('model'=>$newModel));
?>
<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('contract-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<?php //date_default_timezone_set('Asia/Saigon'); ?>
<?php
if(Yii::app()->user->getState('roles') =="admin" || (Yii::app()->user->getState('roles') =="manager" )):
?>
<?php echo CHtml::link(CHtml::image( Yii::app()->request->baseUrl .'/images/search-blue.png', 'DORE'),'#',array('class'=>'search-button')); ?>Search
  <div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
      'model'=>$model,
    ));
    ?>
  </div><!-- search-form -->
<?php endif;?>

<?php if(Yii::app()->user->hasFlash('work_status')):?>
  <div class="alert alert-success">
    <?php echo Yii::app()->user->getFlash('work_status'); ?>
  </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('updateFail')):?>
  <div class="alert alert-danger">
    <?php echo Yii::app()->user->getFlash('updateFail'); ?>
  </div>
<?php endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
  'id'=>'contract-grid',
  'dataProvider'=>$model->search(),
  'template'=>'{items}{summary}{pager}',
  'columns'=>array(
    array(
      'header' => 'Fullname',
      'value' => '$data->employee->user->fullname',
      'htmlOptions'=>array('width'=>150,'align'=>'left'),
    ),
    array(
      'header' => 'Contract Start',
      'value' => 'date("M-d-Y",$data->contract_start_date)',
      'htmlOptions'=>array('width'=>80,'align'=>'center'),
    ),
    array(
      'header' => 'Length<br>(months)',
      'value' => '$data->contract_length',
      'htmlOptions'=>array('width'=>20,'align'=>'center'),
    ),
    array(
      'header' => 'Contract End',
      'value' => 'date("M-d-Y",$data->contract_end_date)',
      'htmlOptions'=>array('width'=>80,'align'=>'center'),
    ),
    array(
      'header' => 'Status',
      'value' => '$data->getStatusName()',
      'htmlOptions'=>array('width'=>20,'align'=>'center'),
    ),
    array(
      'header' => 'Contract Stop',
      'value' => '$data->contract_stop_date?date("M-d-Y",$data->contract_stop_date):"-"',
      'htmlOptions'=>array('width'=>80,'align'=>'center'),
    ),
    array(
      'header' => 'contract_stop_reason',
      'value' => '$data->contract_stop_reason',
      'htmlOptions'=>array('width'=>200,'align'=>'left'),
    ),
    array(
      'header' => 'Reporter',
      'value' => '$data->user->fullname',
      'htmlOptions'=>array('width'=>120,'align'=>'left'),
    ),
    array(
      'class'=>'CButtonColumn',
      'template'=>'{stop}{view}',
      'header'=>'Actions',
      'buttons'=>array(
        'stop' => array(
          'label'=>'Stop Contract',
          'url'=>'Yii::app()->createUrl("contract/stop",array("id"=>$data->id))',
          'imageUrl'=>Yii::app()->request->baseUrl.'/images/user_rej.gif',
        ),
        'view' => array(
          'label'=>'View Profile',
          'url'=>'Yii::app()->createUrl("contract/view",array("id"=>$data->id))',
          'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
        ),
      ),
      'htmlOptions'=>array('width'=>10,'align'=>'center'),
    ),

  ),
)); ?>
<script type="text/JavaScript">
  jQuery(document).ready(function () {
    //hide a div after 3 seconds
    setTimeout( "jQuery('.alert').hide();",7000 );
  });

</script>
