<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "";
$password = "";
$dbname = "ufzauemy_project_submissions"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error); {
    die("Connection failed: " . $conn->connect_error);
}

// Collect data from form
$work_type = $_POST['workType']; 
if ($_POST['workType'] == 'Other') {
    $work_type = $_POST['otherWorkType']; 
}
$description = $_POST['description'];
$location = $_POST['location'];
$is_remote = isset($_POST['locationCheck']) && in_array('isRemote', $_POST['locationCheck']) ? 1 : 0;  // Checkbox for remote location
$is_flexible = isset($_POST['locationCheck']) && in_array('isFlexible', $_POST['locationCheck']) ? 1 : 0;  // Checkbox for flexible deadline

$budget = $_POST['budget'] ?: NULL; 
$deadline = $_POST['deadline'] ?: NULL;

$contact_method = "";
if (isset($_POST['contact_method'])) {
    $contact_method = implode(", ", $_POST['contact_method']);
}


$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// SQL query to insert data into the database
$sql = "INSERT INTO projects (work_type, description, location, is_remote, is_flexible, budget, deadline, contact_method, name, email, phone)
        VALUES ('$work_type', '$description', '$location', $is_remote, $is_flexible, '$budget', '$deadline', '$contact_method', '$name', '$email', '$phone')";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "New project posted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
