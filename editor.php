<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<script src="blog.js"></script>
<link rel="stylesheet" type="text/css" href="blog.css" />
<title>BlogBuddy Editor</title>
</head>
<body>
<?php ?>

	<h2>BlogBuddy Editor</h2>

	<!-- button form -->
	<form name="buttonForm">

		<!-- font select -->
		<select name="font" id="font" onchange="changeFont()">
			<!-- font options -->
			<option value="Courier New">Courier New</option>
			<option value="Comic Sans MS">Comic Sans MS</option>
		</select>

		<!-- color input -->
		<input type="color" name="fontColor" id="fontColor"
			onchange="changeFontColor()">

		<!-- number input -->
		<input type="number" min="1" name="fontSize" id="fontSize"
			onchange="changeFontSize()" value="12">

		<!-- copy + paste text buttons -->
		<input type="button" name="copy" onclick="copyText()"
			value="Copy Text"> <input type="button" name="paste"
			onclick="pasteText()" value="Paste Text">
	</form>

	<!-- email form -->
	<form name="emailForm" method="post" action="email.php">
		<br>

		<!-- editor textarea -->
		<textarea id="textArea" name="textArea" rows="25" cols="56"></textarea>
		<br> <br>

		<!-- post title + category text inputs -->
		<input type="text" name="postTitle" id="postTitle"
			placeholder="post title"> <input type="text" name="postCategory"
			id="posCategory" placeholder="post category">

		<!-- post submit button -->
		<input type="submit" name="post" id="postButton" value="Post">
	</form>

</body>
</html>