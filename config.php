<?php
	$link=mysqli_connect('localhost','root','','weatherdb',) or die(mysqli_connect_error());
	$result = mysqli_query ( $link, "set names utf8" );
	
	function week($day){
		switch($day){
			case 0: 
				echo "星期一";
				break;
			case 1: 
				echo "星期二";
				break;
			case 2: 
				echo "星期三";
				break;
			case 3: 
				echo "星期四";
				break;
			case 4: 
				echo "星期五";
				break;
			case 5: 
				echo "星期六";
				break;
			case 6: 
				echo "星期日";
				break;
		}
		
	}

?>