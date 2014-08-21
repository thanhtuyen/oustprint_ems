<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo app()->theme->baseUrl; ?>/css/styles.css" />
    <link rel="shortcut icon" href="<?php echo app()->theme->baseUrl; ?>/images/ico/title.png" type="image/x-icon" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<?php   
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.function.js');
   // Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/vacation.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.tools.min.js');
    //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery-1.9.1.js');
?>
</head>

<body>

<a href="<?php echo app()->createUrl('/site/index');?>"><img class="img" src="<?php echo app()->theme->baseUrl; ?>/images/ico/mainnav.png" alt="Image"></a>
<?php
  $contract_id = getContract();
  $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
              array(
                'label'=>'Dasboard',
                'url'=>array('/Site/Index')
              ),
              array(
                'label'=>'Profile',
                'url'=>array('/Employee/Admin'),
                'visible'=>(app()->user->getState('roles') =='admin' || app()->user->getState('roles') =='manager' || app()->user->getState('roles') =='leader')
              ),
              array(
                'label'=>'Profile',
                'url'=>array('/Employee/view/'. app()->user->id),
                'visible'=>( app()->user->getState('roles') =='user')
              ),
              array(
                'label'=>'Contract',
                'url'=>array('/Contract/index/34'),
                'visible'=>(app()->user->getState('roles') =='admin' || app()->user->getState('roles') =='manager' )
              ),
              array(
                'label'=>'Contract',
                'url'=>array('/Contract/view/'.$contract_id),
                'visible'=>(app()->user->getState('roles') =='leader' ||  app()->user->getState('roles') =='user')
              ),
               array(
                'label'=>'Vacation',
                'url'=>array('/Vacation/Admin'),

              ),
              array(
                'label'=>'Department',
                'url'=>array('/Department/admin'),
//                'visible'=>(app()->user->getState('roles') =="admin" || app()->user->getState('roles') =='manager' || app()->user->getState('roles') =='leader')
              ),
              array(
                'label'=>'Admin',
                'url'=>array('/User/Admin'),
                'visible'=>(app()->user->getState('roles') =='admin' || app()->user->getState('roles') =='manager' || app()->user->getState('roles') =='leader' )
              ),
              array(
                'label'=>'Quick Message',
                'url'=>array('/Message/create'),
//                'visible'=>(app()->user->getState('roles') =="admin" || app()->user->getState('roles') =='manager' || app()->user->getState('roles') =='leader')
              ),
              array(
                'label'=>'Logs',
                'url'=>array('/activitylog/admin'),
                'visible'=>(app()->user->getState('roles') =="admin" || app()->user->getState('roles') =='manager')
              ),
            ),
        ),
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                //array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>webapp()->user->isGuest),
                array('label'=>'Welcome  '.app()->user->getState('fullName').' ['.app()->user->getState('roles').']', 'url'=>'#', 'items'=>array(
                    array('label'=>'My Accounting', 'url'=>array('/User/view/'.app()->user->id)),
                    array('label'=>'Change Password', 'url'=>array('/User/Changepassword/'.app()->user->id)),
                    array('label'=>'Logout', 'url'=>array('/Site/Logout'), 'visible'=>!app()->user->isGuest)
                )),
            ),
        ),
    ),
)); ?>

<div class="container">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		));
		?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

    <hr>
    <div id="footer">

        <div id="distance2">
            <div id="block-bottom" style="margin-top: 2em;">
                <div class="wrapper">
                    <div class="grid-block" id="toolbar">
                        <div class="float-left">

                            <div class="module  deepest">
                                <ul class="bottom_left">
                                    <li class="databases">
                                        <a title="" target="_blank" href="http://www.hcmutrans.edu.vn/" class="mootip">
                                            <strong style="float: left">Ho Chi Minh City University of Transport</strong>
                                        </a>
                                    </li>
                                    <li class="messages">
                                        <a title="" target="_blank" href="http://www.hcmutrans.edu.vn/khoa/cntt/Web/index.php" class="mootip">
                                            <strong style="float: left">IT science</strong>
                                        </a>
                                    </li>
                                    <li class="options">
                                        <a title="" target="_blank" href="http://www.facebook.com/groups/CN11LT.dhgtvt/" class="mootip">
                                            <strong style="float: left">CN11LT</strong>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="float-right">
                            <div class="module  deepest">
                                <ul class="bottom_right">
                                    <li class="users">
                                        <a title="" href="#" style="text-decoration: none" class="mootip">
                                            <strong>EMS</strong>
                                        </a>
                                    </li>
                                    <li class="right_info">
                                        Graduate Project
                                    </li>
                                    <li class="right_info">
                                        Employee Management System
                                    </li>
                                    <li class="right_info">
                                        version: v1.5
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

	</div><!-- footer -->

</div><!-- page -->

</body>

<script type="text/javascript">
  $(document).ready(function() {
    $('.container').append('<div id="top" title="Top" style="float: right; display: none;">Back to Top</div>');
    $(window).scroll(function() {
      if($(window).scrollTop() > 100) {
        $('#top').fadeIn();
      } else {
        $('#top').fadeOut();
      }
    });
    $('#top').click(function() {
      $('html, body').animate({scrollTop:0},500);
    });
    if($(".ui-icon-closethick").length)
    {
      $('.ui-icon-closethick').click(function() {
        //	window.location.reload();					//	reload
        window.location.href = window.location.href;	//	refresh page smoother
      });

      $(".quicksms").append('Quick SMS');
    }

    if($(".sampleIconCssStyle").length)
      $(".sampleIconCssStyle").attr('title', 'Quick View');


  });
</script>
</html>
