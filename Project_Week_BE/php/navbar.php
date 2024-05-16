<?php
session_start();
require_once "db_connect.php";

// Fetch user ID from session
if (isset($_SESSION["user_id_fk"])) {
    $userId = $_SESSION["user_id_fk"];

    // Query to count notifications for the logged-in user
    $notificationQuery = "SELECT COUNT(*) AS notification_count FROM orders WHERE user_id_fk = $userId";

    // Execute the query
    $notificationResult = mysqli_query($connect, $notificationQuery);

    // Fetch the result as an associative array
    $notificationData = mysqli_fetch_assoc($notificationResult);

    // Extract the notification count
    $notificationCount = $notificationData['notification_count'];
} else {
    // If user ID is not set, set notification count to 0
    $notificationCount = 0;
}

$dashboard = "";
$log = "
    <li class='nav-item'>
        <a class='nav-link' href='logout.php?logout'>Logout</a >
    </li>";

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"]) && !isset($_SESSION["shelter"])) {
    $userAcc = "
        <a class='navbar-brand' href='login.php'>
        <span class='text-black-50 fs-6'>Login</span>
        </a>";
    $log = "";
} else {
    if (isset($_SESSION["shelter"])) {
        $sqlNav = "SELECT * FROM users WHERE id = {$_SESSION["shelter"]}";
        $dashboard = "
            <li class='nav-item me-3'>
                <a class='nav-link' aria-current='page' href='agency.php'>Dashboard</a>
            </li>
            <li class='nav-item me-3'>
                <a class='nav-link' aria-current='page' href='agencyNotifications.php'>Requests</a>
            </li>
            <li class='nav-item me-3'>
                <a class='nav-link' aria-current='page' href='create.php'>Create</a>
            </li>";
    }
    if (isset($_SESSION["user"])) {
        $sqlNav = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
        $dashboard = "
            <li class='nav-item me-3'>
                <a class='nav-link' aria-current='page' href='create.php'>Create</a>
            </li>";
    }
    if (isset($_SESSION["adm"])) {
        $sqlNav = "SELECT * FROM users WHERE id = {$_SESSION["adm"]}";
        $dashboard = "
            <li class='nav-item me-3'>
                <a class='nav-link' aria-current='page' href='dashboard.php'>Dashboard</a>
            </li>
            <li class='nav-item me-3'>
                <a class='nav-link' aria-current='page' href='create.php'>Create</a>
            </li>";
    }
    $resultNav = mysqli_query($connect, $sqlNav);
    $rowNav = mysqli_fetch_assoc($resultNav);
    $userAcc = "
        <a class='navbar-brand d-flex align-items-center' href='update.php?id={$rowNav["id"]}'>
            <div class='profile-picture-container'>
                <img src='../images/{$rowNav["picture"]}' class='profile-picture' alt='user pic'>
            </div>
        </a>";
}

$nav = "
<nav class='navbar navbar-expand-lg bg-body-tertiary'>
    <div class='container-fluid'>
        <a class='navbar-brand' href='home.php'>
            <img src='../images/logo.png' alt='logo' style='width: 5vw;'>
        </a>
        <ul class='navbar-nav me-auto mb-2 mb-lg-0 navText'>
            <li class='nav-item ms-2 me-3'>
                <a class='nav-link active' aria-current='page' href='home.php'>Home</a>
            </li>
            <li class='nav-item me-3'>
                <a class='nav-link' href='senior.php'>Our Seniors</a>
            </li>
            <li class='nav-item dropdown me-3'>
                <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    Info
                </a>
                <ul class='dropdown-menu'>
                    <li><a class='dropdown-item' href='resourceLibrary.php'>Resource Library</a></li>
                    <li><a class='dropdown-item' href='faq.php'>FAQ</a></li>
                    <li><a class='dropdown-item' href='about.php'>About us</a></li>
                </ul>
            </li>
            {$dashboard}
            {$log}
        </ul>
        <ul class='navbar-nav me-2 mb-2 mb-lg-0'>
            <li class='nav-item'>
                <a class='nav-link' href='notification.php'>
                    <i class='bi bi-bell'></i> <!-- Bootstrap Icons Bell Icon -->
                    <span class='badge bg-danger'>$notificationCount</span> <!-- Notification count -->
                </a>
            </li>
        </ul>
        {$userAcc}
    </div>
</nav>";

// CSS styles
echo "
<style>
    .profile-picture-container {
        width: 70px;
        height: 70px;
        overflow: hidden;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .profile-picture {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>";
?>
