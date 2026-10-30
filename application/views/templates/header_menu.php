<!-- Enhanced header with better responsive design and sidebar toggle functionality -->
<header class="bg-white shadow-sm border-b border-gray-200 py-3 flex-shrink-0 z-10">
  <div class="flex items-center justify-between h-full px-4 lg:px-6">
    <!-- Mobile menu button and desktop toggle -->
    <div class="flex items-center">
      <button id="sidebar-toggle"
        class="flex flex-col gap-y-2 p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors duration-200 mr-2">
        <span class="w-8 h-1.5 bg-blue-500 rounded-xl "></span>
        <span class="w-6 h-1.5 bg-blue-500 rounded-xl "></span>
        <span class="w-4 h-1.5 bg-blue-500 rounded-xl "></span>
      </button>
    </div>

    <!-- Right side items -->
    <div class="flex items-center space-x-2 sm:space-x-4">
      <!-- Notifications -->
      <!-- <button
        class="hidden sm:flex p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors duration-200 relative">
        <i class="fas fa-bell text-lg"></i>
        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
      </button> -->

      <!-- User menu dropdown -->
      <div class="relative group">
        <button
          class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
          <div
            class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
            <i class="fas fa-user text-white text-sm"></i>
          </div>
          <div class="hidden md:block text-left">
            <p class="text-sm font-medium text-gray-700 truncate max-w-32">
              <?php echo $this->session->userdata('username'); ?>
            </p>
            <p class="text-xs text-gray-500 truncate max-w-32">
              <?php echo $this->session->userdata('email'); ?>
            </p>
          </div>
          <i
            class="fas fa-chevron-down text-xs text-gray-400 hidden md:block group-hover:rotate-180 transition-transform duration-200"></i>
        </button>

        <!-- Dropdown menu -->
        <div
          class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
          <div class="py-2">
            <a href="<?php echo base_url('users/profile') ?>"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
              <i class="fas fa-user-circle mr-3 text-gray-400"></i>
              Profile
            </a>
            <a href="<?php echo base_url('users/setting') ?>"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
              <i class="fas fa-cog mr-3 text-gray-400"></i>
              Settings
            </a>
            <hr class="my-2 border-gray-200">
            <a href="<?php echo base_url('auth/logout') ?>"
              class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
              <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>
              Logout
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Enhanced JavaScript with better responsive functionality -->
<script>
  $(document).ready(function() {
    // Logo click refresh
    $('#logo').on('click', function(e) {
      e.preventDefault();
      location.reload();
    });

    // Enhanced hover effects
    $('a, button').hover(
      function() {
        $(this).addClass('transition-all duration-200');
        if ($(this).find('.fa-chevron-down').length) {
          $(this).find('.fa-chevron-down').addClass('rotate-180');
        }
      },
      function() {
        $(this).removeClass('transition-all duration-200');
        if ($(this).find('.fa-chevron-down').length) {
          $(this).find('.fa-chevron-down').removeClass('rotate-180');
        }
      }
    );

    // Handle responsive search
    function handleResponsiveSearch() {
      const $search = $('.hidden.md\\:flex');
      if ($(window).width() < 768) {
        $search.hide();
      } else {
        $search.show();
      }
    }

    // Mobile search toggle
    $('.fa-search').parent().on('click', function(e) {
      if ($(window).width() < 768) {
        e.preventDefault();
        // Could implement mobile search modal here
      }
    });

    // Initial call and resize handler
    handleResponsiveSearch();
    $(window).on('resize', handleResponsiveSearch);

    // Smooth dropdown animations
    $('.group').hover(
      function() {
        $(this).find('.absolute').removeClass('opacity-0 invisible').addClass('opacity-100 visible');
      },
      function() {
        $(this).find('.absolute').removeClass('opacity-100 visible').addClass('opacity-0 invisible');
      }
    );
  });
</script>