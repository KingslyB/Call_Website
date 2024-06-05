<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'lib/PHPMailer-6.9.1/src/SMTP.php';
    require_once 'lib/PHPMailer-6.9.1/src/Exception.php';
    require_once 'lib/PHPMailer-6.9.1/src/PHPMailer.php';

    function sendPasswordResetMail($recipientEmailAddress, $resetUrl)
    {
        //TODO: Consider HTTP Headers

        $mail = new PHPMailer(true);
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                              //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USERNAME;                          //SMTP username
            $mail->Password   = MAIL_PASSWORD;                          //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = MAIL_PORT;                              //TCP port to connect to;
                                                                        //use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(MAIL_FROM_ADDRESS, 'Company');
            $mail->addAddress($recipientEmailAddress, 'Recipient');       //Add a recipient (Name is optional)
            $mail->addReplyTo('no-reply@example.com', 'DO NOT REPLY');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Call_Website - Reset Attempt';
            $mail->Body    = 'Link to reset password: '.$resetUrl.'
            <br>
            <br>
            <br>This link is meant only for you. Do not share it.
            <br>If you did not request a password reset, please ignore this email.
            <hr />';
            $mail->AltBody = 'Link to reset password: '.$resetUrl;

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

