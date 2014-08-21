<style type="text/css">
  A:active {text-decoration: none}
  A:hover {text-decoration: none;}
</style>
<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$model->id,
);

// $this->menu=array(
// 	array('label'=>'List Employee', 'url'=>array('index')),
// 	array('label'=>'Create Employee', 'url'=>array('create')),
// 	array('label'=>'Update Employee', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Employee', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Employee', 'url'=>array('admin')),
// );
?>
<div class = "view_employee">
  <button style="float: right; margin-right: 5px;"><a onclick="history.go(-1);">Cancel</a></button>
  <button style="float: right; margin-right: 5px;"><a href="<?php print Yii::app()->createUrl('/employee/update', array('id'=>$model->id));?>">Update</a></button>
	<div class="wraper">
		<div class="employee_left">
			<span class="img_avatar">
			<?php 
			if($model->avatar) {
				$imagestring = Yii::app()->request->baseUrl.'/media/images/thumbnails/'.$model->avatar;
			} else {
				$imagestring = Yii::app()->request->baseUrl.'/media/images/thumbnails/noAvatar.png';
			}
			echo CHtml::image($imagestring);
			?>
		</span>
		</div>
		<div class="employee_main">
			<span>Full Name:</span> <?php echo $model->user->fullname;?></br>
			<span>Birthday:  </span><?php echo date('M-d-Y', $model->user->dob);?></br>
			<span>Email:	</span>   <?php echo $model->user->email;?>

		</div>
		<div class="employee_right">
			<?php 
			if($model->cv) {
				$cv = Yii::app()->request->baseUrl.'/media/cv/has_cv.png';
        echo CHtml::link(CHtml::image($cv), Yii::app()->createUrl('/employee/downloadCV',array('id' => $model->id)));
			} else {
				$cv = Yii::app()->request->baseUrl.'/media/cv/no_cv.png';
        echo CHtml::image($cv);
			}

			?>
		</div>
	</div>
	
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'job_title',
      array('name' => 'degree',
            'value' => $model->degree?$model->degree:''),
      array('name' => 'degree_name',
            'value' => $model->degree_name?$model->degree_name:''),
      array('name' => 'background',
            'value' => $model->background?$model->background:''),
      array('name' => 'telephone',
            'value' => $model->telephone?"0".$model->telephone:''),
			array('name' => 'mobile',
            'value' => $model->mobile?"0".$model->mobile:''),
      array('name' => 'homeaddress',
            'value' => $model->homeaddress?$model->homeaddress:''),
			array('name' => 'department_id',
				    'value' => $model->getDepartmentName($model->department_id)),
      array('name' => 'personal_email',
            'value' => $model->personal_email?$model->personal_email:''),
		),
	)); ?>
	<div class="view_tab_employee">
		<?php $this->widget('bootstrap.widgets.TbTabs', array(
	    'id' => 'mytabs',
	    'type' => 'tabs',
	    'tabs' => array(
	      array('id' => 'tab1', 'label' => 'Education', 'content' => $model->education, 'active' => true, 'type' => 'raw'),
	      array('id' => 'tab2', 'label' => 'Skill', 'content' => $model->skill, true, 'type' => 'raw'),
	      array('id' => 'tab3', 'label' => 'Experience', 'content' => $model->experience, true, 'type' => 'raw'),
	      array('id' => 'tab4', 'label' => 'Note', 'content' => $model->notes, true, 'type' => 'raw'),
	    ),
	    'events'=>array('shown'=>'js:loadContent')
	  )
	  );?>


	  </br>
	</div>

  </br>
  <?php
    $this->widget('bootstrap.widgets.TbButton',array(
      'label' => 'Export PDF',
      //'type' => 'danger',
      'size' => 'small',
      'url'  => array('employee/PDF','id'=>$model->id),
    ));

  ?>
</div>

