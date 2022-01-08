<?php

function createPassword($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }

    return $str;
}

function send_email($pdf,$id,$password,$email)
{
    $mail = new PHPMailer();

    $emailbody = '';
    $emailbody .= '<h1>email enquiry from '. Exam_Cell_Automation .'</h1>';

    $emailbody .= '<strong>'.'Your ID Is'.'</strong>'.' : '.$id.'<br>';
    $emailbody .= '<strong>'.'Your Password Is'.'</strong>'.' : '.$password.'<br>';

    try {
        //Server settings
        $mail->IsSMTP();
        $mail->Mailer     = "smtp";
        $mail->SMTPDebug  = 1;
        //$mail->Host = 'smtp.mailtrap.io';
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'SMTP username';                     //SMTP username
        $mail->Password   = 'SMTP password';                              //SMTP password
        $mail->SMTPSecure = "tls";         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        //$mail->Port = 2525;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->Port = 465;

        //Recipients
        $mail->setFrom('systememail@domain.com', 'Exam_Cell_Automation');

        $mail->addAddress($email, 'Student');     //Add a recipient

        $mail->addStringAttachment($pdf,'Hall_Ticket.pdf');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'You successfully registered for the subject and here is your hall ticket';
        $mail->Body    = $emailbody;
        $mail->AltBody = strip_tags($emailbody);

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
