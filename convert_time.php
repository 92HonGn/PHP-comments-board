<?php

function convert_time( $time ){
	$time_diff = 8;
	return date('Y-m-d H:i:s', ( strtotime($time) + $time_diff * 3600) );
};

?>