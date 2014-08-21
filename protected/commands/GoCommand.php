<?php
class GoCommand extends CConsoleCommand {

  public function actionHelp()
  {
     Yii::app()->db->createCommand('UPDATE  `hrm1`.`vacation`
     SET  `flag` =  "1" WHERE  `employee_vacation`.`year` < YEAR(CURDATE())')
     ->execute();

    echo "update success";
  }
  public function actionHelp1()
  {
    echo "Deleted unconfi";
  }
//  public function run($args) {
//    $sql = "INSERT INTO `hrm1`.`user` (`id`, `firstname`, `lastname`, `fullname`,
//        `email`, `dob`, `password`, `activkey`, `status`, `lastvisit`, `created_date`,
//        `type`, `updated_date`, `roles`)
//        VALUES (NULL, 'test cron', 'test cron', 'test cron test cron',
//        'testcron@gmail.com', '1380643200', '', NULL, '0', NULL, NULL, '0', NULL, '4')";
//    Yii::app()->db->createCommand($sql)->execute();
//
//
//
//  }



}