<?php

class ForgotPassword extends CFormModel
{
    /**
     * @var mixed user's email address
     */
    public $email='';


    /**
     * @return array rules for this form
     */
    public function rules() {
        return array(
            array('email','email'),

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
//        $condition='status=:status';
//        $params=array(':status'=>P2User::STATUS_ACTIVE);
//
//        if ($this->name!=='')
//            return P2User::model()->findByAttributes(array('name'=>$this->name),$condition,$params);
//        elseif($this->eMail!=='')
//            return P2User::model()->findByAttributes(array('eMail'=>$this->eMail),$condition,$params);
//        else
//            return null;
    }
}
