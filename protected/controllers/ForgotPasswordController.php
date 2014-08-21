<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TuyenNT
 * Date: 9/23/13
 * Time: 4:39 PM
 * To change this template use File | Settings | File Templates.
 */
class ForgotPasswordController extends Controller {


  public function actionForgotPassword()
  {
    $this->layout = '//layouts/resetPassword';
    $form = new ForgotPasswordForm;
    // Uncomment the following line if AJAX validation is needed
    //$this->performAjaxValidation($form);

    if(isset($_POST['ForgotPasswordForm']))
    {
      $form->email = $_POST['ForgotPasswordForm']['email'];
     // $form->token = 123;
      // validate user input and set a sucessfull flassh message if valid
      if($form->validate())
      {
        if($form->getUser()) {
          //sending e-mail to user
          $user = User::model()->findByAttributes(array('email'=> $form->email));
          $pass = User::autoGeneralPass();
          $user->password = User::encrypt($pass);
          $user->save();
          $this->sendForgotPasswordEmail($form->getUser(), $form->email, $pass);
          //Yii::app()->user->setFlash('success', $form->user_email . " has been actived to change pass." );
          $form = new ForgotPasswordForm;
          $form->status = 'success';
        } else {
          app()->user->setFlash('error', 'Email address does not exist !');
        }

      }
    }
    $this->render('forgotPassword',array(
      'model'=>$form
    ));

  }

    private function sendForgotPasswordEmail($fullName, $mailto, $pass) {
        try {
            $to = $mailto;
            $url = Yii::app()->createAbsoluteUrl('site/login');
            $subject = 'Forgot your password   ';
            $body = 'Dear '.$fullName.',<br><br>';
            $body .= 'Please click on this link: <a href="'.$url.'">'.$url.'</a> to login system.<br><br>';
            $body .= 'New password has created auto<br/>';
            $body.='Username: '.$fullName.'<br/>';
            $body.='Password: '.$pass.'<br/>';
            $body .= '<br><br>Best Regards,<br>';
            $body .= 'Validant vSource Team';
            MailTransport::sendMail(null, $to, $subject, $body, 'text/html');
        } catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

}