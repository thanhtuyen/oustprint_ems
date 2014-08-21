<div class="form">
  <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'vacation-form',
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
        //	'id',
        array('name' => 'start_date',
          'value' => date("H",$model->start_date)."h".date("i",$model->start_date)." ".date("D",$model->start_date).' '.$model->getStartDay()),
        array('name' => 'end_date',
          'value' => date("H",$model->end_date)."h".date("i",$model->end_date)." ".date("D",$model->end_date).' '.date('M-d-Y',$model->end_date)),
        array('name' => 'total',
          'value' => $total),
        array('name' => 'type',
          'value' => $model::getReasonName($model->type)),
        array('name' => 'Reason',
          'type' => 'raw',
          'value' => CHtml::decode($model->reason)
        ),
      ),
    )); ?>
    <?php if($model->status==2 || $model->status==3 || $model->status==4 || $model->status==5) :?>
<!--      --><?php //if($model->reason): ?>
<!--        <span class="reason">Reason</span>-->
<!--        <span class="comment">--><?php //echo $model->getReason(); ?><!--</span>-->
<!--      --><?php //endif; ?>
      <?php if($model->comment_one): ?>
        <h3 class="yes_info">
          <span class="reason">Comment</span>
          <span class="comment"><?php echo $model->comment_one; ?></span>
        </h3>
      <?php endif; ?>
      <?php if($model->comment_two): ?>
        <h3 class="yes_info">
          <span class="reason">Comment</span>
          <span class="comment"><?php echo $model->comment_two; ?></span>
        </h3>
      <?php endif; ?>
<!--    --><?php //elseif($model->status==1) :?>
<!--      --><?php //if($model->reason): ?>
<!--        <span class="reason">Reason</span>-->
<!--        <span class="comment">--><?php //echo $model->getReason(); ?><!--</span>-->
<!--      --><?php //endif; ?>
    <?php endif;?>

    <?php echo $form->textField($model,'comment_one',array('class'=> 'input_comment','placeholder'=>'Comment')); ?>
    <?php echo $form->error($model,'comment_one'); ?></br>
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