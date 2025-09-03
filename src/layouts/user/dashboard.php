<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../authentication/login.php");
    exit;
}

$page = $_GET['page'] ?? 'dashboard';
$activePage = $page;

$_SESSION['user_name'] = $_SESSION['username'] ?? 'Guest';
$_SESSION['user_type'] = $_SESSION['user_type'] ?? 'Worker';
$_SESSION['profile_picture_url'] = $_SESSION['profile_picture_url'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>User Dashboard - QuickHire</title>
    <link rel="stylesheet" href="../../../dist/output.css">
    <link rel="stylesheet" href="../../../dist/main.css">
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
                switch ($page) {
                    case 'profile':
                        include '../partials/profile-content.php';
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