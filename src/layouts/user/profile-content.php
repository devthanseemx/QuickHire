<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <!-- Links (Alpine.js, Bootstrap Icons) are assumed to be in the parent dashboard file -->
    <style>
        .profile-header-gradient {
            background-image: linear-gradient(to right, #6366F1, #9333EA);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
   <!-- This file is now a clean "view". It assumes all PHP variables have been prepared already. -->
<div class="container mx-auto p-4 sm:p-6 lg:p-8" x-data="profileComponent">
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Profile Settings</h1>
        <p class="text-gray-500 mt-1 text-sm md:text-base">Manage your personal information and account settings</p>
    </div>

    <!-- The form action now points back to the dashboard page to be handled by the controller -->
    <form method="POST" action="dashboard.php?page=profile" enctype="multipart/form-data">
        <!-- The rest of the HTML is exactly the same as the previous correct answer -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="profile-header-gradient p-6">
                        <div class="flex items-center">
                            <div class="relative">
                                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-white bg-opacity-20 flex items-center justify-center overflow-hidden">
                                    <?php
                                        $default_image_path = '../../../uploads/default_profile.jpeg';
                                        $current_image_path = !empty($profileImage) ? '../../../uploads/profile_images/' . htmlspecialchars($profileImage) : $default_image_path;
                                    ?>
                                    <img :src="imagePreviewUrl || '<?php echo $current_image_path; ?>'" alt="Profile Picture" class="w-full h-full object-cover">
                                </div>
                                <label for="profile-upload" x-show="editMode" class="absolute bottom-1 right-1 bg-white w-8 h-8 md:w-9 md:h-9 rounded-full flex items-center justify-center cursor-pointer shadow-md hover:bg-gray-100 transition-colors">
                                    <i class="bi bi-camera-fill text-indigo-600"></i>
                                </label>
                                <input type="file" name="profile_upload" id="profile-upload" class="hidden" @change="previewImage">
                            </div>
                            <div class="ml-4 md:ml-6 text-white">
                                <h2 class="text-2xl md:text-3xl font-bold"><?php echo htmlspecialchars($fullName); ?></h2>
                                <p class="text-indigo-200 text-sm"><?php echo htmlspecialchars($profession); ?></p>
                                <p class="text-indigo-200 text-sm mt-1 flex items-center">
                                    <i class="bi bi-geo-alt mr-1"></i>
                                    <?php echo htmlspecialchars($city); ?><?php if($city && $state) { echo ', '; } ?><?php echo htmlspecialchars($state); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-4 sm:mb-0">Profile Overview</h3>
                        <div class="flex items-center space-x-2">
                            <button @click.prevent="startEditing()" x-show="!editMode" type="button" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center shadow-sm text-sm">
                                <i class="bi bi-pencil-square mr-2"></i>Edit Profile
                            </button>
                            <div x-show="editMode" class="flex items-center space-x-2">
                                <button @click.prevent="cancelEditing()" type="button" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-300 flex items-center text-sm">
                                    <i class="bi bi-x-lg mr-2"></i>Cancel
                                </button>
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center shadow-sm text-sm">
                                    <i class="bi bi-save mr-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-6 pb-2">Personal Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        <div><label for="fullName" class="block text-sm font-medium text-gray-600">Full Name *</label><div x-show="!editMode" class="mt-1 w-full h-11 flex items-center px-3 bg-gray-100 rounded-md text-gray-700"><?php echo htmlspecialchars($fullName); ?></div><input x-show="editMode" type="text" name="fullName" id="fullName" value="<?php echo htmlspecialchars($fullName); ?>" class="mt-1 block w-full h-11 px-3 border border-gray-300 rounded-md"></div>
                        <div><label for="email" class="block text-sm font-medium text-gray-600">Email Address *</label><div x-show="!editMode" class="flex items-center mt-1 w-full h-11 px-3 bg-gray-100 rounded-md text-gray-700 truncate"><i class="bi bi-envelope mr-2 text-gray-400"></i><?php echo htmlspecialchars($email); ?></div><input x-show="editMode" type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" class="mt-1 block w-full h-11 px-3 border border-gray-300 rounded-md"></div>
                        <div><label for="phone" class="block text-sm font-medium text-gray-600">Phone Number</label><div x-show="!editMode" class="flex items-center mt-1 w-full h-11 px-3 bg-gray-100 rounded-md text-gray-700"><i class="bi bi-phone mr-2 text-gray-400"></i><?php echo htmlspecialchars($phone); ?></div><input x-show="editMode" type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>" class="mt-1 block w-full h-11 px-3 border border-gray-300 rounded-md"></div>
                        <div><label for="profession" class="block text-sm font-medium text-gray-600">Profession *</label><div x-show="!editMode" class="mt-1 w-full h-11 flex items-center px-3 bg-gray-100 rounded-md text-gray-700"><?php echo htmlspecialchars($profession); ?></div><input x-show="editMode" type="text" name="profession" id="profession" value="<?php echo htmlspecialchars($profession); ?>" class="mt-1 block w-full h-11 px-3 border border-gray-300 rounded-md"></div>
                        <div><label for="city" class="block text-sm font-medium text-gray-600">City</label><div x-show="!editMode" class="mt-1 w-full h-11 flex items-center px-3 bg-gray-100 rounded-md text-gray-700"><?php echo htmlspecialchars($city); ?></div><input x-show="editMode" type="text" name="city" id="city" value="<?php echo htmlspecialchars($city); ?>" class="mt-1 block w-full h-11 px-3 border border-gray-300 rounded-md"></div>
                        <div><label for="state" class="block text-sm font-medium text-gray-600">State/District</label><div x-show="!editMode" class="mt-1 w-full h-11 flex items-center px-3 bg-gray-100 rounded-md text-gray-700"><?php echo htmlspecialchars($state); ?></div><input x-show="editMode" type="text" name="state" id="state" value="<?php echo htmlspecialchars($state); ?>" class="mt-1 block w-full h-11 px-3 border border-gray-300 rounded-md"></div>
                        <div class="md:col-span-2"><label for="bio" class="block text-sm font-medium text-gray-600">Bio</label><div x-show="!editMode" class="mt-1 w-full p-3 bg-gray-100 rounded-md text-gray-700 text-sm min-h-[6rem]"><?php echo nl2br(htmlspecialchars($bio)); ?></div><textarea x-show="editMode" name="bio" id="bio" rows="4" class="mt-1 block w-full p-3 border border-gray-300 rounded-md"><?php echo htmlspecialchars($bio); ?></textarea></div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Languages</h4>
                    <input type="hidden" name="languages_json" :value="JSON.stringify(editedLanguages)">
                    <div class="space-y-3">
                        <template x-for="(language, index) in (editMode ? editedLanguages : languages)" :key="index"><div class="flex items-center justify-between bg-indigo-50 text-indigo-700 text-sm font-medium px-4 h-10 rounded-lg"><span x-text="language.name + ' (' + language.fluency + ')'"></span><button @click.prevent="removeLanguage(index)" x-show="editMode" type="button" class="text-red-500 hover:text-red-700"><i class="bi bi-trash-fill"></i></button></div></template>
                        <div x-show="editMode && addingLanguage" class="p-3 bg-gray-50 rounded-lg space-y-3"><input type="text" x-model="newLanguage.name" placeholder="Language" class="w-full h-11 px-3 border border-gray-300 rounded-md"><div class="relative"><select x-model="newLanguage.fluency" class="w-full h-11 pl-3 pr-8 border border-gray-300 rounded-md appearance-none"><option>Basic</option><option>Conversational</option><option>Fluent</option><option>Native</option></select><i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500"></i></div><button @click.prevent="addNewLanguageToList()" type="button" class="w-full bg-indigo-500 text-white h-10 rounded-md text-sm font-semibold hover:bg-indigo-600">Add</button></div>
                        <button @click.prevent="addingLanguage = true" x-show="editMode && !addingLanguage" type="button" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold pt-2 flex items-center w-full justify-center"><i class="bi bi-plus-circle mr-2"></i> Add New Language</button>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6"><h4 class="text-lg font-semibold text-gray-800 mb-4">Account Statistics</h4><ul class="space-y-3 text-sm text-gray-600"><li class="flex justify-between"><span>Member Since</span><span class="font-medium text-gray-800"><?php echo $memberSince; ?></span></li></ul></div>
                <div class="bg-white rounded-lg shadow p-6"><div class="bg-red-50 rounded-lg p-4"><h4 class="text-lg font-semibold text-red-800">Danger Zone</h4><p class="text-red-700 mt-2 text-sm">Once you delete your account, there is no going back. Please be certain.</p><button type="button" class="mt-4 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300 text-sm font-semibold flex items-center"><i class="bi bi-trash mr-2"></i>Delete Account</button></div></div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('profileComponent', () => ({
            editMode: false,
            imagePreviewUrl: null,
            languages: <?php echo json_encode($languages_data ?? []); ?>,
            editedLanguages: [],
            addingLanguage: false,
            newLanguage: { name: '', fluency: 'Basic' },
            init() { this.editedLanguages = JSON.parse(JSON.stringify(this.languages)); },
            previewImage(event) { const file = event.target.files[0]; if (file) { this.imagePreviewUrl = URL.createObjectURL(file); } },
            startEditing() { this.editMode = true; this.editedLanguages = JSON.parse(JSON.stringify(this.languages)); },
            cancelEditing() { this.editMode = false; this.addingLanguage = false; this.newLanguage = { name: '', fluency: 'Basic' }; this.imagePreviewUrl = null; },
            addNewLanguageToList() { if (this.newLanguage.name.trim() === '') return; this.editedLanguages.push({ ...this.newLanguage }); this.newLanguage = { name: '', fluency: 'Basic' }; this.addingLanguage = false; },
            removeLanguage(index) { this.editedLanguages.splice(index, 1); }
        }));
    });
</script>
</body>

</html>