<!-- Enhanced footer with better responsive design and branding -->
<footer class="bg-white border-t border-gray-200  w-full">
  <div class="px-6 py-6">
    <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
      <div class="flex items-center space-x-3">
        <div
          class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-lg">
          <span class="text-white font-bold text-sm">D</span>
        </div>
        <div>
          <span class="text-gray-800 font-bold text-lg">Delta P, Inc.</span>
          <p class="text-gray-500 text-sm">Inventory Management System</p>
        </div>
      </div>

      <div
        class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-6 text-sm text-gray-500">
        <span>© <?php echo date('Y'); ?> All rights reserved</span>

      </div>
    </div>
  </div>
</footer>

<!-- Enhanced JavaScript with better animations -->
<script>
  $(document).ready(function() {
    // Smooth fade-in effect for the footer
    $('footer').css('opacity', '0').animate({
      opacity: 1
    }, 800);

    // Enhanced hover effects
    $('footer a').hover(
      function() {
        $(this).css('transform', 'translateY(-1px)');
      },
      function() {
        $(this).css('transform', 'translateY(0)');
      }
    );

    // Logo hover effect
    $('footer .w-8').hover(
      function() {
        $(this).css('transform', 'scale(1.1) rotate(5deg)');
      },
      function() {
        $(this).css('transform', 'scale(1) rotate(0deg)');
      }
    );
  });
</script>

</body>

</html>
