<?php $this->pageTitle=app()->name . ' - '.'Login'; ?>

<h1><?php echo $title; ?></h1>

<div id="login-form">
<?php echo $content; ?>
<?php echo CHtml::link('Login',array('site/login')); ?></div><!-- yiiForm -->