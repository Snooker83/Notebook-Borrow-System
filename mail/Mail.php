<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/mail.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class MailSender
{


    public function sendOTP($email, $otp)
    {


        $mail = new PHPMailer(true);



        try {


            // SMTP

            $mail->isSMTP();

            $mail->Host = MAIL_HOST;

            $mail->SMTPAuth = true;

            $mail->Username = MAIL_USERNAME;

            $mail->Password = MAIL_PASSWORD;

            $mail->SMTPSecure =
                PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port = MAIL_PORT;



            // Sender

            $mail->setFrom(
                MAIL_USERNAME,
                MAIL_FROM_NAME
            );


            // Receiver

            $mail->addAddress($email);



            // Email

            $mail->isHTML(true);


            $mail->Subject =
                "Notebook Borrow System OTP";


            $mail->Body = '

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

</head>

<body style="margin:0;padding:0;background:#F6F7FB;font-family:Arial,sans-serif;">

<table
width="100%"
cellpadding="0"
cellspacing="0"
style="padding:40px 0;">

<tr>

<td align="center">

<table

width="600"

cellpadding="0"

cellspacing="0"

style="
background:#FFFFFF;
border-radius:18px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,.08);
">

<!-- Header -->

<tr>

<td

align="center"

style="
background:linear-gradient(135deg,#6C5CE7,#5649C9);
padding:35px;
color:#FFFFFF;
">

<h1 style="margin:0;font-size:28px;">

Notebook Borrow System

</h1>

<p style="margin-top:10px;">

Faculty of Engineering

<br>

Chiang Mai University

</p>

</td>

</tr>

<!-- Body -->

<tr>

<td style="padding:40px;">

<h2 style="color:#2D2D44;">

Hello

</h2>

<p style="font-size:16px;color:#555;line-height:1.8;">

Thank you for registering with

<strong>

Notebook Borrow System

</strong>.

<br><br>

Please use the following OTP code to verify your account.

</p>

<div

style="
margin:35px 0;
text-align:center;
">

<div

style="
display:inline-block;
background:#F3F0FF;
padding:20px 45px;
border-radius:15px;
border:2px dashed #6C5CE7;
">

<span

style="
font-size:38px;
font-weight:bold;
letter-spacing:10px;
color:#6C5CE7;
">

' . $otp . '

</span>

</div>

</div>

<p style="text-align:center;color:#666;">

This OTP is valid for

<strong>

5 minutes

</strong>

</p>

<hr
style="
margin:35px 0;
border:none;
border-top:1px solid #EEEEEE;
">

<p style="font-size:14px;color:#888;line-height:1.8;">

If you did not create this account,

please ignore this email.

</p>

</td>

</tr>

<!-- Footer -->

<tr>

<td

align="center"

style="
background:#F8F9FC;
padding:25px;
font-size:13px;
color:#888;
">

©'.date("Y").'

Notebook Borrow System

<br>

Faculty of Engineering

Chiang Mai University

</td>

</tr>

</table>

</td>

</tr>

</table>

</body>

</html>

';



            $mail->AltBody =
                "Your OTP is: " . $otp;



            $mail->send();



            return true;
        } catch (Exception $e) {


            echo "Mailer Error: ";

            echo $mail->ErrorInfo;

            exit;
        }
    }
}
