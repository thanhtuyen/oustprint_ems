<?php $stringHelper = new GlandoreHelper; ?>

<li class="each d_message">
	<div class="vacation" style="padding: 10px 10px;">

		<a title="Sender" style="color: #333;" href="<?php echo Yii::app()->createUrl('/employee/view', array('id'=>$data->user_id));?>" >
		<?php
			echo $data->user->getUserName($data->user_id);
		?>
		</a>

		<span class="vacation">

		<a title="<?php echo "requested on ".$data->getrequestDay(); ?>" style="color: #333;margin-left: 20px;" href="<?php echo Yii::app()->createUrl('/vacation/view', array('id'=>$data->id));?>">
		<?php echo CHtml::encode($data->getReasonName($data->type)).': '; ?>


		<?php
			echo $data->total." ".$data->showday($data->total)."";
			//echo $stringHelper->substr($data->more_reason, 0, 30, '... ');
		?>

		<?php echo '<b class="sup_day" style="color: brown;">from '.CHtml::encode($data->getstartDay()).'</b>'; ?>

		<span class="pin"> &nbsp;&nbsp;&nbsp;</span>
        <sup style="float: right; background: dimgrey; padding: 10px; margin: -18px; border-radius: 4px;
       <?php if($data->getStatusName($data->status)=="Waiting") echo "color:gold;margin-left:20px"; else echo "color:whiteSmoke;margin-left:8px"; ?>">
          <?php echo CHtml::encode($data->getStatusName($data->status)); ?></sup>

		</a>
	</div>
</li>