<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'vacation-form',
  'type'=>'horizontal',
  'enableAjaxValidation'=>false,
)); 
 		if(app()->user->hasFlash('updateFail')){
	      echo app()->user->getFlash('updateFail');
	    } 

?>

		<?php 
		if($model->getdaysnumber()>1)
			$total = $model->getdaysnumber().' days';
		if($model->getdaysnumber()<=1)
			$total = $model->total.' day';
		?>

	<div class = "view_user">
		<h3 class="title"><?php echo $model->user->fullname; ?></h3>
		<h4>This vacation is <span style="color:red;"><?php echo $model::getStatusName($model->status);?></span></h4>
		<?php $this->widget('bootstrap.widgets.TbDetailView', array(
			'data'=>$model,
			'attributes'=>array(
        array('name' => 'request_date',
          'value' => date("H",$model->request_day)."h".date("i",$model->request_day)." ".date("D",$model->request_day).' '.$model->getrequestDay()),
				array('name' => 'start_date',
					  'value' => date("H",$model->start_date)."h".date("i",$model->start_date)." ".date("D",$model->start_date).' '.$model->getStartDay()),
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

        array('name' => $model->comment_two?'Comment Manager':'',
          'type' => 'raw',
          'value' =>  $model->comment_two?CHtml::decode($model->comment_two):'',
          'htmlOptions'=>array('style'=> 'color:red !important;','align'=>'center'),
        ),
        array('name' => $model->comment_three?'Comment Admin':'',
          'type' => 'raw',
          'value' =>  $model->comment_three?CHtml::decode($model->comment_three):'',
          'htmlOptions'=>array('style'=> 'color:red !important;','align'=>'center'),
        ),

      ))); ?>

      <?php
//          if($model->status == Vacation::STATUS_WAITING && (Yii::app()->user->getState('roles') =='admin'||(Yii::app()->user->id ==$model->approve_id))){
            if(in_array($model->status,array(Vacation::STATUS_WAITING,Vacation::STATUS_IN_PROGRESS, Vacation::STATUS_RESOLVED)) &&
              (Yii::app()->user->getState('roles') =='admin'||(Yii::app()->user->id ==$model->approve_id))){
            echo $form->dropDownListRow($model, 'approve_id', User::getListUserSearch(), array('class' => 'span2'));
            echo $form->textArea($model,'comment',array('class'=> 'input_comment','placeholder'=>'Comment'));
          }
//            elseif($model->status ==  && (Yii::app()->user->getState('roles') =='admin'||(Yii::app()->user->id ==$model->approve_id))){
//            echo $form->dropDownListRow($model, 'approve_id', User::getListUserSearch(), array('class' => 'span2'));
//            echo $form->textArea($model,'comment_two',array('class'=> 'input_comment','placeholder'=>'Comment'));
//          } elseif($model->status ==  && (Yii::app()->user->getState('roles') =='admin'||(Yii::app()->user->id ==$model->approve_id))){
//            echo $form->dropDownListRow($model, 'approve_id', User::getListUserSearch(), array('class' => 'span2'));
//            echo $form->textArea($model,'comment_three',array('class'=> 'input_comment','placeholder'=>'Comment'));
//          }

//		      echo $form->error($model,'comment_one'); ?><!--</br>-->
    <p style="text-align: center;">
      <?php if((Yii::app()->user->getState('roles') =='admin'||(Yii::app()->user->id ==$model->approve_id))){
        $this->widget('bootstrap.widgets.TbButton', array(
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
      }

      ?>
    </p>


  </div>
<?php $this->endWidget(); ?>

</div><!-- form -->