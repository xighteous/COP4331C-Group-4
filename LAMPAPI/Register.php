<?php

	/*
		Creates new User in database
  		Input: {firstName,lastName,login,password}
    		Output: {error}
	*/

	$inData = getRequestInfo();

    	$fName = $inData["firstName"];
    	$lName = $inData["lastName"];
    	$login = $inData["login"];
    	$password = $inData["password"];

	// Main code block
    	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("INSERT INTO Users (FirstName,LastName,Login,Password) VALUES(?,?,?,?)");
		$stmt->bind_param("ssss", $fName, $lName, $login, $password);
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
