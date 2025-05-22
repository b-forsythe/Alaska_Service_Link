<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

$contractor_id = $_SESSION['user_id'] ?? null;

if (!$contractor_id) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

require_once dirname(__DIR__) . '/private/credentials.php';
if ($conn_projects->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}

// Fetch projects that this contractor has shown interest in
$sql = "
    SELECT p.*
    FROM project_interest pi
    JOIN projects p ON pi.proj_id = p.id
    WHERE pi.cont_id = ?
    ORDER BY p.id DESC
";

$stmt = $conn_projects->prepare($sql);
$stmt->bind_param("i", $contractor_id);
$stmt->execute();
$result = $stmt->get_result();

$projects = [];

while ($row = $result->fetch_assoc()) {
    $imageQuery = $conn_projects->prepare("SELECT image_path FROM project_images WHERE project_id = ?");
    $imageQuery->bind_param("i", $row['id']);
    $imageQuery->execute();
    $imageResult = $imageQuery->get_result();

    $images = [];
    while ($img = $imageResult->fetch_assoc()) {
        $images[] = $img['image_path'];
    }

    $row['images'] = $images;
    $projects[] = $row;
}



echo json_encode($projects);
$conn_projects->close();
