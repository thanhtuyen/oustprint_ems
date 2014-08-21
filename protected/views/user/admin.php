<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

// $this->menu=array(
// 	array('label'=>'List User', 'url'=>array('index')),
// 	array('label'=>'Create User', 'url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){

    $('#user-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    name = $('#user-grid2').attr('value');
    if (name) {

         $('#user-grid2').yiiGridView('update', {
            data: $(this).serialize()
	    });
    }


	return false;
});
");
?>
<?php
if(Yii::app()->user->getState('roles') =="admin" || (Yii::app()->user->getState('roles') =="manager" )):
?>
<?php echo CHtml::link(CHtml::image( Yii::app()->request->baseUrl .'/images/search-blue.png', 'DORE'),'#',array('class'=>'search-button')); ?>Search

<div class="search-form" style="display:none">
  <?php $this->renderPartial('_search',array(
	'model'=>$model,
	'roles' => $roles

));
?>
  <?php endif;?>
</div><!-- search-form -->
<?php if(Yii::app()->user->hasFlash('warn_status')):?>
  <p class="warn_info">
    <?php echo Yii::app()->user->getFlash('warn_status'); ?>
  </p>
<?php endif; ?>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'id' => 'mytabs',
    'type' => 'tabs',
    'tabs' => array(
      array('id' => 'tab1', 'label' => 'Active', 'content' => $this->renderPartial('listActive', array('model' => $model), true), 'active' => true),
      array('id' => 'tab2', 'label' => 'Deactive', 'content' =>$this->renderPartial('listDeactive', array('model' => $model), true)),
      array('id' => 'tab3', 'label' => 'New User', 'url' => '../User/create', true),
    ),
    //'events'=>array('shown'=>'js:loadContent')
  )
);?>


<script type="text/JavaScript">
  jQuery(document).ready(function () {
    //hide a div after 7 seconds
    setTimeout( "jQuery('.warn_info').hide();",7000 );
  });

</script>


