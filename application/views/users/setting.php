<!-- Completely modernized settings page with Tailwind CSS -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Account Settings</h1>
                    <nav class="flex items-center space-x-2 text-sm text-gray-600">
                        <a href="<?php echo base_url('dashboard') ?>" class="hover:text-blue-600 transition-colors">
                            <i class="fas fa-home mr-1"></i>Home
                        </a>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="text-gray-900 font-medium">Settings</span>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <!-- <?php if ($this->session->flashdata('success')): ?>
      <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center">
        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
          <i class="fas fa-check text-green-600"></i>
        </div>
        <div class="flex-1">
          <p class="text-green-800 font-medium">Success!</p>
          <p class="text-green-700 text-sm"><?php echo $this->session->flashdata('success'); ?></p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">
          <i class="fas fa-times"></i>
        </button>
      </div>
    <?php elseif ($this->session->flashdata('error')): ?>
      <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-center">
        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
          <i class="fas fa-exclamation-triangle text-red-600"></i>
        </div>
        <div class="flex-1">
          <p class="text-red-800 font-medium">Error!</p>
          <p class="text-red-700 text-sm"><?php echo $this->session->flashdata('error'); ?></p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600">
          <i class="fas fa-times"></i>
        </button>
      </div>
    <?php endif; ?> -->

        <!-- Settings Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-user-cog mr-3"></i>
                    Update Your Information
                </h2>
                <p class="text-blue-100 mt-1">Keep your account information up to date</p>
            </div>

            <!-- Form Content -->
            <form role="form" action="<?php base_url('users/setting') ?>" method="post" class="p-8">

                <!-- Validation Errors -->
                <?php if (validation_errors()): ?>
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                        <h4 class="text-red-800 font-medium">Please fix the following errors:</h4>
                    </div>
                    <div class="text-red-700 text-sm">
                        <?php echo validation_errors(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Personal Information
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-1 text-gray-400"></i>
                                    Username
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    id="username" name="username" placeholder="Enter your username"
                                    value="<?php echo $user_data['username'] ?>" autocomplete="off">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-1 text-gray-400"></i>
                                    Email Address
                                </label>
                                <input type="email"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    id="email" name="email" placeholder="Enter your email"
                                    value="<?php echo $user_data['email'] ?>" autocomplete="off">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="fname" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-id-card mr-1 text-gray-400"></i>
                                        First Name
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        id="fname" name="fname" placeholder="First name"
                                        value="<?php echo $user_data['firstname'] ?>" autocomplete="off">
                                </div>

                                <div>
                                    <label for="lname" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-id-card mr-1 text-gray-400"></i>
                                        Last Name
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        id="lname" name="lname" placeholder="Last name"
                                        value="<?php echo $user_data['lastname'] ?>" autocomplete="off">
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-1 text-gray-400"></i>
                                    Phone Number
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    id="phone" name="phone" placeholder="Enter your phone number"
                                    value="<?php echo $user_data['phone'] ?>" autocomplete="off">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <i class="fas fa-venus-mars mr-1 text-gray-400"></i>
                                    Gender
                                </label>
                                <div class="flex space-x-6">
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" id="male" value="1"
                                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                            <?php if ($user_data['gender'] == 1) echo "checked"; ?>>
                                        <span class="ml-2 text-gray-700">Male</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" id="female" value="2"
                                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                            <?php if ($user_data['gender'] == 2) echo "checked"; ?>>
                                        <span class="ml-2 text-gray-700">Female</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>
                            Security Settings
                        </h3>

                        <!-- Password Info Alert -->
                        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                <p class="text-blue-800 text-sm">
                                    Leave the password fields empty if you don't want to change your password.
                                </p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-key mr-1 text-gray-400"></i>
                                    New Password
                                </label>
                                <input type="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    id="password" name="password" placeholder="Enter new password" autocomplete="off">
                            </div>

                            <div>
                                <label for="cpassword" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-key mr-1 text-gray-400"></i>
                                    Confirm New Password
                                </label>
                                <input type="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    id="cpassword" name="cpassword" placeholder="Confirm new password"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-4">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                    <a href="<?php echo base_url('users/profile') ?>"
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Profile
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>