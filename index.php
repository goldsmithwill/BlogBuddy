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
	<!--left column div -->
	<div id="leftColumn">

		<!-- blogbuddy logo -->
		<img id="logo" alt="BlogBuddy Logo" src="images/logo.png">

		<!-- email form -->
		<form name="emailForm" method="post" action="email.php">

			<!-- from and to email fields -->
			<input type="text" name="fromEmail" placeholder="your email"> <input
				type="text" name="toEmail" placeholder="their email">

			<!-- share submit button -->
			<input type="submit" name="share" id="shareButton" value="Share"> <br>
			<br>

			<!-- sub name + email fields -->
			<input type="text" name="subName" id="subscriberName"
				placeholder="your name"> <input type="text" name="subEmail"
				placeholder="your email">

			<!-- subscribe + unsubscribe submit buttons -->
			<input type="submit" name="subscribe" id="subscribeButton"
				value="Subscribe"> <input type="submit" name="unsubscribe"
				id="unsubscribeButton" value="Unsubscribe">

		</form>

	</div>


	<!--blog post stream div -->
	<div id="stream">

<?php
// connecting to, querying, and getting results from database
$dbc = mysqli_connect ( 'localhost', 'root', '', 'blogbuddy' ) or die ( 'Error connecting to MySQL server.' );
$query = "SELECT * FROM posts";
$result = mysqli_query ( $dbc, $query );

// empty resultData array
$resultData = array ();

if (empty ( $_POST )) {
	// executes when the document is first run
	// loads all blog posts into stream
	while ( $row = mysqli_fetch_array ( $result ) ) {
		$resultData [] = $row;
	}
	loadPosts ( array_column ( $resultData, 'category' ), $resultData );
}

// loadPosts function
function loadPosts($filter, $resultData) {
	// empty posts array
	$posts = array ();
	
	foreach ( $resultData as $row ) {
		if (in_array ( $row ['category'], $filter )) {
			// if the post is allowed by the filter, add it to the array
			$posts [] = array (
					$row ['id'],
					$row ['timestamp'],
					$row ['category'],
					$row ['title'],
					$row ['content'] 
			);
		}
	}
	// reverse posts array order
	$posts = array_reverse ( $posts );
	
	// actually adding posts to GUI
	foreach ( $posts as $post ) {
		echo '<article>';
		echo '<h3>' . $post [3] . '</h3>';
		echo '<h4>posted at ' . $post [1] . ' in the category ' . $post [2] . '</h4>';
		echo '<p id="postContent' . $post [0] . '">' . $post [4] . '</p>';
		echo '</article>';
	}
}

// close database connection
mysqli_close ( $dbc );
?>

</div>
	<!-- search div -->
	<div id="search">

		<!-- search form -->
		<form name="searchForm" method="post" action="search.php">

			<!-- post title field-->
			<input type="text" name="postTitle" id="postTitle"
				placeholder="post title"> <br>

			<!-- search submit button-->
			<input type="submit" name="search" id="searchButton" value="Search">
		</form>

		<!-- filter categories form -->
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<?php
		
		if (empty ( $_POST )) {
			// executes when document is first run
			// connect to, query, and get results from database
			$dbc = mysqli_connect ( 'localhost', 'root', '', 'blogbuddy' ) or die ( 'Error connecting to MySQL server.' );
			$query = "SELECT * FROM posts";
			$result = mysqli_query ( $dbc, $query );
			// empty category + id arrays
			$categories = array ();
			$ids = array ();
			
			foreach ( $resultData as $row ) {
				if (! in_array ( $row ['category'], $categories )) {
					// if this category is not already in the categories array, then add it to the array
					$categories [] = $row ['category'];
					$ids [] = $row ['id'];
				}
			}
			
			// add category checkboxes to GUI
			for($i = 0; $i < sizeof ( $categories ); $i ++) {
				echo '<input type="checkbox" value="' . $ids [$i] . '" name="checkbox' . $ids [$i] . '"/>';
				echo $categories [$i];
				echo '<br />';
			}
			// close database connection
			mysqli_close ( $dbc );
		}
		
		if (isset ( $_POST ['categoryFilter'] )) {
			// if the category filter submit button is pressed
			// empty filter array
			$filter = array ();
			
			// filling/creating filter
			for($i = 0; $i < sizeof ( $_POST ) - 1; $i ++) {
				$filter [] = $_POST ['checkbox' + $i];
			}
			
			var_dump ( $filter );
			// loading posts
			loadPosts ( $filter, $resultData );
		}
		
		?>
		
		
			<input type="submit" name="categoryFilter" onclick="deleteArticles()"
				value="Filter Categories">
		</form>
	</div>
</body>
</html>