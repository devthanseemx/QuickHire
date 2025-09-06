<?php
// --- HANDLE ALL POST REQUESTS (Update Profile OR Delete Account) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'] ?? 'update_profile'; // Default action is to update

    // --- BRANCH 1: DELETE ACCOUNT LOGIC ---
    if ($action === 'delete_account') {
        $sql = "DELETE FROM user_accounts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            session_destroy(); // Log the user out
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'error', 'message' => 'A database error occurred.'];
        }
        $stmt->close();
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit(); // Stop script execution
    }
    
    // --- BRANCH 2: UPDATE PROFILE LOGIC (Default Action) ---
    $errors = [];
    if (empty(trim($_POST['fullName']))) { $errors['fullName'] = "Full name is required."; } 
    elseif (preg_match('/[0-9]/', $_POST['fullName'])) { $errors['fullName'] = "Full name cannot contain numbers."; }

    if (empty(trim($_POST['email']))) { $errors['email'] = "Email address is required."; } 
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { $errors['email'] = "Please enter a valid email address."; }

    if (!empty(trim($_POST['profession'])) && preg_match('/[0-9]/', $_POST['profession'])) { $errors['profession'] = "Profession cannot contain numbers."; }

    if (!empty($errors)) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Validation Failed', 'errors' => $errors]);
        exit();
    }

    $conn->begin_transaction();
    
    try {
        // 1. Update 'user_accounts' table
        $sql_ua = "UPDATE user_accounts SET full_name = ?, email = ? WHERE id = ?";
        $stmt_ua = $conn->prepare($sql_ua);
        $stmt_ua->bind_param("ssi", $_POST['fullName'], $_POST['email'], $userId);
        $stmt_ua->execute();
        $stmt_ua->close();

        // 2. Check & Update/Insert 'users' table
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

        // 3. Update Languages
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

        // 4. Handle Profile Image Upload & Delete Old One
        if (isset($_FILES['profile_upload']) && $_FILES['profile_upload']['error'] == 0) {
            $sql_get_old_img = "SELECT profile_image FROM users WHERE user_account_id = ?";
            $stmt_get_old_img = $conn->prepare($sql_get_old_img);
            $stmt_get_old_img->bind_param("i", $userId);
            $stmt_get_old_img->execute();
            $old_image = $stmt_get_old_img->get_result()->fetch_assoc();
            $stmt_get_old_img->close();
            $upload_dir = '../../../uploads/profile_images/';
            $new_filename = uniqid('user_' . $userId . '_', true) . '.' . pathinfo($_FILES['profile_upload']['name'], PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES['profile_upload']['tmp_name'], $upload_dir . $new_filename)) {
                $sql_img_update = "UPDATE users SET profile_image = ? WHERE user_account_id = ?";
                $stmt_img_update = $conn->prepare($sql_img_update);
                $stmt_img_update->bind_param("si", $new_filename, $userId);
                $stmt_img_update->execute();
                $stmt_img_update->close();
                if ($old_image && !empty($old_image['profile_image'])) {
                    $old_image_path = $upload_dir . $old_image['profile_image'];
                    if (file_exists($old_image_path)) { @unlink($old_image_path); }
                }
            }
        }
        
        $conn->commit();
        $response = ['status' => 'success', 'message' => 'Profile Updated', 'description' => 'Your information has been saved successfully.'];
    } catch (Exception $e) {
        $conn->rollback();
        $response = ['status' => 'error', 'message' => 'Update Failed', 'description' => 'An unexpected error occurred.'];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// --- DATA FETCHING for displaying the page ---
$sql_fetch = "SELECT ua.*, u.profile_image, u.phone, u.profession, u.city, u.state, u.bio FROM user_accounts ua LEFT JOIN users u ON ua.id = u.user_account_id WHERE ua.id = ?";
$stmt_fetch = $conn->prepare($sql_fetch);
$stmt_fetch->bind_param("i", $userId);
$stmt_fetch->execute();
$user = $stmt_fetch->get_result()->fetch_assoc();
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