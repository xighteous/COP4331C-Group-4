<?php

	/*
		Returns list of info for all Contacts with similar first- or last-name to search
  		Input: {search,userId}
    		Output: {results:[{firstName,lastName,phoneNumber,emailAddress,ID},...],error}
	*/

    	$inData = getRequestInfo();

	$search = $inData["search"];
	$userId = $inData["userId"];

    	$searchResults = "";
    	$searchCount = 0;

	// Main code block
    	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("SELECT * FROM Contacts WHERE (FirstName LIKE ? OR LastName LIKE ?) AND UserID=?");
		$searchTerm = "%" . $search . "%";
		$stmt->bind_param("ssi", $searchTerm,, $searchTerm, $userId);
		$stmt->execute();
		
		$result = $stmt->get_result();

		// Stores all requested info in $searchResults
		while($row = $result->fetch_assoc())
		{
			if( $searchCount > 0 )
			{
				$searchResults .= ",";
			}
			
			$searchCount++;
			$searchResults .= '{"firstName": ' . $row["FirstName"] . ', "lastName": ' . $row["LastName"] . ', "phoneNumber": ' . $row["Phone"] . ', "emailAddress": ' . $row["Email"] . ', "ID": ' . $row["ID"] . '}';

		
		if( $searchCount == 0 )
		{
			returnWithError( "No Records Found" );
		}
		else
		{
			returnWithInfo( $searchResults );
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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	// Returns $searchResults as results JSON
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>
