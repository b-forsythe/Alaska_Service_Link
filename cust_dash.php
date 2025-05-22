<?php
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="./assets/stylesheet.css">
</head>
<body>
        <div style="display:flex; justify-content: space-between; align-items: center;">
            <img src="./assets/aksl1_no_underline.svg" alt="Logo" style="width: 15%; height:auto">
        
            <div style="display: flex;">
                <input class="header_button" type="button" id="browse" value="Browse Listings"onclick="window.location.href='browse.html'">
                <input class="header_button"type="button" id="logout" value="Log Out" onclick="window.location.href='logout.php'">
            </div>
        </div>

    <hr style="margin: 0; padding: 0; border: none; height: 1px; background-color: #000;">
    
    <div style="background-color:#eaeaea; width:100%; height:100%;">
        <div style="padding:3%;">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
        </div>

        <div class="dashboard">
            <div class="box box-1">My Projects</div>
            <div class="box box-2">Messages / Chat Requests</div>
            <div class="box box-3">Contractor Matches</div>
            <div class="box box-4">Profile & Preferences</div>
            <div class="box box-5">Feedback / Reviews</div>
        </div>
    </div>

    <script src="buttons.js"></script>
</body>
</html>
