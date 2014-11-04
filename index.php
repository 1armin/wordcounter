<?php

	
//	Author: Armin Mohammadian
//	Version: 1.0.0
//	URI: http://1armin.com
//	Description: word counter script
	
// Include utility files
require_once 'config.php';
?>
<!DOCTYPE html>
<html>

<head>
<title>word counter</title>
<style type="text/css">
	h1 {
		text-align: center;
		color: #333;
		font-size: 36px;
		margin: 50px 0 30px 0;
	}
	p {
		text-align: center;
		color: #444;
		font-size: 14px;
		margin: 10px 0;
	}
	textarea {
		width: 70%;
		height: 300px;
		display: block;
		margin: 20px auto;
	}
	input[type=submit] {
		display: block;
		margin: 0 auto;
	}
	input[type=file] {
		display: block;
		margin: 20px auto;
	}
</style>
</head>
<body>
<h1>word counter</h1>
<p>insert your text in below box</p>
	<form name="wordcounter" action="wordcounter.php" method="post">
		<textarea name="text"></textarea>
		<input type="submit" value="start counting">
	</form>
<p>also you can count words from pdf and txt files.<br>note: the files must placed in upload folder in project folder.</p>
	<form name="wordcounterfile" action="wordcounterfile.php" method="post" enctype="multipart/form-data">
		<input type="file" name="file">
		<input type="submit" value="start counting file">
	</form>

	<br><p><a href="<?php print(SITE_URL); ?>/analyse.php">view analyse page</a></p>
</body>
</html>