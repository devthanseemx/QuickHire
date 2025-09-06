<?php
session_start();
@include_once '../../../db/db.php';

if (!isset($conn) || $conn->connect_error) {
    die("Database Connection Failed. Check path and credentials. Error: " . ($conn->connect_error ?? 'File not found or $conn variable is missing.'));
}

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../authentication/login.php");
    exit;
}

$activePage = $_GET['page'] ?? 'dashboard';
$userId = $_SESSION['id'];

if ($activePage === 'profile' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the logic file to handle the database update.
    // This script will end with a redirect (header()) and exit(), so no further code will run.
    require_once 'process/profile-logic.php';
}

if ($activePage === 'profile') {
    require_once 'process/profile-logic.php';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - QuickHire</title>
    <link rel="stylesheet" href="../../../dist/output.css">
    <link rel="stylesheet" href="../../../dist/main.css">
    <script src="../../../assets//js//jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../../../assets/js/toast-notifications.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">

    <?php 
    include '../partials/dashboard-loading.html';
    require_once '../partials/session-toast.php';
    showLoginSuccessToast(); 
    ?>

    <div x-data="{
            isSidebarOpen: JSON.parse(localStorage.getItem('isSidebarOpen') ?? 'true'),
            isMobileMenuOpen: false,
            init() {
                this.$watch('isSidebarOpen', value => localStorage.setItem('isSidebarOpen', JSON.stringify(value)))
            }
        }" class="flex h-screen bg-gray-100">

        <?php include '../partials/sidebar.php'; ?>
        
        <div x-show="isMobileMenuOpen" @click="isMobileMenuOpen = false" class="fixed inset-0 z-30 bg-black/50 lg:hidden" x-cloak></div>

        <div class="flex flex-col flex-1 w-full overflow-hidden">
            <?php include '../partials/topbar.php'; ?>
            
            <main class="flex-grow overflow-y-auto p-4 sm:p-6 lg:p-8">
                <?php
                switch ($activePage) {
                    case 'profile':
                        include 'profile-content.php';
                        break;
                    case 'skills-portfolio':
                        include 'skills-content.php';
                        break;
                    default:
                        include 'dashboard-content.php';
                        break;
                }
                ?>
            </main>
        </div>
    </div>

</body>
</html>