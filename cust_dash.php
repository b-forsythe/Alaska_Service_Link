<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$name = htmlspecialchars($_SESSION['name']);
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./assets/stylesheet.css">
    <title>Dashboard</title>
</head>
<body>
    <div style="display:flex; justify-content:space-between;align-items:center;">
        <h1 style="padding:2%;">Alaska Service Link</h1>
        <div style="display:flex; gap:10px">
            <input type="button" id="home" value="Home" style="padding:1%;">
            <input type="button" id="browse" value="Browse Listings" style="padding:1%;">
        </div>
    </div>
    <hr style="margin:0; padding:0; border:none; height:1px; background-color:#000;">

    <div style="background-color:#eaeaea; width:100vw; height:100vh;">
        <div style="padding:3%;">
            <h2>Welcome, <?php echo $name; ?>!</h2>
            <p>You are logged in as a <strong><?php echo ucfirst($role); ?></strong>.</p>
        </div>

        <?php if ($role === 'customer'): ?>
            <div class="dashboard">
                <div class="box box-1">My Projects</div>
                <div class="box box-2">Messages / Chat Requests</div>
                <div class="box box-3">Contractor Matches</div>
                <div class="box box-4">Profile & Preferences</div>
                <div class="box box-5">Feedback / Reviews</div>
            </div>
        <?php elseif ($role === 'contractor'): ?>
            <div class="quick_look" style="display:flex; justify-content: space-between;">
                <h4>3 new projects match your profile</h4>
                <div style="display:flex; gap: 15px;">
                    <h6>Quick Stats</h6>
                    <h6>Avg Response Time</h6>
                    <h6>Pending Verifications</h6>
                </div>
            </div>

            <div class="dashboard">
                <div class="box box-1">Matched Projects</div>
                <div class="box box-2">Saved Projects</div>
                <div class="box box-3">Messages</div>
                <div class="box box-4">???</div>
                <div class="box box-5">Messages Again?</div>
                <div class="box box-6">Billing?</div>
            </div>
        <?php elseif ($role === 'admin'): ?>
            <div class="dashboard">
                <div class="box box-1">User Management</div>
                <div class="box box-2">System Logs</div>
                <div class="box box-3">Site Settings</div>
            </div>
        <?php else: ?>
            <p>Unknown role. Please contact support.</p>
        <?php endif; ?>
    </div>

    <a href="logout.php">Logout</a>
    <script src="buttons.js"></script>
</body>
</html>
