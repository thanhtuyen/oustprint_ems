<?php /**
 * MailTransport
 *
 * @package EMS v1.0
 * @author TNT
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class MailTransport {

    /**
     * Send Email
     *
     * @param string $from
     * @param mixed $to
     * @param mixed $subject
     * @param mixed $body
     * @param string $contentType
     * @param string $cc
     * @param mixed $attachedFiles
     * @param integer $realname
     * @param string $hostInfo
     * @return void
     */
    public static function sendMail($from = '', $to, $subject, $body, $contentType = 'text/html', $cc = '', $attachedFiles = array(), $realname = 1, $hostInfo = '') {

        $message = new YiiMailMessage();
        $message->setTo($to);


        if (empty($from)) {
            $message->setFrom(Yii::app()->params['noreplyEmail']);
        }
        else {
            $message->setFrom($from);
        }

        if ($cc != '') {
            if (is_string($cc)) {
                $cc = array($cc);
            }
            $message->setCc($cc);
        }
        $message->setSubject($subject);
        $message->setBody($body, $contentType);
        foreach ($attachedFiles as $file) {
        	if($realname){
        		$attachment = Swift_Attachment::fromPath($file);
        	}else{
        		if(isset($file['path'])){
	        		$attachment = Swift_Attachment::fromPath($file['path']);
	        		if(isset($file['newname'])){
	        			$attachment->setFilename($file['newname']);
	        		}
        		}
        	}
            
            $message->attach($attachment);
        }
        Yii::app()->mail->send($message);
    }

}
