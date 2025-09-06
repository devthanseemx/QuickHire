<?php
function showLoginSuccessToast() {
    if (isset($_SESSION['login_success_message'])) {
        // Get the description, default to empty string if not set
        $description = $_SESSION['login_success_description'] ?? '';

        echo '<script src="../../../assets/js/toast-notifications.js"></script>';
        echo '<script>
                showToast(
                    "' . addslashes($_SESSION['login_success_message']) . '", 
                    "success", 
                    "' . addslashes($description) . '"
                );
              </script>';

        // Unset both session variables to prevent the toast from showing again
        unset($_SESSION['login_success_message']);
        unset($_SESSION['login_success_description']);
    }
}
?>