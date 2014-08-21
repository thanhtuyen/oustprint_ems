<?php
/* @var $this MessageController */
/* @var $data Message */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('types')); ?>:</b>
	<?php echo CHtml::encode($data->types); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message_info')); ?>:</b>
	<?php echo CHtml::encode($data->message_info); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->mod_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_sender_id')); ?>:</b>
	<?php echo CHtml::encode($data->mod_sender_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	*/ ?>

</div>