<?php

  function sendMail($toEmail, $subjectName, $message) {

    $fromEmail = 'ritikkanotra1@gmail.com';
    // $toEmail = 'ritikkanotra@gmail.com';
    // $subjectName = 'hello';
    // $message = 'hello';

    $to = $toEmail;
    $subject = $subjectName;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: '.'Agastya Reports'.'<'.$fromEmail.'>' . "\r\n".'Reply-To: Agastya Reports<'.$fromEmail.'>'."\r\n" . 'X-Mailer: PHP/' . phpversion();
    $message = '<!doctype html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport"
					  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
				<meta http-equiv="X-UA-Compatible" content="ie=edge">
				<title>Document</title>
			</head>
			<body>
			<span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">'.$message.'</span>
				<div class="container">
                 '.$message.'<br/><br>
                  '.'~ Team Agastya'.'
				</div>
			</body>
			</html>';
    $result = @mail($to, $subject, $message, $headers);
    
    echo $result;

    echo '<script>alert("Email sent successfully !")</script>';
    // echo '<script>window.location.href="index.php";</script>';

  }
  
//   sendMail('ritikkanotra@gmail.com', 'hi', 'hello');

?>