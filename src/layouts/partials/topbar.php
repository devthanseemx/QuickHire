<?php
$userName = $_SESSION['user_name'] ?? 'Guest';
$userType = $_SESSION['user_type'] ?? 'User';
$profilePictureUrl = $_SESSION['profile_picture_url'] ?? '';
$defaultProfilePic = '../../../assets/images/default-avatar.png'; 
$finalProfilePicUrl = !empty($profilePictureUrl) ? $profilePictureUrl : $defaultProfilePic;
?>

<header class="bg-white shadow-sm w-full flex-shrink-0 z-10 relative">
    <div class="flex items-center justify-end h-16 px-2 sm:px-4 lg:px-8">
        
        <!-- Left Side: Mobile Hamburger Button (ONLY visible on screens smaller than lg) -->
        <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:outline-none lg:hidden">
            <i class="bi bi-list text-xl"></i>
        </button>

        <!-- This is a spacer to push the profile icon to the right on mobile -->
        <div class="flex-grow lg:hidden"></div>

        <!-- Right Side: User Profile Dropdown -->
        <div class="ml-4 flex items-center">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-0 sm:space-x-3 focus:outline-none rounded-md p-1 pr-5 hover:bg-gray-100 transition">
                    <img class="w-10 h-10 rounded-full object-cover border-2 border-transparent" src="<?= htmlspecialchars($finalProfilePicUrl) ?>" alt="<?= htmlspecialchars($userName) ?>'s Profile Picture">
                    <div class="hidden sm:block text-left">
                        <div class="font-medium text-gray-800 text-sm"><?= htmlspecialchars($userName) ?></div>
                        <div class="text-xs text-gray-500"><?= htmlspecialchars($userType) ?></div>
                    </div>
                </button>
                <div x-show="open" @click.away="open = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" style="display: none;">
                    <div class="py-1">
                        <a href="dashboard.php?page=profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                        <a href="dashboard.php?page=settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <a href="../../authentication/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>