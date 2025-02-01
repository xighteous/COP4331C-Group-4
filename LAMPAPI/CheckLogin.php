<?php

    /*
        Verifies that login is not already in use
        Input: {login}
        Output: {error}
    */

    $inData = getRequestInfo();

    $login = $inData["login"];

    // Main code block
    $conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
    if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$error = "";

		$stmt = $conn->prepare("SELECT Login FROM Users WHERE Login=?");
		$stmt->bind_param("s", $login);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->fetch_assoc())
		{
			$error = "Login already in use";
		}

		$stmt->close();
		$conn->close();
		returnWithError( $error );
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
	
    // Returns input as error JSON
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>