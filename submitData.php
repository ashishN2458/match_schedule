<?php
include('config.php');

if (empty($_POST)) {
	exit;
}

$err = array();
try {
    $teamA = $_POST['teamA'];
	$teamB = $_POST['teamB'];
	$date = $_POST['date'];
	
	
	$conn = mysqli_connect("localhost","root","","badvegroup");

	$sql = mysqli_query($conn,"INSERT INTO information (`teamA`, `teamB`, `date`)
	VALUES ('$teamA', '$teamB', '$date')");
		
	$id = mysqli_insert_id($conn);
	
	$message = " Data created successfully into database";
	array_push($err, array("status"=>"success", "message"=>$message));
	//header('Location: http://localhost/badvegroup/index.php');
	
}
catch (phpmailerException $e) {
	$message =  $e->errorMessage(); //Pretty error messages from PHPMailer
	array_push($err, array("status"=>"failed", "message"=>$message)); 
}

	$response = json_encode(array("id"=>$id,"teamA"=>$teamA,"teamB"=>$teamB,"date"=>$date,"msg"=>$err));   
	echo $response;
	//$conn = null; 
?>