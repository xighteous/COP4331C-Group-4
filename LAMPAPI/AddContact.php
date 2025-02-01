<?php

	/*
 		Adds new contact to the database
   		Input: {firstName,lastName,phoneNumber,emailAddress,userId}
     		Output: {error}
	*/

    	$inData = getRequestInfo();

    	$fName = $inData["firstName"];
    	$lName = $inData["lastName"];
    	$number = $inData["phoneNumber"];
    	$email = $inData["emailAddress"];
    	$userId = $inData["userId"];

	// Main code block
    	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
    	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("INSERT INTO Contacts (UserID,FirstName,LastName,Phone,Email) VALUES(?,?,?,?,?)");
		$stmt->bind_param("sssss", $userId, $fName, $lName, $number, $email);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("");
	}

	// Fetches input data
    	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	// Sends output
	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}

	// Returns $err as error JSON
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>
