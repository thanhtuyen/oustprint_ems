<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    const ERROR_EMAIL_INVALID=3;
    const ERROR_STATUS_NOTACTIV=4;
    const ERROR_STATUS_BAN=5;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $users = User::model()->findByAttributes(array('email'=>$this->username));
       
        if($users == null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } elseif( $users->password !== md5($this->password)) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else if ($users->status == 0){
            $this->errorCode=self::ERROR_STATUS_NOTACTIV;
        } else if ($users->status == 2) {
            $this->errorCode=self::ERROR_STATUS_BAN;
        } else {
            $this->_id = $users->id;
            if(null === $users->lastvisit) {
                $lastLogin = time();
            } else {
                $lastLogin = strtotime($users->lastvisit);
            }

            $this->setState('lastLoginTime', $lastLogin); 
            $this->setState('fullName', $users->getFullName());
            //$this->setState('jobFunction', $users->getJobFunction());
            //get role user login
            $this->setState('roles', $users->getUserRole($users->id));
           // $this->setState('departement_id', $employee->department_id);
            // $this->setState('loginAs', $users->getRoleOfUser()); 
            // date_default_timezone_set($users->user_timezone);
            $this->setState('dateFormat', Yii::app()->params['dateFormat']);
            $this->setState('pageSize', Yii::app()->params['pageSize']);
            $this->errorCode=self::ERROR_NONE;
           
        }

		return !$this->errorCode;
	}

    /**
     * @return integer the ID of the user record
     */
    public function getId()
    {
        return $this->_id;
    }
}