<?php
// This file assumes $conn and $userId are already available.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn->begin_transaction();
    try {
        // ... (All the database update logic from the previous answer)
        // 1. UPDATE 'user_accounts' TABLE
        $sql_ua = "UPDATE user_accounts SET full_name = ?, email = ? WHERE id = ?";
        $stmt_ua = $conn->prepare($sql_ua);
        $stmt_ua->bind_param("ssi", $_POST['fullName'], $_POST['email'], $userId);
        $stmt_ua->execute();
        $stmt_ua->close();

        // 2. CHECK IF ROW EXISTS IN 'users' TABLE TO PREVENT DUPLICATES
        $sql_check = "SELECT id FROM users WHERE user_account_id = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $userId);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $stmt_check->close();

        if ($result_check->num_rows > 0) {
            $sql_users = "UPDATE users SET phone = ?, profession = ?, city = ?, state = ?, bio = ? WHERE user_account_id = ?";
            $stmt_users = $conn->prepare($sql_users);
            $stmt_users->bind_param("sssssi", $_POST['phone'], $_POST['profession'], $_POST['city'], $_POST['state'], $_POST['bio'], $userId);
        } else {
            $sql_users = "INSERT INTO users (user_account_id, phone, profession, city, state, bio) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_users = $conn->prepare($sql_users);
            $stmt_users->bind_param("isssss", $userId, $_POST['phone'], $_POST['profession'], $_POST['city'], $_POST['state'], $_POST['bio']);
        }
        $stmt_users->execute();
        $stmt_users->close();

        // 3. UPDATE LANGUAGES
        $sql_del_lang = "DELETE FROM user_languages WHERE user_account_id = ?";
        $stmt_del_lang = $conn->prepare($sql_del_lang);
        $stmt_del_lang->bind_param("i", $userId);
        $stmt_del_lang->execute();
        $stmt_del_lang->close();

        if (isset($_POST['languages_json'])) {
            $languages = json_decode($_POST['languages_json'], true);
            if (is_array($languages) && !empty($languages)) {
                $sql_ins_lang = "INSERT INTO user_languages (user_account_id, language_name, proficiency) VALUES (?, ?, ?)";
                $stmt_ins_lang = $conn->prepare($sql_ins_lang);
                foreach ($languages as $lang) {
                    $stmt_ins_lang->bind_param("iss", $userId, $lang['name'], $lang['fluency']);
                    $stmt_ins_lang->execute();
                }
                $stmt_ins_lang->close();
            }
        }

        // 4. HANDLE PROFILE IMAGE UPLOAD
        if (isset($_FILES['profile_upload']) && $_FILES['profile_upload']['error'] == 0) {
            $upload_dir = '../../../uploads/profile_images/';
            $file_extension = pathinfo($_FILES['profile_upload']['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid('user_' . $userId . '_', true) . '.' . $file_extension;
            $target_file = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['profile_upload']['tmp_name'], $target_file)) {
                $sql_img = "UPDATE users SET profile_image = ? WHERE user_account_id = ?";
                $stmt_img = $conn->prepare($sql_img);
                $stmt_img->bind_param("si", $new_filename, $userId);
                $stmt_img->execute();
                $stmt_img->close();
            }
        }
        
        $conn->commit();
        header("Location: " . $_SERVER['PHP_SELF'] . "?page=profile");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        // For debugging: error_log("Profile Update Failed: " . $e->getMessage());
        header("Location: " . $_SERVER['PHP_SELF'] . "?page=profile&update_error=true");
        exit();
    }
}

// --- DATA FETCHING FOR DISPLAY ---
$sql_fetch = "SELECT ua.*, u.profile_image, u.phone, u.profession, u.city, u.state, u.bio 
              FROM user_accounts ua 
              LEFT JOIN users u ON ua.id = u.user_account_id 
              WHERE ua.id = ?";
$stmt_fetch = $conn->prepare($sql_fetch);
$stmt_fetch->bind_param("i", $userId);
$stmt_fetch->execute();
$result = $stmt_fetch->get_result();
$user = $result->fetch_assoc();
$stmt_fetch->close();

$fullName = $user['full_name'] ?? 'N/A';
$email = $user['email'] ?? 'N/A';
$phone = $user['phone'] ?? '';
$profession = $user['profession'] ?? '';
$city = $user['city'] ?? '';
$state = $user['state'] ?? '';
$bio = $user['bio'] ?? '';
$profileImage = $user['profile_image'] ?? '';
$memberSince = !empty($user['created_at']) ? (new DateTime($user['created_at']))->format('M Y') : 'N/A';

$languages_data = [];
$sql_lang_fetch = "SELECT language_name, proficiency FROM user_languages WHERE user_account_id = ?";
$stmt_lang_fetch = $conn->prepare($sql_lang_fetch);
$stmt_lang_fetch->bind_param("i", $userId);
$stmt_lang_fetch->execute();
$result_lang = $stmt_lang_fetch->get_result();
while ($row = $result_lang->fetch_assoc()) {
    $languages_data[] = ['name' => $row['language_name'], 'fluency' => $row['proficiency']];
}
$stmt_lang_fetch->close();
?>