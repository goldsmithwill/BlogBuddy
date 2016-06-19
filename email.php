<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<script src="blog.js"> </script>
<link rel="stylesheet" type="text/css" href="blog.css" />
<title>BlogBuddy</title>
</head>
<body>
	<h2>BlogBuddy</h2>

<?php
$title = $_POST ['postTitle'];
$category = $_POST ['postCategory'];
$text = htmlspecialchars ( $_POST ['textArea'] );
$subject = "New Blog Post: $title from the category $category";
$dbc = mysqli_connect ( 'localhost', 'root', '', 'blogbuddy' ) or die ( 'Error connecting to MySQL server.' );

if (isset ( $_POST ['post'] )) {
	
	$query = "SELECT * FROM subscriptions";
	
	$result = mysqli_query ( $dbc, $query ) or die ( 'QUERY Error' );
	
	while ( $row = mysqli_fetch_array ( $result ) ) {
		$to = $row ['email'];
		$name = $row ['name'];
		$msg = "Hi $name! Here is a new blog post: \n" . $text;
		email ( $to, $subject, $msg );
		echo 'Email sent to: ' . $to . '<br />';
	}
	
	// echo (time ());
	$query = "INSERT INTO posts VALUES(CURRENT_TIMESTAMP, '$category', '$title', '$text')";
	$result = mysqli_query ( $dbc, $query ) or die ( 'QUERY Error' );
} else if (isset ( $_POST ['share'] )) {
	$to = $_POST ['toEmail'];
	$from = $_POST ['fromEmail'];
	$msg = "Hi $to! Here is a new blog post that $from has shared with you: \n" . $text;
	email ( $to, $subject, $msg );
} else if (isset ( $_POST ['subscribe'] )) {
	
	$name = $_POST ['subName'];
	$email = $_POST ['subEmail'];
	
	$query = "INSERT INTO subscriptions VALUES('$name', '$email')";
	
	$result = mysqli_query ( $dbc, $query ) or die ( 'QUERY Error' );
}

mysqli_close ( $dbc );
function email($to, $subject, $msg) {
	// Deployment environment!
	// mail($to, $subject, $msg);
	
	// Development environment only!
	require_once 'phpmailer-master/phpmailerautoload.php';
	$mail = new PHPMailer ();
	$mail->isSMTP ();
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->Username = 'willblogbuddy@gmail.com';
	$mail->Password = 'blogbuddy';
	$mail->setFrom ( 'willblogbuddy@gmail.com' );
	$mail->addAddress ( $to );
	$mail->Subject = $subject;
	$mail->Body = $msg;
	
	// send the message, check for errors
	if (! $mail->send ()) {
		echo "ERROR: " . $mail->ErrorInfo;
	} else {
		echo "SUCCESS";
	}
}

?>
</body>
</html>