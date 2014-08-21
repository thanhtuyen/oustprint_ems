<?php

class ResetPasswordForm extends CFormModel
{
  /**
   * @var mixed user's email address
   */
  public $email='';
  public $status='';


  /**
   * @return array rules for this form
   */
  public function rules() {
    return array(
      array('email','email'),
      array('status, email', 'safe'),

      // validate that name or eMail exist in active users
//            array('name,eMail', 'exist',
//                'className'=>'P2User',
//                'allowEmpty'=>'true',
//                'criteria'=>array(
//                    'condition' => 'status=:status',
//                    'params'=>array(':status'=>P2User::STATUS_ACTIVE),
//                ),
//            ),
    );
  }

  /**
   * Verifies that at least one field is not empty
   */
  public function beforeValidate()
  {
//        if ( $this->email==='') {
//            $this->addError('email', Yii::t('Please enter your user name or email address'));
//            return false;
//        }
    return true;
  }


  /**
   * @return mixed the P2User object matching these form values or null if not existant
   */
  public function getUser()
  {
    $condition='status=:status';
    $params=array(':status'=>User::STATUS_ACTIVE);

    if ($this->name!=='')
      return User::model()->findByAttributes(array('name'=>$this->name),$condition,$params);
    elseif($this->eMail!=='')
      return User::model()->findByAttributes(array('email'=>$this->email),$condition,$params);
    else
      return null;
  }
}
