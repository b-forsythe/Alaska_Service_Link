<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";  // Your MySQL server (usually localhost)
$username = "ufzauemy_bfforsythe";         // Your MySQL username
$password = "42Bebops..";             // Your MySQL password (empty for localhost by default)
$dbname = "ufzauemy_project_submissions";  // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect data from form
$work_type = $_POST['workType'];  // Will get the value of the selected radio button
if ($_POST['workType'] == 'Other') {
    $work_type = $_POST['otherWorkType'];  // Use the 'other' text input if 'Other' is selected
}
$description = $_POST['description'];
$location = $_POST['location'];
$is_remote = isset($_POST['locationCheck']) && in_array('isRemote', $_POST['locationCheck']) ? 1 : 0;  // Checkbox for remote location
$is_flexible = isset($_POST['locationCheck']) && in_array('isFlexible', $_POST['locationCheck']) ? 1 : 0;  // Checkbox for flexible deadline

// For now, the budget and deadline can be empty or set a default value
$budget = $_POST['budget'] ?: NULL;  // You may want to add a budget field to your form
$deadline = $_POST['deadline'] ?: NULL;  // Same with deadline, optional input

// Contact method: We assume checkboxes for "Email" and "Phone"
$contact_method = "";
if (isset($_POST['contact_method'])) {
    $contact_method = implode(", ", $_POST['contact_method']);
}

// User information: Name, Email, Phone (assuming you have these fields in your form)
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
