<?php if(Yii::app()->user->hasFlash('changedPassword')): ?>
<div class="msg success">
    <h3 class="yes_info">
		<?php echo Yii::app()->user->getFlash('changedPassword'); ?>
	</h3>
</div>
<?php endif; ?>
<?php if(!$model->profile->user_id): ?>
<button style="float: right;"><a href="<?php print Yii::app()->createUrl('/user/update', array('id'=>$model->user_id));?>">Update User Info</a></button>
<button style="float: right;"><a href="<?php print Yii::app()->createUrl('/profile/create', array('id'=>$model->user_id));?>">New Profile for User</a></button>
<?php else: ?>
<button style="float: right;"><a href="<?php print Yii::app()->createUrl('/user/update', array('id'=>$model->user_id));?>">Update User Info</a></button>
<button style="float: right;"><a href="<?php print Yii::app()->createUrl('/profile/view', array('id'=>$model->user_id));?>">View User Profile</a></button>
<button style="float: right;"><a href="<?php print Yii::app()->createUrl('/profile/update', array('id'=>$model->user_id));?>">Update User Profile</a></button>
<?php endif; ?>

<h3 class="title" style="text-align: left;"><?php echo $model->getFullName(); ?></h3>
<h3 class="flash_info" style="text-align: left;">[User <?php echo $model->getStatusName(); ?>]</h3>

<?php 
    date_default_timezone_set($model->user_timezone);
?>

<?php if(Yii::app()->user->hasFlash('warn_status')):?>
	<h3 class="warn_info">
        <?php echo Yii::app()->user->getFlash('warn_status'); ?>
    </h3>
<?php endif; ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'user_username',
		'user_first_name',
		'user_last_name',
		'user_full_name',
		'user_email',
	 	/*array('label' => $model->company->getAttributeLabel('company_name'),
			  'value' => $model->company->company_name
		),*/
		array('label' => $model->getAttributeLabel('role'),
			  'value' => $model->getRoleName()
		),
		//'user_active',
		array('label' => $model->getAttributeLabel('user_active'),
			  'value' => $model->getStatusName()
		),
		array('name'=>'user_created_date',
		      'value'=>$model->getCreatedDate()
		)
	),
)); ?>

<div class="active_user">
<?php 
	if($model->user_active==1)		//	active
	{
		//print_r($model->getUserRole(Yii::app()->user->id));exit;		
		if(($model->getUserRole(Yii::app()->user->id))<>"user")		//	co quyen manager
			echo CHtml::button('Deactive User', array('submit' => array('user/deactive','id'=>$model->user_id)));			
	}
	if($model->user_active==0)		//	deactive
	{	
		if(($model->getUserRole(Yii::app()->user->id))<>"user")		//	co quyen manager
			echo CHtml::button('Active User', array('submit' => array('user/active','id'=>$model->user_id)));	
	}	
	
?>
</div>