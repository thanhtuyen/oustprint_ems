<?php
/* @var $this VacationController */
/* @var $model Vacation */

$this->breadcrumbs=array(
	'Vacations'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Vacation', 'url'=>array('index')),
	array('label'=>'Create Vacation', 'url'=>array('create')),
);?>


<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

$('.search-form form').submit(function(){
	$('#vacation-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1 id="test1"><a href="#" onclick = myFunction()>Manage Vacations</a></h1>-->
<?php if(Yii::app()->user->hasFlash('updateFail') || Yii::app()->user->hasFlash('warn_status')):?>
  <div class="alert alert-warning">
    <?php echo Yii::app()->user->getFlash('updateFail'); ?>
    <?php echo Yii::app()->user->getFlash('warn_status'); ?>
  </div>
<?php endif; ?>
<?php //if(Yii::app()->user->hasFlash('updateFail')):?>
<!--  <div class="alert alert-danger">-->
<!--    --><?php //echo Yii::app()->user->getFlash('updateFail'); ?>
<!--  </div>-->
<?php //endif; ?>
<?php
if(Yii::app()->user->getState('roles') !="user" ):
?>

<div class="search-form" style="display:none; width:60%">
<?php $this->renderPartial('_search',array(
	'model'=>$model
)); ?>

</div><!-- search-form -->
<div id="button_search">
  <?php echo CHtml::link(CHtml::image( Yii::app()->request->baseUrl .'/images/search-blue.png', 'DORE'),'#',array('class'=>'search-button')); ?>Search
</div>
<?php endif;?>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'id' => 'mytabs',
    'type' => 'tabs',
    'tabs' => array(
      array('id' => 'allVacation', 'label' => 'All Vacation', 'content' => $this->renderPartial('allVacation', array('model' => $model), true), 'active' => true),
      array('id' => 'listAwaiting', 'label' => 'Awaiting', 'content' =>$this->renderPartial('listAwaiting', array('model_waiting' => $model_waiting), true),
        'itemOptions' => array('class' => 'waiting')),
      array('id' => 'listRequestCancel', 'label' => 'Request Cancel', 'content' =>$this->renderPartial('listRequestCancel', array('model_request_cancel' => $model_request_cancel), true),
          'itemOptions' => array('class' => 'request_cancel')),
      array('id' => 'listAccepted', 'label' => 'Accepted', 'content' => $this->renderPartial('listAccepted', array('model_accepted' => $model_accepted), true),
          'itemOptions' => array('class' => 'accepted')),
      array('id' => 'listDecline', 'label' => 'Decline', 'content' => $this->renderPartial('listDecline', array('model_decline' => $model_decline), true),
          'itemOptions' => array('class' => 'decline')),
//      array('id' => 'listWithdraw', 'label' => 'Withdraw', 'content' => $this->renderPartial('listWithdraw', array('model_withdraw' => $model_withdraw), true),
//        'itemOptions' => array('class' => 'decline')),
      array('id' => 'New_vacation', 'label' => 'New Vacation', 'url' => '../Vacation/create', true),
    ),
//    'events'=>array('shown'=>'js:loadContent')
  )
);?>

<script language="javascript">
    $(document).ready(function(){
        $(".active").click(function(){
            $('#button_search').show();
        });
        $(".waiting").click(function(){
            $('#button_search').hide();
            $('.search-form').hide();
        });
        $(".request_cancel").click(function(){
            $('#button_search').hide();
            $('.search-form').hide();
        });
        $(".accepted").click(function(){
            $('#button_search').hide();
            $('.search-form').hide();
        });
        $(".decline").click(function(){
            $('#button_search').hide();
            $('.search-form').hide();
        });

    });
</script>



