<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'blue-200': '#5CDEFF',
            'blue-500': '#5CDEFF',
            'blue-600': '#00ccff',
            'blue-700': '#3b82f6',

          },
        },
      },
    }
  </script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 flex items-center justify-center p-4">
  <!-- Replaced AdminLTE login box with modern Tailwind design -->
  <div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
      <!-- Logo Section -->
      <div class="bg-gradient-to-r from-blue-500 to-blue-700 px-8 py-12 text-center">
        <div class="mb-4">
          <img id="logo" src="<?php echo base_url('assets/images/deltaone.png'); ?>"
            alt="Inventory System Logo"
            class="w-20 h-20 mx-auto rounded-full object-cover bg-white shadow-lg hover:scale-110 transition-transform duration-300 cursor-pointer">
        </div>
        <h1 class="text-2xl font-bold text-white mb-2">DeltaOne</h1>

        <p class="text-blue-100 text-sm">Sign in to start your session</p>
      </div>

      <!-- Form Section -->
      <div class="px-8 py-8">
        <?php echo validation_errors('<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">', '</div>'); ?>

        <?php if (!empty($errors)): ?>
          <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
            <?php echo $errors; ?>
          </div>
        <?php endif; ?>

        <form action="<?php echo base_url('auth/login') ?>" method="post" class="space-y-6">
          <!-- Email Field -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-gray-400"></i>
              </div>
              <input type="email"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                name="email" id="email" placeholder="Enter your email" autocomplete="off" required>
            </div>
          </div>

          <!-- Password Field -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-lock text-gray-400"></i>
              </div>
              <input type="password"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                name="password" id="password" placeholder="Enter your password" autocomplete="off"
                required>
            </div>
          </div>

          <!-- Remember Me & Submit -->
          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input type="checkbox"
                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
              <span class="ml-2 text-sm text-gray-600">Remember Me</span>
            </label>
          </div>

          <button type="submit"
            class="w-full bg-blue-700 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
            Sign In
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Logo click refresh
      $('#logo').click(function() {
        location.reload();
      });

      // Form validation feedback
      $('input[required]').on('blur', function() {
        if ($(this).val() === '') {
          $(this).addClass('border-red-300 focus:border-red-300 focus:ring-red-200');
        } else {
          $(this).removeClass('border-red-300 focus:border-red-300 focus:ring-red-200');
        }
      });
    });
  </script>
</body>

</html>