<script type="text/JavaScript">
  setTimeout("location.href = '<?php echo Yii::app()->createUrl("/"); ?>';",2000);
</script>
<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
<?php echo CHtml::link('Home',array('index')); ?>
</div>