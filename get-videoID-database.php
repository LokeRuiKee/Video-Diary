<?php
include 'connect_database.php';

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

// Close the connection
$conn->close();

// Return the videoID
return $video_id;
?>