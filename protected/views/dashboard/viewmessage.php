<?php
	$stringHelper = new GlandoreHelper; 
?>
<?php //date_default_timezone_set('Asia/Saigon'); ?><!-- -->
<strong style="color: white; background: grey; padding: 10px; float: left;">	
	<?php echo $model->mod_title?$stringHelper->substr($model->mod_title,0,69,'... '):'No'; ?>
</strong>
<b style="clear: right; line-height: 39px; border: grey solid 2px; padding: 9px 5px;">Title</b>	
<span style="clear: left; ">	

	<p style="float: right; margin-bottom: 15px; margin-top: 10px;"><?php /*if($model->mod_status==2)*/ {echo $model->getStatusName();} ?>
	<?php echo $model->getTypeName(); ?>
	<?php echo '<b>['.$model->getModdate().']</b>'; ?>
	<a title="Sender" style="color: #333;" href="<?php echo Yii::app()->createUrl('/profile/view', array('id'=>$model->mod_sender_id));?>">
	<?php echo '<span class="">from <b>'.$model->getUserName($model->mod_sender_id).'</b></span>'; ?>
	</a>	
	<?php //if($model->mod_status==2) {echo '<span class="">to <b>'.$model->getUserName($model->mod_user_id).'</b></span>';} ?>
</span>
 
<?php if(strlen($model->mod_title)>69): ?>
<div style="clear: both; text-align: justify; padding-top: 10px;">
	<?php echo "<h3><u>Full Title</u></h3><div style=\"padding-left: 40px;\">".$model->mod_title."</div>"; ?>

</div>
<?php endif; ?> 

<div style="clear: both; width: 90%; margin: 10px 40px;"><?php echo $model->mod_info; ?></div>

<span class="clearfix" style="clear: both; margin-bottom: 10px;"></span>

<hr style="clear: both; width: 90%; margin: 10px 40px; border: none;">