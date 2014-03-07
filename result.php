<?php
	include("system.php");
	if (!isset($_SESSION['active']))
		die("fische");
	if (!($active = $_SESSION['active']))
		die("fische");
	if (!isset($_SESSION['against']))
		die("fische");
	if (!($against = $_SESSION['against']))
		die("fische");
	if (isset($_GET['left'])) {
		win($active, $against);
		$_SESSION['idLeft'] = true;
	}
	if (isset($_GET['right'])) {
		win($against, $active);	
		$_SESSION['idLeft'] = false;
	}

	header("LOCATION: index.php");

	function win($id, $pid) {

		$ra = getPoints($id);
		$rb = getPoints($pid);
		$ea = getRate($ra, $rb);
		$eb = getRate($rb, $ra);
		$newRa = getNew(1, $ra, $ea);
		$newRb = getNew(0, $rb, $eb);

		$sql = "UPDATE pros SET value=" . intval($newRa) . " WHERE id=" . intval($id);
		$result = mysql_query($sql);
		
		$sql = "UPDATE pros SET value=" . intval($newRb) . " WHERE id=" . intval($pid);
		$result = mysql_query($sql);
	}
		
		
?>
