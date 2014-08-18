<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo app()->theme->baseUrl; ?>/css/login.css" />
    <link rel="shortcut icon" href="<?php echo app()->theme->baseUrl; ?>/images/ico/title.png" type="image/x-icon" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>


</head>

<body>

<div class="wrapper">
    <a class="header_img" href="<?php echo app()->createUrl('/Site/Login');?>"><img id="img_header" src="<?php echo app()->theme->baseUrl; ?>/images/ico/try1.png" alt="Image"></a>
    <hr>

    <div id="login-form">
        <?php echo $content; ?>
    </div><!-- login-fom -->

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
                                        Graduate Internship Project
                                    </li>
                                    <li class="right_info">
                                        Employee Management System
                                    </li>
                                    <li class="right_info">
                                        version: v1.0
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
</html>
