
<div x-data="profilePage()" x-init="fetchProfileData()" class="font-sans">

    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
            <p class="mt-1 text-sm text-gray-600">Manage your personal information and account settings.</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Top Gradient Part -->
                    <div class="p-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <div class="flex-shrink-0 h-20 w-20 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="bi bi-person-fill text-4xl text-white"></i>
                        </div>
                        <div class="text-center sm:text-left">
                            <h2 class="text-2xl font-bold" x-text="profile.full_name || 'Loading...'"></h2>
                            <p class="text-sm opacity-90" x-text="profile.profession || 'Not Set'"></p>
                            <p class="text-xs opacity-70 mt-1 flex items-center justify-center sm:justify-start">
                                <i class="bi bi-geo-alt-fill mr-1.5"></i>
                                <span x-text="profile.city || 'Not Set'"></span>, <span x-text="profile.state || 'Not Set'"></span>
                            </p>
                        </div>
                    </div>
                    <!-- Bottom White Part -->
                    <div class="p-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Profile Overview</h3>
                        <button @click="enterEditMode()" x-show="!editMode" class="flex items-center gap-2 bg-indigo-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </button>
                    </div>
                </div>

                <!-- Personal Information Form -->
                <div id="edit-form" class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Personal Information</h3>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div>
                                <label for="full-name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                                <input :disabled="!editMode" x-model="profile.full_name" type="text" id="full-name" class="mt-1 block w-full bg-gray-50 border-gray-300 rounded-md p-3 focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-200 disabled:cursor-not-allowed transition">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input :disabled="!editMode" x-model="profile.phone" type="tel" id="phone" class="mt-1 block w-full bg-gray-50 border-gray-300 rounded-md p-3 focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-200 disabled:cursor-not-allowed transition">
                            </div>
                             <div>
                                <label for="profession" class="block text-sm font-medium text-gray-700">Profession *</label>
                                <input :disabled="!editMode" x-model="profile.profession" type="text" id="profession" class="mt-1 block w-full bg-gray-50 border-gray-300 rounded-md p-3 focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-200 disabled:cursor-not-allowed transition">
                            </div>
                             <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input :disabled="!editMode" x-model="profile.city" type="text" id="city" class="mt-1 block w-full bg-gray-50 border-gray-300 rounded-md p-3 focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-200 disabled:cursor-not-allowed transition">
                            </div>
                             <div class="md:col-span-2">
                                <label for="state" class="block text-sm font-medium text-gray-700">State/District</label>
                                <input :disabled="!editMode" x-model="profile.state" type="text" id="state" class="mt-1 block w-full bg-gray-50 border-gray-300 rounded-md p-3 focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-200 disabled:cursor-not-allowed transition">
                            </div>
                            <div class="md:col-span-2">
                                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                                <textarea :disabled="!editMode" x-model="profile.bio" id="bio" rows="4" class="mt-1 block w-full bg-gray-50 border-gray-300 rounded-md p-3 focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-200 disabled:cursor-not-allowed transition"></textarea>
                            </div>
                        </div>
                        <div x-show="editMode" class="text-right space-x-3" x-transition>
                           <button @click="cancelEdit()" class="bg-gray-200 text-gray-800 font-semibold px-5 py-2.5 rounded-lg hover:bg-gray-300 transition-colors">Cancel</button>
                           <button @click="saveProfile()" :disabled="!isFormDirty()" class="bg-indigo-600 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors" :class="{ 'opacity-50 cursor-not-allowed': !isFormDirty(), 'hover:bg-indigo-700': isFormDirty() }">
                               Save Changes
                           </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Languages Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Languages</h3>
                        <button @click="showAddLanguageModal = true" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold"><i class="bi bi-plus-circle-fill mr-1"></i> Add New</button>
                    </div>
                    <div class="space-y-3">
                        <template x-if="languages.length === 0"><p class="text-sm text-gray-500">No languages added yet.</p></template>
                        <template x-for="lang in languages" :key="lang.language_name">
                            <div class="bg-indigo-50 text-indigo-800 text-sm font-medium p-3 rounded-lg" x-text="`${lang.language_name} (${lang.proficiency})`"></div>
                        </template>
                    </div>
                </div>
                
                <!-- Account Statistics -->
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Statistics</h3>
                    <ul class="space-y-4 text-sm text-gray-600">
                        <li class="flex justify-between">
                            <span>Member Since</span>
                            <span class="font-semibold text-gray-800" x-text="memberSince"></span>
                        </li>
                    </ul>
                </div>

                <!-- Danger Zone Card -->
                <div class="bg-red-50 border border-red-200 p-6 rounded-xl shadow-sm">
                     <h3 class="text-lg font-semibold text-red-800">Danger Zone</h3>
                     <p class="mt-2 text-sm text-red-700">Once you delete your account, there is no going back.</p>
                     <button class="mt-4 w-full flex items-center justify-center gap-2 bg-red-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-700"><i class="bi bi-trash-fill"></i> Delete Account</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Language Modal -->
    <div x-show="showAddLanguageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-40" style="display: none;">
        <div @click.outside="showAddLanguageModal = false" class="bg-white rounded-lg p-6 w-full max-w-md">
            <!-- Modal Content (same as before) -->
        </div>
    </div>
</div>

<!-- HOW TO ADAPT: Make sure the path to your toast notifications script is correct -->
<!-- <script src="/path/to/toast-notifications.js"></script>  -->
<script>
    function profilePage() {
        return {
            isLoading: true,
            editMode: false,
            showAddLanguageModal: false,
            originalProfile: {},
            profile: {},
            languages: [],
            memberSince: 'Loading...',

            // Fetches all initial data from the backend
            fetchProfileData() {
                this.isLoading = true;
                fetch('profile-action.php?action=fetch_profile_data')
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success' && data.user) {
                        this.profile = data.user;
                        this.originalProfile = JSON.parse(JSON.stringify(data.user)); // Deep copy for reverting changes
                        this.languages = data.languages;
                        this.memberSince = new Date(data.user.created_at).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
                    } else {
                        showToast(data.message || 'Failed to load profile data.', 'error');
                    }
                    this.isLoading = false;
                });
            },

            // Toggles the UI into edit state
            enterEditMode() {
                this.editMode = true;
            },

            // Reverts any changes and exits edit state
            cancelEdit() {
                this.profile = JSON.parse(JSON.stringify(this.originalProfile));
                this.editMode = false;
            },

            // Checks if any form fields have been changed
            isFormDirty() {
                return JSON.stringify(this.profile) !== JSON.stringify(this.originalProfile);
            },

            // Sends updated profile data to the backend
            saveProfile() {
                if (!this.isFormDirty()) return;
                const formData = new FormData();
                formData.append('action', 'update_profile');
                for (const key in this.profile) {
                    formData.append(key, this.profile[key] || ''); // Send empty string for null values
                }

                fetch('profile-action.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        showToast(data.message, 'success');
                        this.editMode = false;
                        this.fetchProfileData(); // Re-fetch data to confirm and update originalProfile state
                    } else {
                        showToast(data.message || 'An error occurred while saving.', 'error');
                    }
                });
            },
            
            // Sends new language data to the backend
            addNewLanguage() {
                const formData = new FormData();
                formData.append('action', 'add_language');
                // ... (logic from previous answer to get modal values)

                fetch('profile-action.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        showToast(data.message, 'success');
                        this.fetchProfileData(); // Re-fetch all data to show the new language
                        this.showAddLanguageModal = false;
                    } else {
                        showToast(data.message || 'Failed to add language.', 'error');
                    }
                });
            }
        }
    }
</script>
</body>
</html>