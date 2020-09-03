<?php
	$link=mysqli_connect('localhost','root','root','weatherDB','8889') or die(mysqli_connect_error());
	$result = mysqli_query ( $link, "set names utf8" );
	
	function week($day){
		switch($day){
			case 0: 
				echo "一";
				break;
			case 1: 
				echo "二";
				break;
			case 2: 
				echo "三";
				break;
			case 3: 
				echo "四";
				break;
			case 4: 
				echo "五";
				break;
			case 5: 
				echo "六";
				break;
			case 6: 
				echo "日";
				break;
		}
		
	}

?>