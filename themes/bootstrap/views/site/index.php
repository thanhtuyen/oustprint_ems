<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<p>
    <?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'×', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
            'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        ),
    ));

    if(app()->user->hasFlash('error')){
        echo app()->user->getFlash('error');
    } elseif(app()->user->hasFlash('warning')){
        echo app()->user->getFlash('warning');
    } elseif(app()->user->hasFlash('info')){
        echo app()->user->getFlash('info');
    } elseif(app()->user->hasFlash('success')){
        echo app()->user->getFlash('success');
    }
    ?>
</p>

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Welcome to '.CHtml::encode(Yii::app()->name),
)); ?>

<p>Congratulations! You have successfully created your Yii application.</p>

<?php $this->endWidget(); ?>

<p>You may change the content of this page by modifying the following two files:</p>

<ul>
    <li>View file: <code><?php echo __FILE__; ?></code></li>
    <li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
</ul>

<p>For more details on how to further develop this application, please read
    the <a href="http://www.yiiframework.com/doc/">documentation</a>.
    Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
    should you have any questions.</p>
