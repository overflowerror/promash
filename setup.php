<?php
	die("!!!");
	include("connect.php");
	$sql = "DROP TABLE pros";
	$result = mysql_query($sql);
	echo mysql_error();
	$sql = "CREATE TABLE pros ( id INT AUTO_INCREMENT, image TEXT, value INT, PRIMARY KEY ( id ))";
	$result = mysql_query($sql);
	echo mysql_error();
	$array = scandir("images");
	foreach ($array as $i) {
		if ($i == ".")
			continue;
		if ($i == "..")
			continue;
		echo $i . "<br />";
		$sql = "INSERT INTO pros (image, value) VALUES ('" . $i . "', 1024)";
		mysql_query($sql);
	}
?>
