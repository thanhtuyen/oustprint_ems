<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Manage',
);

// $this->menu=array(
// 	array('label'=>'List Employee', 'url'=>array('index')),
// 	array('label'=>'Create Employee', 'url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
 $('#employee-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    name = $('#employee-grid2').attr('value');
    if (name) {

         $('#employee-grid2').yiiGridView('update', {
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

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); 
?>
</div><!-- search-form -->
<div id="button_search">
  <?php echo CHtml::link(CHtml::image( Yii::app()->request->baseUrl .'/images/search-blue.png', 'DORE'),'#',array('class'=>'search-button')); ?>Search
</div>
<?php endif;?>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'id' => 'mytabs',
    'type' => 'tabs',
    'tabs' => array(
      array('id' => 'tab1', 'label' => 'Working', 'content' => $this->renderPartial('listWorking', array('model' => $model), true), 'active' => true),
      array('id' => 'tab2', 'label' => 'Not working', 'content' =>$this->renderPartial('listNotWorking', array('model' => $model), true)),
  
    ),
    //'events'=>array('shown'=>'js:loadContent')
  )
);?>



