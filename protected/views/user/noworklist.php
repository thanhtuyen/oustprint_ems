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

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'profile'=>$profile,
	'condition'=>$profile->user_status=1,	
)); ?>
</div><!-- search-form -->
<?php /* echo '<pre>';
	  print_r($model);
	  echo '</pre>';*/
	$dataProvider = $model->search2();
	date_default_timezone_set("Asia/Saigon");
?>
<?php if(Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('manager')): ?>
   
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'user-grid',
        'dataProvider'=>$model->search2(),
        'template'=>'{items}{summary}{pager}',
        'ajaxUpdate' => false,
        'pager'=>array(
              'class'=>'CLinkPager',
              'header'=>''
           ),
        //'filter'=>$model,
        'columns'=>array(
            'user_username',
            'user_first_name',
            'user_last_name',
            'user_full_name',
            array('name' => 'group',
                  //'filter'=>CHtml::listData(Company::model()->findAll(), 'company_id', 'company_name'),
                  'value' => '($data->profile->user_job_function)? $data->profile->user_job_function : "-"',
                  'htmlOptions'=>array('width'=>80,'align'=>'center'),
            ),
            array('name' => 'user_role',
                  'value' => '($data->getRoleName())?$data->getRoleName(): "-"',
                  'filter' => false,
                  'htmlOptions'=>array('width'=>80,'align'=>'center'),
                
            ),
            array('name'=>'user_created_date',
                  'value'=>'date("M-d-Y h:i:s A","$data->user_created_date")',  
                  'htmlOptions'=>array('width'=>150,'align'=>'center'),          
            ), 
            /*
            'user_email',
            'user_password',
            'user_lastvisit',
            array('name'=>'status',
                  'value'=>'$data->getStatusName()',    
                  'htmlOptions'=>array('width'=>50,'align'=>'center'),    
            ),
            */
            array(
                    'class'=>'CButtonColumn',
                    'template'=>'{view}',
                    'header'=>'Actions',
                    'buttons'=>array(
                                    'view' => array(
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                                        'url'=>'Yii::app()->createUrl("profile/view",array("id"=>$data->user_id))',   
                                    ),
                                    'update' => array(
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/ico_edit.png',
                                    ),
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
