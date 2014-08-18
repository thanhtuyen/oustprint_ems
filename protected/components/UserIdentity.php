<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
  private $_id;
  const ERROR_STATUS_NOTACTIV=3;
  /**
   * Authenticates a user using the User data model.
   * @return boolean whether authentication succeeds.
   */
  public function authenticate()
  {
    $user = User::model()->findByAttributes(array('email'=>$this->username, 'status'=>1));

    if($user===null)
    {
      $this->errorCode=self::ERROR_USERNAME_INVALID;
    }
    else
    {
      if($user->password!==$user->encrypt($this->password))
      {
        $this->errorCode=self::ERROR_PASSWORD_INVALID;
      }
      else
      {
        $this->_id = $user->id;
//        if(null === $user->lastvisit)
//        {
//          $lastLogin = time();
//        }
//        else
//        {
//          $lastLogin = strtotime($user->lastvisit);
//        }
//        $this->setState('lastLoginTime', $lastLogin);
        //$this->setState('fullName', $user->getFullName());
       // $this->setState('jobFunction', $user->getJobFunction());
        /*$company = Company::model()->findByPk($user->user_company);
        $this->setState('companyName', $company->company_name);*/
//        $this->setState('role', $user->getRoleOfUser());
//        $this->setState('loginAs', $user->getRoleOfUser());
//        date_default_timezone_set($user->user_timezone);
//        $this->setState('dateFormat', Yii::app()->params['dateFormat']);
//        $this->setState('pageSize', Yii::app()->params['pageSize']);
        $this->errorCode=self::ERROR_NONE;
      }
    }
    return !$this->errorCode;
  }
  public function getId()
  {
    return $this->_id;
  }
}