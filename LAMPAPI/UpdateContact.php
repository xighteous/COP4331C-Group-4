<?php

    $inData = getRequestInfo();

    $fName = $inData["fName"];
    $lName = $inData["lName"];
    $number = $inData["number"];
    $email = $inData["email"];
    $userId = $inData["userId"];
	$ID = $inData["ID"];

    $conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
    if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("UPDATE Contacts SET fName=?, lName=?, number=?, email=? WHERE userId=? AND ID=?");
		$stmt->bind_param("ssssss", $fName, $lName, $number, $email, $userId, $ID);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("");
	}

    function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>