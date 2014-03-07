<?php
	session_start();
	include("connect.php");
	include("calc.php");
	
	$staticNumberOfPros = 0;
	
	function getRandom() {
		return rand(1, getNumberOfPros());
	}
	function getNumberOfPros() {
		if ($staticNumberOfPros > 0)
			return $staticNumberOfPros;
		
		$sql = "SELECT id FROM pros";
		$resource = mysql_query($sql);
		$staticNumberOfPros = mysql_num_rows($resource);
		return $staticNumberOfPros;
	}
	function resetParing() {
		$_SESSION['idLeft'] = true;
		$_SESSION['active'] = false;
		$_SESSION['against'] = false;
		$_SESSION['pArray'] = array();
		$_SESSION['debug'] = array();
	}
	function setPartners($id, $pid) {
		$hash = getHash($id, $pid);
		//$_SESSION['debug'][] = array("setPartners", $id, $pid, $hash);
		$_SESSION['pArray'][] = $hash;
	}
	function getNextId($id) {
		$number = getNumberOfPros();
		$id++;
		if ($id >= $number)
			$id -= $number;
		return $id;
	}
	function getPartner($id) {
		$id = intval($id);
		$sql = "SELECT id, value FROM pros ORDER BY value";
		$resource = mysql_query($sql);
		$all = array();
		$i = 0;
		$activ = -1;
		while ($row = mysql_fetch_object($resource)) {
			if (intval($row->id) == $id) 
				$activ = $i;
			$all[] = $row;
			$i++;
		}
		if ($activ < 0) {
			echo "something happend:\n\n";
			echo "$i, $activ, $id";
			die();
		}
		
		
		$number = getNumberOfPros();
		$up = true;
		$offset = 1;
		$i = 0;
		do {
			if ($i > ($number / 4 * 3))
				return false;
			$newIndex = $activ + (($up) ? ($offset) : (-$offset));
			$newIndex %= $number;
			
			$offset += ($up) ? (0) : (1);
			$up = !$up;
			$pid = $all[$newIndex]->id;
			
			if ($id == $pid) {
				echo "something happend:\n\n";
				echo "$i, $number, $activ, " . intval($up) . ", $offset";
				die();
			}
			
			$i++;
		} while (allreadyPartner($id, $pid));
		return $pid;
	}

	function allreadyPartner($id, $pid) {
		foreach ($_SESSION['pArray'] as $hash)
			if ($hash == getHash($id, $pid)) 
				return true;
		return false;
	}
	function getHash($id, $pid) {
		return $id ^ $pid;
	}
	function getImage($id) {
		$sql = "SELECT image FROM pros WHERE id = " . intval($id);
		$result = mysql_query($sql);
		$row = mysql_fetch_object($result);
		return $row->image;
	}
	function getPoints($id) {
		$sql = "SELECT value FROM pros WHERE id = " . intval($id);
		$result = mysql_query($sql);
		$row = mysql_fetch_object($result);
		return $row->value;
	}
	function getRateByIds($id, $pid) {
		$ra = getPoints($id);
		$rb = getPoints($pid);
		return getRate($ra, $rb);
	}
?>
