<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('slowEquals')){ //https://crackstation.net/hashing-security.htm
		function slowEquals($a, $b){ //No time-based attacks
			$a = unpack('C*', $a);
			$b = unpack('C*', $b);
			$diff = count($a) ^ count($b);
			for($i = 1; $i < count($a) && $i < count($b)+1; $i++)
				$diff |= $a[$i] ^ $b[$i];	
			return $diff == 0;
		}
	}