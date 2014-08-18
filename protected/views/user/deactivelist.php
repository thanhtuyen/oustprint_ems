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

<?php if(Yii::app()->user->hasFlash('updateFail')):?>
	<div class="msg warning">
        <?php echo Yii::app()->user->getFlash('updateFail'); ?>
    </div>
<?php endif; ?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	//'company'=>$company,
	'roles'=>$roles
)); ?>
</div><!-- search-form -->
<?php /* echo '<pre>';
	  print_r($model);
	  echo '</pre>';*/
	$dataProvider = $model->search1();
	date_default_timezone_set("Asia/Saigon");
?>

<?php if(Yii::app()->user->checkAccess('admin')||Yii::app()->user->checkAccess('manager')): ?>
   
	<?php $this->widget('zii.widgets.grid.CGridView', array(
	    'id'=>'user-grid',
	    'dataProvider'=>$model->search1(),
		'template'=>'{items}{summary}{pager}',
	    'ajaxUpdate' => false,
	    'pager'=>array(
	          'class'=>'CLinkPager',
	          'header'=>''
	       ),
	    //'filter'=>$model,
		'columns'=>array(
			array(
                'name' => 'user_username',
                'htmlOptions'=>array('align'=>'center'),
                ),
			array(
                'name' => 'Name',
				  'value' => '$data->user_first_name." ".$data->user_last_name',
                'htmlOptions'=>array('align'=>'center'),
                ),
			array(
                'name' => 'user_full_name',
                'htmlOptions'=>array('align'=>'left','style'=>'padding-left: 10px;'),
                ),
			array('name' => 'group',
				  //'filter'=>CHtml::listData(Company::model()->findAll(), 'company_id', 'company_name'),
				  'value' => '($data->profile->user_job_function)? $data->profile->user_job_function : "-"',
			      'htmlOptions'=>array('align'=>'center'),
			),
			array('name' => 'user_role',
				  'value' => '($data->getRoleName())?$data->getRoleName(): "-"',
				  'filter' => false,
				  'htmlOptions'=>array('align'=>'center'),
				
			),
			array('name'=>'user_created_date',
                  'value'=>'date("M-d-Y","$data->user_created_date")',	
				  'htmlOptions'=>array('align'=>'center'),  	     
			),
			/*
			array('name'=>'Vacation Quota',
	              'value'=>'$data->getVacationDays()',
                  'htmlOptions'=>array('align'=>'center'),
            ),
			array('name'=>'Sick Quota',
	              'value'=>'$data->getSickDays()',
                  'htmlOptions'=>array('align'=>'center'),
            ),            
			*/
	        array(
	                'class'=>'CButtonColumn',
	                'template'=>'{active} {change_pass} {update} {view}',
	                'header'=>'Actions',
	                'buttons'=>array(
	                                'active' => array(                                    
	                                    'label'=>'Active',
	                                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/success.png',
	                                    'url'=>'Yii::app()->createUrl("user/active",array("id"=>$data->user_id))',
	                                ),
	                                'change_pass' => array(
	                                            'label'=>'Change password',
	                                            'url'=>'Yii::app()->createUrl("user/changePassword",array("id"=>$data->user_id))',
	                                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/change_password.png',
	                                ),
									'update' => array(    									   
										'imageUrl'=>Yii::app()->request->baseUrl.'/images/ico_edit.png',
			                            'url'=>'Yii::app()->createUrl("user/update",array("id"=>$data->user_id))',
									), 
			                        'view' => array(
			                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
			                            'url'=>'Yii::app()->createUrl("user/view",array("id"=>$data->user_id))',
			                        ),
	                ),
	                'htmlOptions'=>array('width'=>100,'align'=>'center'),
	         ),
	         
	    ),
	)); ?>	
	

<?php endif; ?>
<script type="text/javascript">
	var countItem = <?php echo $dataProvider->getTotalItemCount()?>;
	//if(countItem == 0) { $('.search-form').toggle(); }
</script>
