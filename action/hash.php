<?php
class hash{
function myhash($pass){
	//$salt 	= 	'827ccb0eea8a706c4c34a16891f84e7b';
	//$p 		=	hash('sha256',$pass.$salt);
	$p=md5($pass);
	return $p;
	}
}
$hash = new hash();
?>