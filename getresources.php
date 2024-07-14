<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "winnie";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get resources
$sql = "SELECT id, resource_name, description, resource_image FROM resources";
$result = $conn->query($sql);

$resources = array();

if ($result->num_rows > 0) {
    // Fetch all resources
    while($row = $result->fetch_assoc()) {
        $resources[] = $row;
    }
}

// Output data in JSON format
echo json_encode($resources);

$conn->close();
?>
