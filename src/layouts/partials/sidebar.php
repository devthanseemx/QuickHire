<?php
// This PHP block determines which category should be open by default based on the active page.
$openCategory = '';
if (in_array($activePage, ['dashboard'])) { // Add any other overview pages here
    $openCategory = 'overview';
}
if (in_array($activePage, ['profile', 'skills-portfolio'])) {
    $openCategory = 'account';
}
?>


<aside 
    class="fixed inset-y-0 left-0 z-40 flex flex-col flex-shrink-0 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0"
    :class="{
        'translate-x-0': isMobileMenuOpen,
        '-translate-x-full': !isMobileMenuOpen,
        'lg:w-64': isSidebarOpen,
        'lg:w-20': !isSidebarOpen
    }"
    x-cloak
>
    <!-- Sidebar Header with Logo -->
    <div class="flex items-center justify-between h-16 px-4 flex-shrink-0">
        <a href="dashboard.php?page=dashboard" class="flex items-center space-x-3">
            <img class="h-8 w-auto" src="../../../assets/images/company-logo.svg" alt="QuickHire Logo">
            <span x-show="isSidebarOpen" class="text-xl font-bold text-gray-800 tracking-wide">QUICKHIRE</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-grow py-4">
        <!-- CATEGORY: Overview -->
        <div class="px-3 mb-4">
            <span x-show="isSidebarOpen" class="px-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Overview</span>
            <div class="space-y-1 mt-2">
                <a href="dashboard.php?page=dashboard" @click="isMobileMenuOpen = false" class="group relative flex items-center py-2 text-sm font-medium rounded-md <?php echo ($activePage === 'dashboard') ? 'bg-violet-100 text-violet-700' : 'text-gray-600 hover:bg-gray-100'; ?>" :class="isSidebarOpen ? 'px-3' : 'justify-center'">
                    <i class="bi bi-house-door-fill text-base"></i>
                    <span x-show="isSidebarOpen" class="ml-3">Dashboard</span>
                    <span x-show="!isSidebarOpen" class="absolute left-full ml-4 px-2 py-1 text-sm font-medium text-white bg-gray-900 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">Dashboard</span>
                </a>
            </div>
        </div>
        
        <!-- CATEGORY: Account -->
        <div class="px-3 mb-4">
            <span x-show="isSidebarOpen" class="px-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Account</span>
            <div class="space-y-1 mt-2">
                <a href="dashboard.php?page=profile" @click="isMobileMenuOpen = false" class="group relative flex items-center py-2 text-sm font-medium rounded-md <?php echo ($activePage === 'profile') ? 'bg-violet-100 text-violet-700' : 'text-gray-600 hover:bg-gray-100'; ?>" :class="isSidebarOpen ? 'px-3' : 'justify-center'">
                    <i class="bi bi-person-fill text-base"></i>
                    <span x-show="isSidebarOpen" class="ml-3">Profile</span>
                    <span x-show="!isSidebarOpen" class="absolute left-full ml-4 px-2 py-1 text-sm font-medium text-white bg-gray-900 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">Profile</span>
                </a>
                <a href="dashboard.php?page=skills-portfolio" @click="isMobileMenuOpen = false" class="group relative flex items-center py-2 text-sm font-medium rounded-md <?php echo ($activePage === 'skills-portfolio') ? 'bg-violet-100 text-violet-700' : 'text-gray-600 hover:bg-gray-100'; ?>" :class="isSidebarOpen ? 'px-3' : 'justify-center'">
                    <i class="bi bi-briefcase-fill text-base"></i>
                    <span x-show="isSidebarOpen" class="ml-3">Skills & Portfolio</span>
                    <span x-show="!isSidebarOpen" class="absolute left-full ml-4 px-2 py-1 text-sm font-medium text-white bg-gray-900 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">Skills & Portfolio</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Sidebar Footer with Minimize Button (ONLY visible on desktop) -->
    <div class="hidden lg:flex flex-shrink-0 p-3 border-t border-gray-200">
        <button @click="isSidebarOpen = !isSidebarOpen" class="w-full flex items-center justify-end p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-800">
            <i class="bi bi-chevron-double-left text-lg transition-transform duration-300" :class="{ 'rotate-180': !isSidebarOpen }"></i>
        </button>
    </div>
</aside>