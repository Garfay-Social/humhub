<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Form</title>
</head>

<div class="row">
	<div class="col-md-12">
     	<div class="panel panel-default">
			<div class="panel-body">
            	{{ content }}
                <h1>Contact Us</h1>

     			<form class="form-group" method="post">
				  <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                  <label class="control-label">Name:</label>
                  <input type="text" id="name" class="form-control" name="name" placeholder="Enter Full Name" required><br>

                  <label class="control-label">Email:</label>
                  <input type="email" id="email" class="form-control" name="email" placeholder="Enter Email" required><br>

                  <label class="control-label">Message:</label>
                  <input type="text" id="message" class="form-control" name="message" placeholder="Enter Message" required><br>

                  <input type="submit" name="submit" value="Send Email">
     			</form>

        	</div>
    	</div>
	</div>
</div>

</html>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['submit'])) {

	require 'C:\xampp\vendor\phpmailer\phpmailer\src\Exception.php';
	require 'C:\xampp\vendor\phpmailer\phpmailer\src\PHPMailer.php';
	require 'C:\xampp\vendor\phpmailer\phpmailer\src\SMTP.php';

	//fetch data
	$name = $_POST['name'];
    $email = $_POST['email'];
    $message= $_POST['message'];


	$mail = new PHPMailer(true);

	try {
		// config smtp
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';  
		$mail->SMTPAuth = true;  
		$mail->Username = 'vincario098@gmail.com';  //SMTP username
		$mail->Password = 'zqmgssnfhaodeecg';  // SMPTP password
		$mail->Port = 587;  // Port

		// user email and name
		$mail->setFrom($email, $name);

		// address sent to
		$mail->addAddress('vinsondinh123@gmail.com', 'Recipient Name');

		// Content
		$mail->isHTML(true);
		$mail->Subject = 'Contact Us Form';
		$mail->Body = $message;
		$mail->AltBody = $message;

		// Send 
		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

?> 
