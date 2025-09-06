<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Link to your compiled Tailwind CSS file -->
    <link href="/path/to/your/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script> <!-- For easy testing -->
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Main Container -->
    <div class="container mx-auto p-4 md:p-8">
        
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            
            <!-- Cover Photo -->
            <!-- HOW TO ADAPT: Replace the bg-gray-400 with an <img> tag or a style with your background image -->
            <div class="h-48 bg-gray-400 bg-cover bg-center">
                <!-- You can place an <img class="w-full h-full object-cover" src="..."> here -->
            </div>

            <!-- Profile Picture & Main Info -->
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row items-center md:items-start text-center md:text-left">
                    
                    <!-- Profile Picture -->
                    <!-- The negative margin pulls the image up to overlap the cover photo -->
                    <div class="flex-shrink-0 -mt-24">
                        <!-- HOW TO ADAPT: Replace the placeholder with your user's <img> -->
                        <img 
                            class="h-32 w-32 rounded-full border-4 border-white object-cover shadow-md"
                            src="https://via.placeholder.com/150" 
                            alt="User Profile Picture"
                        >
                    </div>

                    <!-- User Name, Title, and Location -->
                    <div class="md:ml-6 mt-4 md:mt-0">
                        <h1 class="text-3xl font-bold text-gray-800">Your Name Here</h1>
                        <p class="text-md text-gray-600 mt-1">Job Title (e.g., Senior Developer)</p>
                        <p class="text-sm text-gray-500 mt-1">City, Country</p>
                    </div>

                    <!-- Action Buttons (Desktop) -->
                    <div class="ml-auto mt-4 md:mt-2 space-x-2">
                        <button class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Edit Profile
                        </button>
                        <button class="bg-gray-200 text-gray-800 font-semibold px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            Contact
                        </button>
                    </div>
                </div>
            </div>

            <!-- Separator -->
            <hr class="border-gray-200">

            <!-- Profile Content (About, Settings, etc.) -->
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">About Me</h2>
                
                <!-- HOW TO ADAPT: Place your user's bio here -->
                <p class="text-gray-700 leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.
                </p>

                <!-- Additional Sections can go here (e.g., Skills, Experience) -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Skills</h2>
                    <div class="flex flex-wrap gap-2">
                        <!-- HOW TO ADAPT: Dynamically generate these from your database -->
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">PHP</span>
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">JavaScript</span>
                        <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">MySQL</span>
                        <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full">Tailwind CSS</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>