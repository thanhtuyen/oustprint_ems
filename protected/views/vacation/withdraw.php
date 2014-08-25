<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vacation-form',
	'enableAjaxValidation'=>false,	
)); 
 		if(app()->user->hasFlash('updateFail')){
	      echo app()->user->getFlash('updateFail');
	    }
date_default_timezone_set('Asia/Saigon');
?>

		<?php 
		if($model->getdaysnumber()>1)
			$total = $model->getdaysnumber().' days';
		if($model->getdaysnumber()<=1)
			$total = $model->total.' day';
		?>

	<div class = "view_user">
		<h3  class="title"><?php echo $model->user->fullname; ?></h3>
		<h4>This vacation is <span style="color:red;"><?php echo $model::getStatusName($model->status);?></span></h4>
		<?php $this->widget('bootstrap.widgets.TbDetailView', array(
			'data'=>$model,
			'attributes'=>array(
			//	'id',
				array('name' => 'start_date',
					  'value' => date("H",$model->start_date)."h".date("i",$model->start_date)." ".date("D",$model->start_date).' '.$model->getStartDay()),
				array('name' => 'end_date',
					  'value' => date("H",$model->end_date)."h".date("i",$model->end_date)." ".date("D",$model->end_date).' '.date('M-d-Y',$model->end_date)),
				array('name' => 'total',
					  'value' => $total),
        array('name' => 'type',
          'value' => $model::getReasonName($model->type)),
			),
		)); ?>
    <?php if($model->status==3)
      $class = "accepted";
    elseif($model->status==5 || $model->status==4)
      $class = "decline";
    elseif($model->status==2)
      $class = "requestCancel";
    ?>
    <table style="margin-bottom: 5px;">
      <?php if($model->reason): ?>
        <tr>
          <td class="reason">Reason</td>
          <td><?php echo $model->getReason(); ?></td>
        </tr>
      <?php endif; ?>
      <?php if($model->comment_one): ?>
        <tr>
          <td class="reason_comment">Comment Manager</td>
          <td class="comment_view_<?php echo $class;?>"><?php echo $model->comment_one; ?></td>
        </tr>
      <?php endif; ?>
    </table>
    <?php echo $form->textField($model,'comment_four',array('class'=>'input_comment','placeholder'=>'Comment')); ?>
		<?php echo $form->error($model,'comment_four'); ?>
    <p style="text-align: center;">
      <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=> 'Save',

      ));
      $this->widget('bootstrap.widgets.TbButton', array(
        //'buttonType'=>'link',
        'label'=>'Cancel',
        'htmlOptions'=>array('style'=>'margin-left: 10px;'),
        'url'=>'../../Vacation/Admin',
      ));
      ?>
    </p>


  </div>
<?php $this->endWidget(); ?>

</div><!-- form -->