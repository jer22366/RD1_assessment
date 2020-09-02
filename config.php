<?php
	$link=mysqli_connect('localhost','root','root','weatherDB','8889') or die(mysqli_connect_error());
	$result = mysqli_query ( $link, "set names utf8" );
	
	

?>