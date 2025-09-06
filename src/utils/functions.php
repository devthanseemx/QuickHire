<?php

function display_flash_toast()
{
    if (isset($_SESSION['flash_message'])) {

        $flash = $_SESSION['flash_message'];
        $type = addslashes($flash['type']);
        $message = addslashes($flash['message']);
        $description = addslashes($flash['description']);
        unset($_SESSION['flash_message']);
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showToast('$message', '$type', '$description');
                });
              </script>";
    }
}


