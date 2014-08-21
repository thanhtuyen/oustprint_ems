<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dashboard.css'); ?>
<?php
$this->breadcrumbs = array(
	'Dashboard',
);
?>

<?php
Yii::import("application.extensions.GlandoreHelper");
?>

<?php if(Yii::app()->user->hasFlash('warn_status')):?>
	<div class="alert alert-warning">
        <?php echo Yii::app()->user->getFlash('warn_status'); ?>
  </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error_view')):?>
  <div class="alert alert-warning">
    <?php echo Yii::app()->user->getFlash('error_view'); ?>
  </div>
<?php endif; ?>
<?php if(Yii::app()->user->getState('roles') =="user" ): ?>
  <div class="main_dashboard">

    <div class="dash dash_message">
      <strong class="title">Most recent messages</strong>
      <a id="add" style="line-height: 21px;" title="Create new message" href="<?php echo Yii::app()->createUrl('/message/create');?>">
        Create message
      </a>
      <div class="group">
        <?php $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$dataProvider,
          'itemView'=>'_message',
          'template'=>'{items}',
          //'emptyText' => '',
          //'summaryText' => '',
        )); ?>
      </div>
      <?php if(Message::model()->exists()): ?>
        <li class="each"><a class="viewall" title="View more messages" href="<?php echo Yii::app()->createUrl('/message/admin');?>">more</a></li>
      <?php endif; ?>
    </div>

    <div class="dash dash_vacation">
      <strong class="title">Most recent vacations</strong>
      <a id="add" style="line-height: 21px;" title="Create new vacation" href="<?php echo Yii::app()->createUrl('/vacation/create');?>">
        Create vacation
      </a>
      <div class="group">
        <?php $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$vacation,
          'itemView'=>'_vacation',
          'template'=>'{items}',
          //'emptyText' => '',
          //'summaryText' => '',
        )); ?>
      </div>
      <?php if(Vacation::model()->exists()): ?>
        <li class="each"><a  class="viewall" title="View more vacations" href="<?php echo Yii::app()->createUrl('/vacation/');?>">more</a></li>
      <?php endif; ?>
    </div>
  </div>
<?php else: ?>
  <div class="main_dashboard">

    <div class="dash dash_message">
      <strong class="title">Most recent messages</strong>
      <a id="add" style="line-height: 21px;" title="Create new message" href="<?php echo Yii::app()->createUrl('/message/create');?>">
        Create message
      </a>
      <div class="group">
      <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_message',
        'template'=>'{items}',
        //'emptyText' => '',
        //'summaryText' => '',
      )); ?>
      </div>
      <?php if(Message::model()->exists()): ?>
      <li class="each"><a class="viewall" title="View more messages" href="<?php echo Yii::app()->createUrl('/message/admin');?>">more</a></li>
      <?php endif; ?>
    </div>

    <div class="dash dash_vacation">
      <strong class="title">Most recent vacations</strong>
      <a id="add" style="line-height: 21px;" title="Create new vacation" href="<?php echo Yii::app()->createUrl('/vacation/create');?>">
        Create vacation
      </a>
      <div class="group">
        <?php $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$vacation,
          'itemView'=>'_vacation',
          'template'=>'{items}',
          //'emptyText' => '',
          //'summaryText' => '',
        )); ?>
      </div>
      <?php if(Vacation::model()->exists()): ?>
        <li class="each"><a  class="viewall" title="View more vacations" href="<?php echo Yii::app()->createUrl('/vacation/');?>">more</a></li>
      <?php endif; ?>
    </div>

    <div class="dash dash_profile">
      <strong class="title">Most recent profiles</strong>
<!--      <a id="add" style="line-height: 26px;" title="Create new profile" href="--><?php //echo Yii::app()->createUrl('/employee/newprofile/'); ?><!--">-->
<!--        Create profile-->
<!--      </a>-->
      <div class="group">
        <?php $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$profile,
          'itemView'=>'_profile',
          'template'=>'{items}',
          //'emptyText' => '',
          //'summaryText' => '',
        )); ?>
      </div>
      <?php if(Employee::model()->exists()): ?>
        <li class="each"><a  class="viewall" title="View more profiles" href="<?php echo Yii::app()->createUrl('/employee/');?>">more</a></li>
      <?php endif; ?>
    </div>

    <div class="dash dash_user">
      <strong class="title">Most recent users</strong>
      <a id="add" style="line-height: 21px;" title="Create new user" href="<?php echo Yii::app()->createUrl('/user/create');?>">
        Create user
      </a>
      <div class="group">
        <?php $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$user,
          'itemView'=>'_user',
          'template'=>'{items}',
          'emptyText' => '',
          'summaryText' => '',
        )); ?>
      </div>

      <?php if(User::model()->exists()): ?>
        <li class="each"><a  class="viewall" title="View more users" href="<?php echo Yii::app()->createUrl('/user/');?>">more</a></li>
      <?php endif; ?>
    </div>

  </div>
<?php endif;?>

<script type="text/javascript">
	var countItem = <?php echo $dataProvider->getTotalItemCount()?>;
	if(countItem == 0) { $('.search-form').toggle(); }
</script>
	
