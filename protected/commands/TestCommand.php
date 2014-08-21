<?php
class TestCommand extends CConsoleCommand {

  public function run($args) {
    $sql = "INSERT INTO `hrm1`.`user` (`id`, `firstname`, `lastname`, `fullname`,
        `email`, `dob`, `password`, `activkey`, `status`, `lastvisit`, `created_date`,
        `type`, `updated_date`, `roles`)
        VALUES (NULL, 'test cron', 'test cron', 'test cron test cron',
        'testcron@gmail.com', '1380643200', '', NULL, '0', NULL, NULL, '0', NULL, '4')";
    Yii::app()->db->createCommand($sql)->execute();


    echo  " entries found\n";
  }

  public function getHelp()
  {
    echo "Deleted unconfirmed registration entries";
  }

}