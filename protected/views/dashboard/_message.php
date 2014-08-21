<?php $stringHelper = new GlandoreHelper; ?>

<li class="each d_message">
	<div class="" style="padding: 10px 10px;">

			<?php
      $TypeName = '';
			switch($data->types)
			{
				case 1: $TypeName = "notice";	break;
				case 2: $TypeName = "news";		break;
				case 3: $TypeName = "message";	break;
				default: break;
			}

			?>

    <a title="Sender" style="color: #333;" href="<?php echo Yii::app()->createUrl('/message/view', array('id'=>$data->id));?>" >
		<?php
			/*
			if($data->getUserRole($data->mod_sender_id)=="admin")
				echo "Managing Director";
			else if($data->getUserRole($data->mod_sender_id)=="manager")
				echo "Glandore Manager";
			else if($data->getUserRole($data->mod_sender_id)=="input")
				echo "Glandore Admin";
			else
			*/

			//echo $data->getUserName($data->mod_sender_id);
		?>
		</a>
    <span class="<?php echo "sampleIconCssStyle ".$TypeName; ?>">

    <a title="<?php echo "from ".$data->getUserName($data->mod_sender_id); 	?>" style="color: #333; margin-left: 20px;" href="<?php echo Yii::app()->createUrl('/message/view', array('id'=>$data->id));?>">
		<?php
			if($data->title) echo $stringHelper->substr($data->title, 0, 55, '... [more]');
			else
        echo $stringHelper->substr($data->message_info, 0, 55);
		?>
		<sup class="sup_day" style="color: brown;">
			<?php echo '['.CHtml::encode(date('M-d-Y',$data->created_date)).']'; ?>
		</sup>
		</a>

	</div>
</li>
<?php
