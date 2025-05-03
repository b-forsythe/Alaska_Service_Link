<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
$host = "localhost"; 
$user = "ufzauemy_bfforsythe";
$pass = "42Bebops..";
$db   = "ufzauemy_project_submissions";

// Create DB connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL query
$sql = "SELECT id, work_type, description, location FROM projects ORDER BY id DESC";

// Execute the query
$result = $conn->query($sql);

$projects = [];

if ($result) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $projects[] = $row;
        }
    } else {
        // If no records found
        $projects[] = ['message' => 'No projects found'];
    }
} else {
    // Query failed
    $projects[] = ['error' => 'Query failed: ' . $conn->error];
}

$conn->close();

// Set the header to indicate this is JSON data
header('Content-Type: application/json');

// Output the result as JSON
echo json_encode($projects);
?>
