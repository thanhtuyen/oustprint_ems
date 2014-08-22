<?php
/* @var $this VacationController */
/* @var $model Vacation */

$this->breadcrumbs=array(
	'Vacations'=>array('index'),
	$model->id,
);

// $this->menu=array(
// 	array('label'=>'List Vacation', 'url'=>array('index')),
// 	array('label'=>'Create Vacation', 'url'=>array('create')),
// 	array('label'=>'Update Vacation', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Vacation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Vacation', 'url'=>array('admin')),
// );
?>
<?php date_default_timezone_set('Asia/Saigon'); ?>
	<?php
	    $this->widget('bootstrap.widgets.TbAlert', array(
	      'block'=>true, // display a larger alert block?
	      'fade'=>true, // use transitions?
	      'closeText'=>'×', // close link text - if set to false, no close link is displayed
	      'alerts'=>array( // configurations per alert type
	        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
	        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
	        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
	        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
	      ),
	    ));

	    if(app()->user->hasFlash('error')){
	      echo app()->user->getFlash('error');
	    } elseif(app()->user->hasFlash('warning')){
	      echo app()->user->getFlash('warning');
	    } elseif(app()->user->hasFlash('info')){
	      echo app()->user->getFlash('info');
	    } elseif(app()->user->hasFlash('success')){
	      echo app()->user->getFlash('success');
	    }
	?>
		<?php 
		if($model->getdaysnumber()>1)
			$total = $model->getdaysnumber().' days';
		if($model->getdaysnumber()<=1)
			$total = $model->total.' day';
		?>

	<div class = "view_vacation">
		<h3 class="title"><?php echo $model->user->fullname; ?></h3>
		<h4>This vacation is <span style="color:red;">
        <?php echo $model::getStatusName($model->status);?></span></h4>
		<?php $this->widget('bootstrap.widgets.TbDetailView', array(
			'data'=>$model,
			'attributes'=>array(
        array('name' => 'request_date',
          'value' => date("H",$model->request_day)."h".date("i",$model->request_day)." ".date("D",$model->request_day).' '.$model->getrequestDay()),
				array('name' => 'start_date',
					  'value' => date("H",$model->start_date)."h".date("i",$model->start_date)." ".date("D",$model->start_date).' '.date('M-d-Y', $model->start_date)),
				array('name' => 'end_date',
					  'value' => date("H",$model->end_date)."h".date("i",$model->end_date)." ".date("D",$model->end_date).' '.date('M-d-Y',$model->end_date)),
				array('name' => 'total',
					  'value' => $total),
        array('name' => 'type',
          'value' => $model::getReasonName($model->type)),
        array('name' => 'User Approved',
          'value' => User::getUserName($model->approve_id)),
        array('name' => 'Reason',
          'type' => 'raw',
          'value' => CHtml::decode($model->reason)
        ),
        array('name' => $model->comment_one?'Comment leader':'',
          'type' => 'raw',
          'value' =>  $model->comment_one?CHtml::decode($model->comment_one):'',
          'htmlOptions'=>array('style'=> 'color:red !important;','align'=>'center'),
        ),
        array('name' => $model->comment_two?'Comment manager':'',
          'type' => 'raw',
          'value' =>  $model->comment_two?CHtml::decode($model->comment_two):'',
          'htmlOptions'=>array('style'=> 'color:red !important;','align'=>'center'),
        ),
        array('name' => $model->comment_three?'Comment admin':'',
          'type' => 'raw',
          'value' =>  $model->comment_three?CHtml::decode($model->comment_three):'',
          'htmlOptions'=>array('style'=> 'color:red !important;','align'=>'center'),
        ),
        array('name' => $model->comment_four?'Comment User':'',
          'type' => 'raw',
          'value' =>  $model->comment_four?CHtml::decode($model->comment_four):'',
          'htmlOptions'=>array('style'=> 'color:red !important;','align'=>'center'),
        ),
			),
		)); ?>

		<!-- check hide or enable button -->
		<h3 class="button_approve" style="clear:both;">
		<?php 
		if(in_array($model->status, array(Vacation::STATUS_WAITING, Vacation::STATUS_IN_PROGRESS,Vacation::STATUS_RESOLVED)))	//	new vacation awaiting
		{
			if(($model->user_id)==(Yii::app()->user->id) and $model->status == 1)		//	dung nguoi
			{
				$this->widget('bootstrap.widgets.TbButton',array(
															'label' => 'Widthdraw',
															'type' => 'warning',
															'size' => 'small',
															'url'  => array('vacation/withdraw','id'=>$model->id),
															));
				//echo CHtml::button('Widthdraw', array('submit' => array('vacation/withdraw','id'=>$model->id)));
			}

			if(Yii::app()->user->getState('roles') =='admin'||(Yii::app()->user->id ==$model->approve_id)  ) 	//	co quyen admin/approved_id

			{
				$this->widget('bootstrap.widgets.TbButton',array(
															'label' => 'Accept',
															'type'  => 'success',
															'size' => 'small',
															'url'  => array('vacation/accepted','id'=>$model->id),
														));
				$this->widget('bootstrap.widgets.TbButton',array(
															'label' => 'Decline',
															'type' => 'danger',
															'size' => 'small',
															'url'  => array('vacation/decline','id'=>$model->id),
														));	
			}
		}
		if($model->status==6)		//	request cancel from accept
		{
				 
			$tmp_date = date('m-d-Y');		
			$withdraw_date = CDateTimeParser::parse($tmp_date,'MM-dd-yyyy');
			$tmp_end_day = $model->end_date;
			 
			if(($model->user_id)==(Yii::app()->user->id) && ($tmp_end_day >= $withdraw_date))		//	dung nguoi
				//echo CHtml::button('Request Cancel', array('submit' => array('vacation/request','id'=>$model->id)));
			$this->widget('bootstrap.widgets.TbButton',array(
															'label' => 'Request Cancel',
															'type' => 'cancel',
															'size' => 'small',
															'url'  => array('vacation/request','id'=>$model->id),
														));	
			 
		}	
		if($model->status==5)		//	cancel from request cancel
		{
      if(Yii::app()->user->getState('roles') =='admin'||( (Yii::app()->user->getState('roles') =='manager') &&  $employeeLogin->department_id == $employeeVacation->department_id) ) 		//	co quyen admin/manager
        //echo CHtml::button('Cancel', array('submit' => array('vacation/cancel','id'=>$model->id)));
      $this->widget('bootstrap.widgets.TbButton',array(
        'label' => 'Accepted Cancel',
        'type' => 'success',
        'size' => 'small',
        'url'  => array('vacation/cancel','id'=>$model->id),
      ));
			//if(($model->user->getUserRole(Yii::app()->user->id))<>"user")		//	co quyen admin/manager
			if(Yii::app()->user->getState('roles') =='admin'||( (Yii::app()->user->getState('roles') =='manager') &&  $employeeLogin->department_id == $employeeVacation->department_id) ) 		//	co quyen admin/manager		
				//echo CHtml::button('Cancel', array('submit' => array('vacation/cancel','id'=>$model->id)));
			$this->widget('bootstrap.widgets.TbButton',array(
															'label' => 'Cancel',
															'type' => 'cancel',
															'size' => 'small',
															'url'  => array('vacation/cancel','id'=>$model->id),
														));


    }

	?>
	</h3>
	</div>