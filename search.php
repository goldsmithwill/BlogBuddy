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
	<a href="index.php"></a>
<?php
// declaring DOM
$dom = new DOMDocument ();

// getting title and category form answers
$title = $_POST ['postTitle'];
$category = $_POST ['postCategory'];

// connecting to, querying, and getting results + info from database
$dbc = mysqli_connect ( 'localhost', 'root', '', 'blogbuddy' ) or die ( 'Error connecting to MySQL server.' );
$query = "SELECT content FROM posts WHERE title='$title'";
$result = mysqli_query ( $dbc, $query ) or die ( 'QUERY Error' );
$row = mysqli_fetch_array ( $result );
$content = $row ['content'];

//echoing content
echo ($content);

//closing database connection
mysqli_close ( $dbc );
?>

</body>
</html>