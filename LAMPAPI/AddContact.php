<?php

    $inData = getRequestInfo();

    $fName = $inData["fName"];
    $lName = $inData["lName"];
    $number = $inData["number"];
    $email = $inData["email"];
    $userId = $inData["userId"];

    $conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
    if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("INSERT into Contacts (UserId,FirstName,LastName,Phone,Email) VALUES(?,?,?,?,?)");
		$stmt->bind_param("sssss", $userId, $fName, $lName, $number, $email);
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
