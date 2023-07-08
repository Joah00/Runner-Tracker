<?php
require 'connection.php';

function error422( $message ) {
  $data = [
    'status' => 422,
    'message' => $message,
  ];
  header( "HTTP/1.0 422 Unprocessable Entity" );
  echo json_encode( $data );
  exit();
}


function getUser_Record() {
  global $conn;

  $sql = "SELECT * FROM user";
  $result = $conn->query( $sql );

  if ( $result->num_rows > 0 ) {
    $getUser_Record = array();

    while ( $row = $result->fetch_assoc() ) {
      $getUser_Record[] = array(
        "User ID: " => $row[ "userid" ],
        "Username: " => $row[ "username" ],
        "Email: " => $row[ "email" ],
        "Password: " => $row[ "password" ],
      );
    }
    return json_encode( $getUser_Record );
  } else
    $data = [
      'status' => 505,
      'message' => "No Data",
    ];

  header( "HTTP/1.0 505 No Data" );
  return json_encode( $data );
}



function getRecord() {
  global $conn;

  $sql = "SELECT * FROM record";
  $result = $conn->query( $sql );

  if ( $result->num_rows > 0 ) {
    $getRecord = array();

    while ( $row = $result->fetch_assoc() ) {
      $getRecord[] = array(
        "Record ID: " => $row[ "record_id" ],
        "User ID: " => $row[ "user_id" ],
        "Start Time: " => $row[ "time_start" ],
		 "End Time: " => $row[ "time_end" ],
		  "Longitude: " => $row[ "longitude" ],
		  "Latitude: " => $row[ "latitude" ],
		  "Coordinate: " => $row[ "coordinate" ],
		  "Speed: " => $row[ "speed" ],
		  "Distance: " => $row[ "distance" ],
		  "Elapsed Time: " => $row[ "eslapsed_time" ],
		  "Age: " => $row[ "age" ],
		  "Gender: " => $row[ "gender" ],
		  "Height: " => $row[ "height" ],
		  "Weight: " => $row[ "weight" ],
      );
    }
    return json_encode( $getRecord );
  } else
    $data = [
      'status' => 505,
      'message' => "No Data",
    ];

  header( "HTTP/1.0 505 No Data" );
  return json_encode( $data );
}


    ?>
