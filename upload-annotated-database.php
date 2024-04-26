<?php
// Include the file that contains the connection to the database
include 'connect_database.php';

// Define the directory that contains the video files
$dir = '/AppDev/VideoDiary/uploads/annotated/';

// Read the files from the directory
$files = scandir($_SERVER['DOCUMENT_ROOT'] . $dir);

// Loop through the files
foreach ($files as $file) {
  // Ignore '.' and '..'
  if ($file != '.' && $file != '..') {
    // Construct the URL for the file
    $url = 'http://localhost' . $dir . $file;

    // Define the SQL statement
    $sql = "INSERT INTO `annotated_video_diary`(`annotatedVideoURL`) VALUES ('$url')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
      echo "Annotated video URL inserted successfully: $url\n";
    } else {
      echo "Error inserting annotated video URL: " . $conn->error;
    }
  }
}

// Close the connection
$conn->close();
?>