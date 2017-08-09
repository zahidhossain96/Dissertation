<?php
/**
* Similar code can be found at: https://github.com/PHPMailer/PHPMailer/
*
**/

require_once('PHPMailer-master/PHPMailerAutoload.php');
class Mail {
  public static function sendMail($subject, $body, $address) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '465';
    $mail->isHTML();
    $mail->Username = 'flanbasket@gmail.com';
    $mail->Password = 'newcastleuni';
    $mail->SetFrom('no-reply@flanbasket.com');
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($address);
    $mail->Send();
  }
}
?>
