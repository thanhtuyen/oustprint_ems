<div class="view">
<!--	
	<b><?php echo CHtml::encode($data->getAttributeLabel('vacation_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->vacation_id), array('view', 'id'=>$data->vacation_id)); ?>
	<br />
-->	
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user->getUserFullName()), array('view', 'id'=>$data->vacation_id)); ?>
	<?php //echo CHtml::encode($data->user->getUserFullName()); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('request_day')); ?>:</b>
	<?php echo CHtml::encode($data->getrequestDay()); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reason')); ?>:</b>
	<?php echo CHtml::encode($data->getReasonName()); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('start_day')); ?>:</b>
	<?php echo CHtml::encode($data->getStartDay()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_day')); ?>:</b>
	<?php echo CHtml::encode($data->getEndDay()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('more_reason')); ?>:</b>
	<?php echo CHtml::encode($data->more_reason); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->getStatusName()); ?>
	<br />	
	
</div>