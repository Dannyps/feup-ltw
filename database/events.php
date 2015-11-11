<?php
include_once('database/connection.php');

// add event to Events database and to user's list of events
function createEvent($username, $type, $description, $time, $address, $imageURL, $publicEvent, $zip1, $zip2){
	event('CREATE', NULL, $username, $type, $description, $time, $address, $imageURL, $publicEvent, $zip1, $zip2);
}

// updates the event's information to the given parameters
function updateEvent($eventID, $type, $description, $time, $address, $imageURL, $publicEvent, $zip1, $zip2){
	event('UPDATE', $eventID, NULL, $type, $description, $time, $address, $imageURL, $publicEvent, $zip1, $zip2);
}

// delete the event with the given id from the database
function deleteEvent($eventID){
	event('DELETE', eventID);
}

// event operarions
function event($operation, $id, $username, $type, $description, $time, $address, $imageURL, $publicEvent, $zip1, $zip2){
	// open database
	$db = openDB();

	switch ($operation) {
		// create event
		case 'CREATE':
			$stmt = $db->prepare('INSERT INTO Event(id, type, description, time, address, zipcode1, zipcode2, imageURL, publicEvent) 
								values (NULL, :type, :description, :time, :address, :zipcode1, :zipcode2, :imageURL, :publicEvent)');
			break;
		case 'UPDATE':
			$stmt = $db->prepare('UPDATE Event SET type=:type, description=:description, time=:time, address=:address, 
								zipcode1=:zipcode1, zipcode2= :zipcode2, imageURL=:imageURL, publicEvent=:publicEvent
									WHERE id=:id');
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			break;
		case 'DELETE':
			$stmt = $db->prepare('DELETE FROM Event WHERE id=:id');
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			return;
		default:
			return;
	}

	$stmt->bindParam(':type', $type, PDO::PARAM_STRING);
	$stmt->bindParam(':description', $description, PDO::PARAM_STRING);
	$stmt->bindParam(':time', $time, PDO::PARAM_STRING);
	$stmt->bindParam(':address', $address, PDO::PARAM_STRING);
	$stmt->bindParam(':zip1', $zip1, PDO::PARAM_INT);
	$stmt->bindParam(':zip2', $zip2, PDO::PARAM_INT);
	$stmt->bindParam(':imageURL', $imageURL, PDO::PARAM_STRING);	
	$stmt->bindParam(':publicEvent', $publicEvent, PDO::PARAM_STRING);
	$stmt->execute();
	
	if($operation='CREATE'){
		// get event ID
		$stmtID = $db->prepare('SELECT id FROM Event WHERE type=:type, description=:description, time=:time, address=:address,
								zipcode1=:zipcode1, zipcode2=:zipcode2, imageURL=:imageURL, publicEvent=:publicEvent');
		$stmtID->bindParam(':type', $type, PDO::PARAM_STRING);
		$stmtID->bindParam(':description', $description, PDO::PARAM_STRING);
		$stmtID->bindParam(':time', $time, PDO::PARAM_STRING);
		$stmtID->bindParam(':address', $address, PDO::PARAM_STRING);
		$stmtID->bindParam(':zip1', $zip1, PDO::PARAM_INT);
		$stmtID->bindParam(':zip2', $zip2, PDO::PARAM_INT);
		$stmtID->bindParam(':imageURL', $imageURL, PDO::PARAM_STRING);	
		$stmtID->bindParam(':publicEvent', $publicEvent, PDO::PARAM_STRING);
		$stmtID->execute();
		$eventID = stmtID->fetch();

		// add event to user record
		$stmtEventCreator = $db->prepare('INSERT INTO EventCreator(eventID, username) values (:eventID, :username)');
		$stmtEventCreator->bindParam(':username', $username, PDO::PARAM_STRING);
		$stmtEventCreator->bindParam(':eventID', $eventID, PDO::PARAM_INT);
		$stmtEventCreator->execute();
	}
}

function attendEvent($username, $eventID, $attending = false){
	// open database
	$db = openDB();

	if($attending){
		// attend event
		$stmt = $db->prepare('INSERT INTO Attending(username, eventID)
							values (:username, :eventID)');
	}else{
		// do not attend event
		$stmt = $db->prepare('DELETE FROM Attending WHERE username=:username, username=:eventID');
	}

	$stmt->bindParam(':username', $username, PDO::PARAM_STRING);
	$stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);	
	$stmt->execute();
}

function getEvent($eventID){
	// open database
	$db = openDB();

	$stmt = $db->prepare('SELECT * FROM  Event WHERE id = :eventID');
	$stmt->bindParam(':username', $username, PDO::PARAM_STRING);
	$stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);	
	$stmt->execute();
	return $stmt->fetch();
}

// return all public events
function getEvents(){
	// open database
	$db = openDB();

	$stmt = $db->prepare('SELECT * FROM  Event WHERE publicEvent = 1');
	$stmt->execute();
	return $stmt->fetchAll();
}

// return user with given username and password
function getUserEvents($username){
	// open database
	$db = openDB();

	$stmt = $db->prepare('SELECT * FROM  Event 
						WHERE id in (SELECT eventID FROM EventCreator WHERE username=:username)');
	$stmt->bindParam(':username', $username, PDO::PARAM_STRING);
	$stmt->execute();
	return $stmt->fetchAll();
}

// return user with given username and password
function getAttendingEvents($username){
	// open database
	$db = openDB();

	$stmt = $db->prepare('SELECT * FROM  Event 
						WHERE id in (SELECT eventID FROM Attending WHERE username=:username)');
	$stmt->bindParam(':username', $username, PDO::PARAM_STRING);
	$stmt->execute();
	return $stmt->fetchAll();
}

?>