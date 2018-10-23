<?php
class Notification{
public function Send_Mail($from, $password,$receivers,$body )
{
  $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.datasecur.optisoft.ng;mail.datasecur.optisoft.ng';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $from;                 // SMTP username
$mail->Password = $password;                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom($from, 'DataSecur');
foreach ($receivers as $email=>$phone)
{
$mail->addAddress($email);     // Add a recipient
}
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Intusion Alert';
$mail->Body    = $body;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
}

function send_sms($number, $msg) {
  $quick_buy = "http://www.quickbuysms.com/index.php?option=com_spc&" .
  "comm=spc_api&username=ogoo80&password=@ughonu247&sender=" .
  "DataSecur&recipient=" . $number . "&message=" .
   urlencode($msg);
  //star a curl request
  $ch = curl_init($quick_buy);
  //set tor return the request response
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //
  curl_setopt($ch, CURLOPT_HEADER, 0);
  //the response is saved in the handle
  curl_exec($ch);

  //Yes, let close the connection, the server Memory will thank us later.
  curl_close($ch);
}

}
