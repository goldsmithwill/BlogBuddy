<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<script src="blog.js">
	
</script>
<link rel="stylesheet" type="text/css" href="blog.css" />
<title>BlogBuddy</title>
</head>
<body>
	<div id="leftColumn">
		<img id="logo" alt="BlogBuddy Logo" src="images/logo.png">
		<!-- 	<a href="editor.php">Go to editor</a> -->

		<form name="emailForm" method="post" action="email.php">
			<input type="text" name="fromEmail" placeholder="your email"> <input
				type="text" name="toEmail" placeholder="their email"> <input
				type="submit" name="share" id="shareButton" value="Share"> <br> <br>
			<input type="text" name="subName" id="subscriberName"
				placeholder="your name"> <input type="text" name="subEmail"
				placeholder="your email"> <input type="submit" name="subscribe"
				id="subscribeButton" value="Subscribe"><input type="submit"
				name="unsubscribe" id="unsubscribeButton" value="Unsubscribe">

		</form>

	</div>

	<div id="stream">

<?php
$dbc = mysqli_connect ( 'localhost', 'root', '', 'blogbuddy' ) or die ( 'Error connecting to MySQL server.' );
$query = "SELECT * FROM posts";
$result = mysqli_query ( $dbc, $query );
$resultData = array ();

if (empty ( $_POST )) {
	
	while ( $row = mysqli_fetch_array ( $result ) ) {
		$resultData [] = $row;
	}
	
	loadPosts ( array_column ( $resultData, 'category' ), $resultData );
}
function loadPosts($filter, $resultData) {
	$posts = array ();
	
	// var_dump ( mysqli_fetch_array ( $result ) );
	
	foreach ( $resultData as $row ) {
		if (in_array ( $row ['category'], $filter )) {
			$posts [] = array (
					$row ['id'],
					$row ['timestamp'],
					$row ['category'],
					$row ['title'],
					$row ['content'] 
			);
		}
	}
	
	$posts = array_reverse ( $posts );
	
	foreach ( $posts as $post ) {
		echo '<article>';
		echo '<h3>' . $post [3] . '</h3>';
		echo '<h4>posted at ' . $post [1] . ' in the category ' . $post [2] . '</h4>';
		echo '<p id="postContent' . $post [0] . '">' . $post [4] . '</p>';
		echo '</article>';
	}
}

mysqli_close ( $dbc );
?>

</div>

	<div id="search">
		<form name="searchForm" method="post" action="search.php">
			<input type="text" name="postTitle" id="postTitle"
				placeholder="post title"> <br> <input type="submit" name="search"
				id="searchButton" value="Search">
		</form>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<?php
		
		if (empty ( $_POST )) {
			$dbc = mysqli_connect ( 'localhost', 'root', '', 'blogbuddy' ) or die ( 'Error connecting to MySQL server.' );
			
			$query = "SELECT * FROM posts";
			$result = mysqli_query ( $dbc, $query );
			$categories = array ();
			$ids = array ();
			
			foreach ( $resultData as $row ) {
				if (! in_array ( $row ['category'], $categories )) {
					$categories [] = $row ['category'];
					$ids [] = $row ['id'];
				}
			}
			
			for($i = 0; $i < sizeof ( $categories ); $i ++) {
				echo '<input type="checkbox" value="' . $ids [$i] . '" name="checkbox' . $ids [$i] . '"/>';
				echo $categories [$i];
				echo '<br />';
			}
			
			mysqli_close ( $dbc );
		}
		
		if (isset ( $_POST ['categoryFilter'] )) {
			$filter = array ();
			for($i = 0; $i < sizeof ( $_POST ) - 1; $i ++) {
				$filter [] = $_POST ['checkbox' + $i];
			}
			var_dump ( $filter );
			loadPosts ( $filter, $resultData );
		}
		
		?>
		
		
			<input type="submit" name="categoryFilter" onclick="deleteArticles()"
				value="Filter Categories">
		</form>
	</div>
</body>
</html>