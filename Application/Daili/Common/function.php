<?php
	
	function islogin(){
		$uid = $_SESSION['did'];
		return $uid;
	}
?>