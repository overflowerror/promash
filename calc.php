<?php
	function getRate($ra, $rb) {
		return 1 / (1 + pow(10, ((abs($rb - $ra) > 400) ? ((($rb - $ra) > 0) ? 400 : -400) : ($rb - $ra)) / 400));
	}

	function getNew($win, $ra, $rate) {
		$k = 10;
		return $ra + $k * ($win - $rate);
	}
?>
