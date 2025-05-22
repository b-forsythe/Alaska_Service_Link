<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Connect to the users database
require_once dirname(__DIR__) . '/private/credentials.php';
if ($conn_users->connect_error) {
    die("Connection failed: " . $conn_users->connect_error);
}

$user_id = $_SESSION['user_id'];
$profile = [];

$stmt = $conn_users->prepare("SELECT name, email, phoneNum FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $profile = $result->fetch_assoc();
}

$conn_users->close();



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
        <link rel="stylesheet" href="./assets/stylesheet.css">
        <link rel="stylesheet" href="./assets/listings.css">
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
        
        <div style="background-color:#eaeaea; width:100%">
            <div style="padding:3%;">
                <h2> Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
            </div>

            <div class="quick_look" style="display:flex; justify-content: space-between;">
                <h4> %number% new projects match your profile</h4>
                <div style="display:flex; justify-content: space-between; gap: 15px;">
                    <h6>quick stats</h6>
                    <h6>avg reponse time:</h6>
                    <h6>Pending Verifications</h6>
                </div>
            </div>

            <div class="dashboard">
                <div class="box box-1">
                    <h3>Matched Projects</h3>
                    <div id="listing" style="padding-top:10px;"></div>
                </div>

            <div class="box box-2">
                <h3>Profile</h3>
                <?php if (!empty($profile)): ?>
                    <p><strong>Name:</strong> <?= htmlspecialchars($profile['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($profile['email']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($profile['phoneNum']) ?></p>
                <?php else: ?>
                    <p>Unable to load profile information.</p>
                <?php endif; ?>
            </div>

                <div class="box box-3">Messages</div>
                <div class="box box-4">???</div>
                <div class="box box-5">Messages Again ?</div>
                <div class="box box-6">Billing ?</div>
            </div>
        </div>

        <script src="buttons.js"></script>
        <script>
                function toggleDropdown(id) {
                    const el = document.getElementById(id);
                    el.style.display = (el.style.display === 'none') ? 'block' : 'none';
                }
                function toggleGallery(button) {
                    const listing = button.closest(".listing");
                    const gallery = listing.querySelector(".image-gallery");
                    if (!gallery) return;

                    const isVisible = gallery.style.display === "block";
                    gallery.style.display = isVisible ? "none" : "block";
                    button.value = isVisible ? "View Images" : "Hide Images";
        }
            document.addEventListener("DOMContentLoaded", () => {
                fetch('fetch_contractor_projects.php')
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById("listing");
                        container.innerHTML = "";
            
                        data.forEach(project => {
                            const listing = document.createElement("div");
                            listing.className = "listing";
            
                            const galleryHTML = project.images && project.images.length > 0 ? `
                                <div class="image-gallery" style="display:none; margin-top:10px;">
                                    ${project.images.map(path => `<img src="${path}" style="max-width:100%; margin-bottom:10px;" />`).join('')}
                                </div>
                            ` : '';
            
                            listing.innerHTML = `
                                <h3 class="listing_title">${project.work_type}</h3>
                                <p class="listing_location">Location: ${project.location} | Budget: ${project.budget} | Deadline: ${project.deadline}</p>
                                <p class="listing_description project-description">
                                    ${project.limitations?.length > 100
                                        ? `<span class="short-text">${project.limitations.slice(0, 100)}...</span>
                                           <span class="full-text" style="display:none;">${project.limitations}</span>`
                                        : project.limitations || ''}
                                </p>
                                <div class="button-wrapper">
                                    <input class="view_full" type="button" value="View Images" onclick="toggleGallery(this)">
                                </div>
                                ${galleryHTML}
                            `;
            
                            container.appendChild(listing);
                        });
                    });
            });
            </script>
    </body>
</html>
