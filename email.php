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
// make database connection
$dbc = mysqli_connect ( 'localhost', 'root', '', 'blogbuddy' ) or die ( 'Error connecting to MySQL server.' );

// empty variables for email info
$title;
$category;
$text;
$subject;

if (isset ( $_POST ['post'] )) {
	// if post submit button was pressed
	if (empty ( $_POST ['postTitle'] ) || empty ( $_POST ['postCategory'] ) || empty ( htmlspecialchars ( $_POST ['textArea'] ) )) {
		// making sure both fields are full, if not, it notifies the user
		echo "Please go back and fill out every field.";
	} else {
		// defining variables declared above
		$title = $_POST ['postTitle'];
		$category = $_POST ['postCategory'];
		$text = htmlspecialchars ( $_POST ['textArea'] );
		$subject = "New Blog Post: $title from the category $category";
		
		// querying and getting results from database
		$query = "SELECT * FROM subscriptions";
		$result = mysqli_query ( $dbc, $query ) or die ( 'QUERY Error' );
		
		// sending emails to each subscriber in database
		while ( $row = mysqli_fetch_array ( $result ) ) {
			$to = $row ['email'];
			$name = $row ['name'];
			$msg = "Hi $name! Here is a new blog post: \n" . $text;
			email ( $to, $subject, $msg );
			echo 'Email sent to: ' . $to . '<br />';
		}
		
		// querying and getting results from database
		// adding the post to the database
		$query = "INSERT INTO posts VALUES(0, CURRENT_TIMESTAMP, '$category', '$title', '$text')";
		$result = mysqli_query ( $dbc, $query ) or die ( 'QUERY Error' );
	}
} else if (isset ( $_POST ['share'] )) {
	// if share submit button is pressed, send blog post to destination email
	$to = $_POST ['toEmail'];
	$from = $_POST ['fromEmail'];
	$msg = "Hi $to! Here is a new blog post that $from has shared with you: \n" . $text;
	email ( $to, $subject, $msg );
} else if (isset ( $_POST ['subscribe'] ) || isset ( $_POST ['unsubscribe'] )) {
	// if subscribe submit button is pressed
	if (empty ( $_POST ['subName'] ) || empty ( $_POST ['subEmail'] )) {
		// another empty check
		echo "Please go back and fill out every subscribe/unsubscribe field.";
	} else {
		$query;
		//get name and email from form
		$name = $_POST ['subName'];
		$email = $_POST ['subEmail'];
		
		//either subs or unsubs depending on what submit button was pressed
		if (isset ( $_POST ['subscribe'] )) {
			$query = "INSERT INTO subscriptions VALUES('$name', '$email')";
		} else if (isset ( $_POST ['unsubscribe'] )) {
			$query = "DELETE FROM subscriptions WHERE name='$name' AND email='$email'";
		}
		//getting result
		$result = mysqli_query ( $dbc, $query ) or die ( 'QUERY Error' );
	}
}

// close database connection
mysqli_close ( $dbc );

// email method
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