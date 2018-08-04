<?php

namespace models\front;

use \system\Document;
use \system\Model;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

class MailerModel extends Model {
    
    public function sendMail($fromemail, $fromname, $toemail, $toname, $subject, $message) {
		
		$mail = new PHPMailer(); // инициализируем класс
		
		$mail->CharSet = 'UTF-8';
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isMAIL(); 									// указали, что не смтп
	    //$mail->isSMTP();                                      // Set mailer to use SMTP

	    //gmail
	    // $mail->Host = 'smtp.gmail.com';  					// Specify main and backup SMTP servers
	    // $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    // $mail->Username = 'username@gmail.com';                 // SMTP username
	    // $mail->Password = 'userpass';                           // SMTP password
	    // $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	    // $mail->Port = 465;                                    // TCP port to connect to

		$mail->setFrom($fromemail, $fromname); // от кого
		$mail->addReplyTo($fromemail, $fromname); // адрес и имя для ответа
		$mail->Subject = $subject; // заголовок письма (тема сообщения)
		$plain = $mail->html2text($message); // создаем текстовую версию для устройств, не поддерживающих html
		$mail->isHTML(true); // указали, что сообщение в стандарте html
		
		$body = "<!DOCTYPE html>"; // создаем тело письма
		$body .= "<html><head>"; // структуру я минимизирую, шаблонов в сети много, либо создайте свой
		$body .= "<meta charset='UTF-8' />";
		$body .= "<title>".$subject."</title>";
		$body .= "</head><body>";
		$body .= "<div style='padding:10px;'>".nl2br($message)."</div>";
		$body .= "</body></html>";
		
		$mail->msgHTML($body); // формируем тело
		$mail->AltBody = $plain; // альтернативное тело письма
		
		$mail->addAddress($toemail, $toname); // добавляем получателя и отправляем
		
		if (!$mail->send()) { // если произошла ошибка при отправке
			$return = false; //$toname." | ".str_replace("@", "&#64;", $toemail)." ".$mail->ErrorInfo."  | ".date("d-m-Y в H:i:s"); // возвращаем сообщение об ошибке
		} else {
			$return = true; //$toname." | ".str_replace("@", "&#64;", $toemail)." | ".date("d-m-Y в H:i:s");
		  } // если сообщение отправлено удачно- возвращаем время отправки
		$mail->clearAddresses();
		$mail->clearCustomHeaders();
		$mail->clearAttachments();
		$mail->clearReplyTos(); // чистим все заголовки
		
		return $return;
	}



}
