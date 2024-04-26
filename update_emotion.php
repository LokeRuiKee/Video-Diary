<?php
// Include the file that contains the videoID, video_url, most_common_emotion variable
include 'get-videoID-database.php';
include 'get_emotion.php';

$servername = "localhost";  
$username = "rk"; 
$password = "password123";
$dbname = "mental_masterydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// SQL to select the latest videoID
$sql = "SELECT `videoID` FROM `video_diary` ORDER BY `videoID` DESC LIMIT 1";

// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
  // Fetch the result
  $row = $result->fetch_assoc();
  $video_id = $row['videoID'];
  echo "Latest videoID: " . $row['videoID'];
} else {
  echo "No results";
}

// Prepare an SQL statement to check if videoID already exists
$checkSql = "SELECT * FROM `video_diary` WHERE `videoID` = ?";

// Create a prepared statement
$checkStmt = $conn->prepare($checkSql);

// Bind parameters to the prepared statement
$checkStmt->bind_param("s", $video_id);

// Execute the prepared statement
$checkStmt->execute();

// Get the result of the query
$result = $checkStmt->get_result();

// If the videoID exists in the database, update the emotion
if ($result->num_rows > 0) {
  // Prepare an SQL statement
  $sql = "UPDATE `video_diary` SET `emotion` = ? WHERE `videoID` = ?";

  // Create a prepared statement
  $stmt = $conn->prepare($sql);

  // Bind parameters to the prepared statement
  $stmt->bind_param("ss", $most_common_emotion, $video_id);

  // Execute the prepared statement
  $stmt->execute();

  echo "Record updated successfully";
} else {
  echo "No record found with videoID: $video_id";
}

// Close the prepared statement
if (isset($stmt)) {
  $stmt->close();
}

// Close the checkStmt prepared statement
$checkStmt->close();

// Close the connection
$conn->close();
?>