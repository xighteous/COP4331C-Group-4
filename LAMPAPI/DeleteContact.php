<?php

	/*
		Deletes contact from database
		Input: {userId, ID}
		Output: {error}
	*/

    	$inData = getRequestInfo();

    	$ID = $inData["ID"];
	$userId = $inData["userId"];

    	// Main code block
    	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE ID=? AND UserID=?");
		$stmt->bind_param("ii", $ID, $userId);
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
