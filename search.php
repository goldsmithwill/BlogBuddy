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
$dom = new DOMDocument ();
$title = $_POST ['postTitle'];
$category = $_POST ['postCategory'];
$dbc = mysqli_connect ( 'localhost', 'root', '', 'blogbuddy' ) or die ( 'Error connecting to MySQL server.' );
$query = "SELECT content FROM posts WHERE category='$category' AND title='$title'";

$result = mysqli_query ( $dbc, $query ) or die ( 'QUERY Error' );

$row = mysqli_fetch_array ( $result );
$content = $row ['content'];

echo ($content);

mysqli_close ( $dbc );
// $dom->getElementsByTagName('textarea');
?>

</body>
</html>