<?php

	/*
		Updates Contact info with new values
  		Input: {firstName,lastName,phoneNumber,emailAddress,ID}
    		Output: {error}
	*/

	$inData = getRequestInfo();

    	$firstName = $inData["firstName"];
    	$lastName = $inData["lastName"];
    	$phoneNumber = $inData["phoneNumber"];
    	$emailAddress = $inData["emailAddress"];
    	$ID = $inData["ID"];

	// Main code block
    	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
    	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("UPDATE Contacts SET FirstName=?, LastName=?, Phone=?, Email=? WHERE ID=?");
		$stmt->bind_param("sssssi", $firstName, $lastName, $phoneNumber, $emailAddress, $ID);
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
