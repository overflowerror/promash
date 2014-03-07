<!DOCTYPE html>
<html>
	<head>
		<title>ProMash</title>
	</head>
	<body style="padding: 0; background-color: #ddd">
		<h1 style="position: absolute; left: 0px; top:0px; width: 100%; text-align: center; height: 80px; margin: 0; padding-top: 50px; background-color: #8e0b11; color: #fff; ">ProMash</h1>

		<?php
			include("system.php");

			if (!isset($_SESSION['active']))
				resetParing();
			if (!$_SESSION['active'])
				$id = getRandom();
			else {
				if ($_SESSION['idLeft']) {
					$id = $_SESSION['active'];
				} else {
					$id = $_SESSION['against'];
				}
			}
			$i = 0;
			while (true) {
				echo "<!-- $i -->";
				if ($i > (intval(getNumberOfPros()) / 2)) {
					resetParing();
					$i = 0;
					$id = getRandom();
				}
				$pid = intval(getPartner($id));
				
				echo "<!-- $id : $pid -->";
				
				if ($id == $pid)
					continue;
				if ($pid === false)
					$id = intval(getNextId($id));
				else 
					break;
				$i++;
			}
			setPartners($id, $pid);
			if (!$_SESSION['idLeft']) {
				$tmp = $id;
				$id = $pid;
				$pid = $tmp;
			}
			$_SESSION['active'] = $id;
			$_SESSION['against'] = $pid;
			$leftImg = getImage($id);
			$rightImg = getImage($pid);
			$leftRate = getRateByIds($id, $pid);
			$rightRate = 1 - $leftRate;
		?>
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<div style="text-align: center; font-size: 20px; font-weight: bold;">
			Who's better? Click to choose.
		</div>
		<br /><br /><br /><br />
		<div style="text-align: center">
			<div style="margin: auto auto;">
				<div style="display: inline; ">	
					<a href="result.php?left">
						<img style="height: 150px;" src="images/<?php echo $leftImg; ?>" />
					</a>
				</div>
				<div style="display: inline; font-size: 40px; position: relative; top: -55px;">
					or
				</div>
				<div style="display: inline">
					<a href="result.php?right">
						<img style="height: 150px;" src="images/<?php echo $rightImg; ?>" />
					</a>
				</div>
			</div>
		</div>
		<div style="display: none;">
			Left: <?php echo $leftRate * 100; ?> %<br />
			Right: <?php echo $rightRate * 100; ?> %<br />
		</div>

		<div style="margin: 0; position: absolute; left: 0px; bottom: 0px; width: 100%; height: 25px; text-align: center; background-color: #8e0b11; color: #fff;">
<a style="color: #fff" href="http://en.wikipedia.org/wiki/Elo_rating_system">Elo rating</a> - <a style="color: #fff" href="http://htlinn.ac.at">Image copyright</a> - You don't want to rate the current image? Just press F5.
		</div>
	</body>
</html>
