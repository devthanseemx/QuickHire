<?php
session_start();
require_once '../../../db/db.php';

// Check for database connection success
if (!isset($conn) || $conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../authentication/login.php");
    exit;
}

$userId     = $_SESSION['id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - QuickHire</title>
    <link rel="stylesheet" href="../../../dist/output.css">
    <link rel="stylesheet" href="../../../dist/main.css">
    <script src="../../../assets/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50">

    <?php include '../partials/dashboard-loading.html'; ?>

    <div x-data="{
            isSidebarOpen: JSON.parse(localStorage.getItem('isSidebarOpen') ?? 'true'),
            isMobileMenuOpen: false,
            init() {
                this.$watch('isSidebarOpen', value => localStorage.setItem('isSidebarOpen', JSON.stringify(value)))
            }
        }" class="flex h-screen bg-gray-50">

        <?php include '../partials/sidebar.php'; ?>

        <div x-show="isMobileMenuOpen" @click="isMobileMenuOpen = false" class="fixed inset-0 z-30 bg-black/50 lg:hidden" x-cloak></div>

        <div class="flex flex-col flex-1 w-full overflow-hidden">
            <?php include '../partials/topbar.php'; ?>

            <main class="flex-grow overflow-y-auto p-4 sm:p-6 lg:p-8">
              
            </main>
        </div>
    </div>

    <?php
    include '../partials/toast-notification.html';
    if (isset($_GET['login']) && $_GET['login'] === 'success') {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    showToast( "Login Successful", "success", "Welcome back! You can now access your dashboard." );
                    if (window.history.replaceState) {
                        const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?page=' . $activePage . '";
                        window.history.replaceState({path: cleanUrl}, "", cleanUrl);
                    }
                });
              </script>';
    }
    ?>
</body>

</html>