<?php
header('Access-Control-Allow-Origin:*');
header('Control-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include("function.php");


	$getUser_List = getUser_Record();
	echo $getUser_List;

	$carRecord = getRecord();
	echo $carRecord;



	
	/*$data = [
		'status' => 405,
		'message' => "Method Not Allowed",
	];
	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($data);*/


