<?php
if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager'))
{
	Yii::app()->clientScript->registerScript('search', "

	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('vacation-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");
}
else
{
	Yii::app()->clientScript->registerScript('search', "
	$('.search-button').hide();

	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('vacation-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");
}
?>
<!--
<a href="<?php echo Yii::app()->createUrl('/vacation/create');?>" id="add">New Vacation</a>
-->
<?php if(Yii::app()->user->hasFlash('updateFail')):?>
	<div class="msg warning">
        <?php echo Yii::app()->user->getFlash('updateFail'); ?>
    </div>
<?php endif; ?>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">

<?php 
	if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager'))
	{	
		$this->renderPartial('_search',array(
		'model'=>$model,
		'user'=>$user,
));	}
 ?>
</div><!-- search-form -->
<?php date_default_timezone_set('Asia/Saigon'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vacation-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,	 
	'template'=>'{items}{pager}',	
	//'emptyText' => '',
    //'summaryText' => '',
	'columns'=>array(
		//'vacation_id',
		array(
			'name'=>'user_id',
			'value'=>'$data->user->user_full_name',
			'htmlOptions'=>array('width'=>150,'align'=>'center'),
		),
		array(
			'name'=>'request_day',
			'value'=>'$data->getrequestDay()',
			'htmlOptions'=>array('width'=>80,'align'=>'center'),
		),
		array(
			'name'=>'total',
			'value'=>'$data->total',
			'htmlOptions'=>array('width'=>20,'align'=>'center'),
		),
		array(
			'name'=>'reason',
			'value'=>'$data->getReasonName()',
			'htmlOptions'=>array('width'=>80,'align'=>'center'),
		),
		array(
			'name'=>'start_day',
			'value'=>'$data->getStartDay()',
			'htmlOptions'=>array('width'=>80,'align'=>'center'),
		),
		array(
			'name'=>'end_day',
			'value'=>'$data->getEndDay()',
			'htmlOptions'=>array('width'=>80,'align'=>'center'),
		),
		array(
			'name'=>'more_reason',
			'value'=>'$data->getMoreReason()',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>240,'align'=>'center'),
		),
		array(
			'name'=>'status',
			'value'=>'$data->getStatusName()',
			'htmlOptions'=>array('width'=>150,'align'=>'center'),
		),
		array('name' => 'Comment',
                  'value' => '($data->status==2)? $data->comment_two : $data->comment_one',
				  'type'=>'raw',
                  'htmlOptions'=>array('width'=>240,'align'=>'center'),
            ),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {view}',
			'header'=>'Actions',
				'buttons'=>array(
								'update' => array(
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/ico_edit.png',
								),
		 						'view' => array(
									'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
								),
								/*'request' => array(
											'label'=>'Cancel',
											'url'=>'Yii::app()->createUrl("vacation/request",array("id"=>$data->vacation_id))',
											'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
			                    ),*/
                ),
				'htmlOptions'=>array('width'=>20,'align'=>'center'),
		),
	),
)); ?>
<br></br>

<?php 
		$user_id = Yii::app()->user->id;
		$user = User::model()->findByPk($user_id);
		$doq->vacation_day = $user->getVacationDays()?$user->getVacationDays():0;
		$holidays=$doq->vacation_day;				
		$doq->sick_day = $user->getSickDays()?$user->getSickDays():0;
		$sick_day=$doq->sick_day;
		
		$vacation1 = Vacation::model()->findAll(array(
												'condition'=>'user_id=:id and status=3 and reason!=2',
												'params'=>array(':id'=>$user_id
												)
												));
		$vacation2 = Vacation::model()->findAll(array(
												'condition'=>'user_id=:id and status=3 and reason=2',
												'params'=>array(':id'=>$user_id
												)
												));
		// begin calculate vacation day
		foreach($vacation1 as $row)
		{	$list1[]= $row['attributes'];
		}
		$total =0;
		foreach($list1 as $l)
		{	$total+= $l['total'];}	
		// end calculation vacation day
		// begin calculation Sick day
		foreach($vacation2 as $row)
		{	$list2[]= $row['attributes'];
		}
		$total_sick =0;
		foreach($list2 as $l)
		{	$total_sick+= $l['total'];}	
		//end calculate Sick day
		
		if($model->reason==2)
		{
			if($sick_day>=$total_sick)	$sick_day = $sick_day - $total_sick;
			else{
				$tam = $total_sick - $sick_day;
				$holidays = $holidays - $tam;
			}
		}
		else
		{
			$holidays = $holidays - $total;
		}
		
		$doq->sick_day=$sick_day;
		$doq->vacation_day=$holidays;
?>
<?php if($user->getVacationDays()): ?>
<div class="msg success">
<?php 
	if($doq->sick_day>=0) echo "You have ".$doq->sick_day.' '.$model->showday($doq->sick_day)." off quota for sick remaining";
	else echo "Your sick days off quota is over ";
?>
<br></br>
<?php	
	if($doq->vacation_day>=0) echo "You have ".$doq->vacation_day.$model->showday($doq->vacation_day)." off quota remaining";
	else echo "Your vacation days off quota is over. You own the company ".abs($doq->vacation_day).$model->showday(abs($doq->vacation_day));
?>
</div>
<?php else: ?>
<div class="msg warning">Please ask your manager to set your days off quota</div>
<?php endif; ?>