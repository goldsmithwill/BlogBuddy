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
		<img id="logo" src="images/logo.png">
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


	<div id="search">
		<form name="searchForm" method="post" action="search.php">
			<input type="text" name="postCategory" id="postCategory"
				placeholder="post category"> <br> <input type="text"
				name="postTitle" id="postTitle" placeholder="post title"> <br> <input
				type="submit" name="search" id="searchButton" value="Search">
		</form>
	</div>


</body>
</html>