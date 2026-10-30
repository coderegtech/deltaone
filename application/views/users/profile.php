<!-- Completely modernized profile page with Tailwind CSS -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl  font-bold text-slate-900">User Profile</h1>
                    <nav class="flex items-center space-x-2 text-sm text-gray-600">
                        <a href="<?php echo base_url('dashboard') ?>" class="hover:text-blue-600 transition-colors">
                            <i class="fas fa-home mr-1"></i>Home
                        </a>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="text-gray-900 font-medium">Profile</span>
                    </nav>
                </div>

            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-12 text-center">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-2xl font-bold text-blue-600">
                        <?php echo strtoupper(substr($user_data['firstname'], 0, 1) . substr($user_data['lastname'], 0, 1)); ?>
                    </span>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">
                    <?php echo $user_data['firstname'] . ' ' . $user_data['lastname']; ?>
                </h2>
                <p class="text-blue-100">
                    <i class="fas fa-envelope mr-2"></i>
                    <?php echo $user_data['email']; ?>
                </p>
            </div>

            <!-- Profile Details -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Personal Information
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Username</p>
                                    <p class="font-semibold text-gray-900"><?php echo $user_data['username']; ?></p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-id-card text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">First Name</p>
                                    <p class="font-semibold text-gray-900"><?php echo $user_data['firstname']; ?></p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-id-card text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Last Name</p>
                                    <p class="font-semibold text-gray-900"><?php echo $user_data['lastname']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact & System Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-cog mr-2 text-blue-600"></i>
                            Contact & System Info
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-phone text-orange-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Phone</p>
                                    <p class="font-semibold text-gray-900">
                                        <?php echo $user_data['phone'] ?: 'Not provided'; ?></p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div
                                    class="w-10 h-10 <?php echo ($user_data['gender'] == 1) ? 'bg-blue-100' : (($user_data['gender'] == 2) ? 'bg-pink-100' : 'bg-gray-200'); ?> rounded-lg flex items-center justify-center mr-4">
                                    <?php
                  echo ($user_data['gender'] == 1)
                    ? '<i class="fas fa-mars text-blue-600"></i>'
                    : (($user_data['gender'] == 2)
                      ? '<i class="fas fa-venus text-pink-600"></i>'
                      : '<i class="fas fa-genderless text-gray-600"></i>');
                  ?>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Gender</p>
                                    <p class="font-semibold text-gray-900">
                                        <?php echo ($user_data['gender'] == 1) ? 'Male' : (($user_data['gender'] == 2) ? 'Female' : 'Not specified'); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-users text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">User Group</p>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-shield-alt mr-1"></i>
                                        <?php echo $user_group['group_name']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <?php if (in_array('updateSetting', $user_permission)): ?>
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-4">
                    <a class="flex-1">
                    </a>
                    <a href="<?php echo base_url('users/setting') ?>"
                        class="flex-1 inline-flex items-center justify-center px-10 py-3 bg-blue-600 text-lg text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profile
                    </a>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>