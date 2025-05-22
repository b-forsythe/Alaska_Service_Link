<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once dirname(__DIR__) . '/private/credentials.php';
if ($conn_projects->connect_error) {
    die("Connection failed: " . $conn_projects->connect_error);
}

$proj_id = $_POST['id'] ?? '';
$cont_id = $_SESSION['user_id'] ?? '';

$check = $conn_projects->prepare("SELECT 1 FROM project_interest WHERE proj_id = ? AND cont_id = ?");
$check->bind_param("ss", $proj_id, $cont_id);
$check->execute();
$check->store_result();

if($check->num_rows > 0) {
    echo "You have already expressed interest in this project.";
    exit();
}

$stmt = $conn_projects->prepare("INSERT INTO project_interest(proj_id, cont_id) VALUES (?, ?)");
$stmt->bind_param("ss", $proj_id, $cont_id);

$stmt->execute();
echo "Interest submitted successfully!";
