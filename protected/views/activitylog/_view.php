<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('activity_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->activity_id), array('view', 'id'=>$data->activity_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activity_date')); ?>:</b>
	<?php echo CHtml::encode($data->activity_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activity_type')); ?>:</b>
	<?php echo CHtml::encode($data->activity_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action_id')); ?>:</b>
	<?php echo CHtml::encode($data->action_id); ?>
	<br />


</div>