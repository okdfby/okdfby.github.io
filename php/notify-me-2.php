<?php

header('content-type: application/json');

	$o = new stdClass();
	$o->status = 'success';
	echo json_encode($o);

	$email_to = "prokdfbsu@gmail.com"; // Replace by your email address
	$email = $_POST["email"];
	$text = "Новое письмо от $email";

	$headers = "MIME-Version: 1.0" . "\r\n"; 
	$headers .= "Content-type:text/html; charset=utf-8" . "\r\n"; 
	$headers .= "From:<$email>\n";

	mail($email_to, "Message", $text, $headers);

?>
