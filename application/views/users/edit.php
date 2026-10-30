<!-- Enhanced form design with better visual hierarchy and modern styling -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
  <div class="p-4 sm:p-6 lg:p-8">
    <!-- Content Header -->
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Edit User</h1>
          <p class="text-slate-600 mt-1">Update the user account and group</p>
        </div>
        <nav class="flex items-center space-x-2 text-sm text-slate-500">
          <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
            <i class="fas fa-home mr-1"></i>
            Home
          </a>
          <i class="fas fa-chevron-right text-xs"></i>
          <span class="text-slate-900 font-medium">Users</span>
        </nav>
      </div>
    </div>



    <!-- User Form -->
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden">
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
        <div class="flex items-center">
          <div class="bg-white/20 p-2 rounded-lg mr-3">
            <i class="fas fa-user-edit text-white text-lg"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-white">User Information</h3>
            <p class="text-blue-100 text-sm">Leave the password fields empty to keep the current password</p>
          </div>
        </div>
      </div>

      <form role="form" action="<?php echo base_url('users/edit/' . $user_data['id']); ?>" method="post">
        <div class="p-6 lg:p-8 space-y-8">

          <?php if (validation_errors()): ?>
            <div class="bg-red-50 border-l-4 border-red-400 text-red-800 px-4 py-3 rounded-r-lg">
              <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                <div><?php echo validation_errors(); ?></div>
              </div>
            </div>
          <?php endif; ?>

          <!-- Group Selection -->
          <div class="space-y-3">
            <label for="groups" class="block text-sm font-semibold text-slate-700">
              <i class="fas fa-users-cog text-blue-500 mr-2"></i>
              User Group
            </label>
            <select
              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
              id="groups" name="groups">
              <option value="">Select User Group</option>
              <?php foreach ($group_data as $k => $v): ?>
                <option value="<?php echo $v['id'] ?>" <?php if ($user_group && $user_group['id'] == $v['id']) echo 'selected'; ?>><?php echo html_escape($v['group_name']) ?></option>
              <?php endforeach ?>
            </select>
          </div>

          <!-- Account Credentials Section -->
          <div class="bg-slate-50 rounded-xl p-6 space-y-6">
            <h4 class="text-lg font-semibold text-slate-800 flex items-center">
              <i class="fas fa-key text-blue-500 mr-2"></i>
              Account Credentials
            </h4>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- Username -->
              <div class="space-y-3">
                <label for="username"
                  class="block text-sm font-semibold text-slate-700">Username</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-slate-400"></i>
                  </div>
                  <input type="text"
                    class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                    id="username" name="username" placeholder="Enter unique username"
                    value="<?php echo html_escape($user_data['username']) ?>"
                    autocomplete="off">
                </div>
              </div>

              <!-- Email -->
              <div class="space-y-3">
                <label for="email" class="block text-sm font-semibold text-slate-700">Email
                  Address</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-slate-400"></i>
                  </div>
                  <input type="email"
                    class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                    id="email" name="email" placeholder="user@example.com" value="<?php echo html_escape($user_data['email']) ?>" autocomplete="off">
                </div>
              </div>

              <!-- Password -->
              <div class="space-y-3">
                <label for="password"
                  class="block text-sm font-semibold text-slate-700">Password</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-slate-400"></i>
                  </div>
                  <input type="password"
                    class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                    id="password" name="password" placeholder="Leave empty to keep current"
                    autocomplete="off">
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="space-y-3">
                <label for="cpassword" class="block text-sm font-semibold text-slate-700">Confirm
                  Password</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-slate-400"></i>
                  </div>
                  <input type="password"
                    class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                    id="cpassword" name="cpassword" placeholder="Leave empty to keep current"
                    autocomplete="off">
                </div>
              </div>
            </div>
          </div>

          <!-- Personal Information Section -->
          <div class="bg-slate-50 rounded-xl p-6 space-y-6">
            <h4 class="text-lg font-semibold text-slate-800 flex items-center">
              <i class="fas fa-id-card text-blue-500 mr-2"></i>
              Personal Information
            </h4>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- First Name -->
              <div class="space-y-3">
                <label for="fname" class="block text-sm font-semibold text-slate-700">First Name</label>
                <input type="text"
                  class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                  id="fname" name="fname" placeholder="Enter first name" value="<?php echo html_escape($user_data['firstname']) ?>" autocomplete="off">
              </div>

              <!-- Last Name -->
              <div class="space-y-3">
                <label for="lname" class="block text-sm font-semibold text-slate-700">Last Name</label>
                <input type="text"
                  class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                  id="lname" name="lname" placeholder="Enter last name" value="<?php echo html_escape($user_data['lastname']) ?>" autocomplete="off">
              </div>

              <!-- Phone -->
              <div class="space-y-3">
                <label for="phone" class="block text-sm font-semibold text-slate-700">Phone
                  Number</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-phone text-slate-400"></i>
                  </div>
                  <input type="text"
                    maxlength="11" pattern="^\+?[0-9\s]+$"
                    type="number"
                    class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                    id="phone" name="phone" placeholder="+639 123 45678" value="<?php echo html_escape($user_data['phone']) ?>" autocomplete="off">
                </div>
              </div>

              <!-- Gender -->
              <div class="space-y-3">
                <label class="block text-sm font-semibold text-slate-700">Gender</label>
                <div class="flex space-x-6 pt-2">
                  <label class="flex items-center cursor-pointer">
                    <input type="radio" name="gender" id="male" value="1" <?php if ($user_data['gender'] == 1) echo 'checked'; ?>
                      class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500 focus:ring-2">
                    <span class="ml-3 text-sm font-medium text-slate-700">Male</span>
                  </label>
                  <label class="flex items-center cursor-pointer">
                    <input type="radio" name="gender" id="female" value="2" <?php if ($user_data['gender'] == 2) echo 'checked'; ?>
                      class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500 focus:ring-2">
                    <span class="ml-3 text-sm font-medium text-slate-700">Female</span>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div
          class="px-6 lg:px-8 py-6 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
          <a href="<?php echo base_url('users/') ?>"
            class="px-6 py-3 text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-all duration-200 font-medium text-center shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Users
          </a>
          <button type="submit" id="saveUserBtn"
            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
            <span class="btn-text">
              <i class="fas fa-save mr-2"></i>
              Save Changes
            </span>
            <span class="btn-loading hidden">
              <i class="fas fa-spinner fa-spin mr-2"></i>
              Saving...
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    $('form').on('submit', function() {
      const submitBtn = $('#saveUserBtn');
      const btnText = submitBtn.find('.btn-text');
      const btnLoading = submitBtn.find('.btn-loading');

      // Show loading state
      btnText.addClass('hidden');
      btnLoading.removeClass('hidden');
      submitBtn.prop('disabled', true);
    });
  });
</script>