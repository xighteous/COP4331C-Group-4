<?php

	/*
		Returns User info associated with login and password
  		Input: {login,password}
    		Output: {firstName,lastName,userId}
	*/

	$inData = getRequestInfo();

	$login = $inData["login"];
	$password = $inData["password"];

	// Main code block
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331"); 	
	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("SELECT * FROM Users WHERE Login=? AND Password =?");
		$stmt->bind_param("ss", $login, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc()  )
		{
			returnWithInfo( $row['FirstName'], $row['LastName'], $row['ID'] );
		}
		else
		{
			returnWithError("No Records Found");
		}

		$stmt->close();
		$conn->close();
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
		$retValue = '{"userId":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	// Returns User info as JSON
	function returnWithInfo( $firstName, $lastName, $userId )
	{
		$retValue = '{"userId":' . $userId . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
