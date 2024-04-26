<?php
// Include the file that contains the connection to the database
include 'connect_database.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emotions = ['happy', 'sad', 'angry', 'disgust', 'fear', 'surprise', 'neutral']; // Add other emotions here
$counts = [];

foreach ($emotions as $emotion) {
    $sql = "SELECT COUNT(*) AS count FROM video_diary WHERE emotion = '$emotion'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $counts[$emotion] = $row["count"];
        }
    } else {
        $counts[$emotion] = 0;
    }
}

// Close the connection
$conn->close();

// Echo the counts as a JSON object
echo json_encode($counts);
?>