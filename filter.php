<?php
$a = file_get_contents($_GET['filename']);
$b = explode(PHP_EOL, $a);
$i = 0;
$mode = $_GET['mode'];
foreach ($b as $key => $value) {
	if($mode == "saldo") {
		if(preg_match('#undefined#', $value)<1 && preg_match('#Status : Active#', $value)>0 && preg_match('#Status : Deactive#', $value)<1){
			print "$i. $value<br/>";
			$i++;
		}
	} else if($mode == "rewards") {
		if(preg_match('#undefined#', $value)<1 && preg_match('#Status : Active#', $value)>0 && preg_match('#Status : Deactive#', $value)<1 && preg_match('#Reward Point#', $value)>0){
			print "$i. $value<br/>";
			$i++;
		}
	}
}
