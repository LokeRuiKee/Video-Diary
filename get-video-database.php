<?php
// Include the file that contains the connection to the database
include 'connect_database.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";
  
// SQL to select the URLs
$sql = "SELECT annotatedVideoURL FROM annotated_video_diary";

// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "URL: " . $row["annotatedVideoURL"]. "<br>";
  }
} else {
  echo "No results";
}

// Close the connection
$conn->close();
?>