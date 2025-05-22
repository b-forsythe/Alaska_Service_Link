<?php
session_start();

function returnDash() {
    if (!isset($_SESSION['role'])) {
        header("Location: login.php");
        exit();
    }

    switch ($_SESSION['role']) {
        case 'customer':
            header("Location: /cust_dash.php");
            exit();
        case 'contractor':
            header("Location: /cont_dash.php");
            exit();
        case 'admin':
            header("Location: /admin_dash.php");
            exit();
        default:
            header("Location: /login.php");
            exit();
    }
}

returnDash(); // Run the redirect logic
?>