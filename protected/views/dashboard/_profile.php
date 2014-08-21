

<?php $stringHelper = new GlandoreHelper; ?>

<li class="each d_message">
<a title="Profile detail" style="" href="<?php echo Yii::app()->createUrl('/employee/view', array('id'=>$data->id));?>" >
	<div class="vacation" style="padding: 10px 10px;">
<!--		<span style="">--><?php //echo CHtml::encode($data->user_code); ?><!--</span>-->
		<span class="user"></span>
		<?php
			echo $data->user->getUserName($data->id);
		?>
<!--		<span style="">[--><?php //echo CHtml::encode($data->getUserJobFunction()); ?><!--]</span>-->
		<span style="">[<?php echo CHtml::encode(isset($data->created_date)?date('M-d-Y H:i',$data->created_date):''); ?>]</span>
    <?php
    if($data->updated_date) {
      $scenario = 'update';
    } else {
      $scenario = 'create';
    }
    ?>
		<sup class="<?php echo "sup_day ".$scenario; ?>">
		<?php echo ($scenario=='create'?'new':$scenario); ?>
		</sup>
	</div>
</a>
</li>