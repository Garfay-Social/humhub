<!DOCTYPE html>
<html>
<style>
h2 {
    font-size: xx-large;
    text-align: center;
}

h3{
    font-size: large;
}

.row{
    width: 70%;
    margin: auto;
}
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Form</title>
</head>

<div class="row">
	<div class="col-md-12">
     	<div class="panel panel-default">
			<div class="panel-body">
            	
                <h2> Welcome To Garfay Social! <h2>
                
                <h3> Our goal is to provide a place where people and businesses can connect and where customers can find out more information about businesses.
This site should allow for transparent and constructive interactions between customers and businesses. Businesses will be able to maintain a professional presence, engage with their audience, and gain insights from reviews.
The platform should ensure security by preserving the confidentiality and integrity of user data. <h3>
                <h1>Contact Us</h1>

     			<form class="form-group" method="post">
				  <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                  <label class="control-label">Name:</label>
                  <input type="text" id="name" class="form-control" name="name" placeholder="Enter Full Name" required><br>

                  <label class="control-label">Email:</label>
                  <input type="email" id="email" class="form-control" name="email" placeholder="Enter Email" required><br>

                  <label class="control-label">Message:</label>
                  <input type="text" id="message" class="form-control" name="message" placeholder="Enter Message" required><br>

                  <input class="btn btn-primary btn-md pull-left" type="submit" name="submit" value="Send Email">
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

	require '../vendor/phpmailer/phpmailer/src/Exception.php';
	require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require '../vendor/phpmailer/phpmailer/src/SMTP.php';

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
		$mail->Username = 'garfayinc@gmail.com';  //SMTP username, change to garfay email
		$mail->Password = 'puwblhqpeqauwcnz';  // SMPTP password, change to garfay password
		$mail->Port = 587;  // Port


		// Content
		$mail->isHTML(true);
		$mail->Subject = 'Contact Us Form';
		$mail->Body = $message;
		$mail->AltBody = $message;

		//to garfay email
		// user email and name
		$mail->setFrom($email, $name);

		// address sent to, change this to garfay on server
		$mail->addAddress('garfayinc@gmail.com', 'Recipient Name');

		// Send 
		$mail->send();
		
		$mail->clearAllRecipients();

		//send to sender
		$mail->addAddress($email, 'Recipient Name');
		$mail->send();

        echo "<div class='notification' id='notification'>Email sent successfully</div>";
		
		
	} catch (Exception $e) {
		echo "Message could not be sent. {$mail->ErrorInfo}";
	}

}

?> 

<!DOCTYPE html>
<html>
<head>
    <title>Popup </title>
    <style>
       
        .notification {
            width: 30%;
            margin: auto; 
            background-color: white;
            padding: 45px;
            border: 1px solid #ddd;
            border-radius: 100px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 1);
            text-align: center;
            font-size: 35px;
        }


    </style>
</head>
<body>

<script>
    
    window.onload = function() {
        var notification = document.getElementById('notification');

        if (notification) {
            notification.style.display = 'block';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 5000); 

        }
    };
</script>

</body>
</html>
