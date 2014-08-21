<?php

class ActivationController extends Controller
{
	//public $defaultAction = 'activation';

	
	/**
	 * Activation user account
	 */
	public function actionIndex () {
        $this->layout='activation';
        $user = User::model();
		$email = $_GET['email'];
		$activkey = $_GET['activkey'];
		if ($email&&$activkey) {
			$find = $user->findByAttributes(array('email'=>$email));
			if (isset($find)&&$find->status) {
			    $this->render('/user/message',array('title'=>'User activation','content'=>'Your account is active.'));
			} elseif(isset($find->activkey) && ($find->activkey==$activkey)) {
				$find->activkey = encrypt(microtime());
				$find->status = 1;
				$find->save();
				
			    $this->render('/user/message',array('title'=>'User activation','content'=>'Your account is activated.'));
			} else {
			    $this->render('/user/message',array('title'=>'User activation','content'=>'Incorrect activation URL.'));
			}
		} else {
			$this->render('/user/message',array('title'=>'User activation','content'=>'Incorrect activation URL.'));
		}
	}

}