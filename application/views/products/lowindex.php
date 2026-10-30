<div class="w-full max-w-none p-6 sm:p-8 lg:p-10 bg-gradient-to-b from-slate-50 to-white min-h-screen">
  <!-- Content Header -->
  <div class="mb-10">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
      <div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Low Stock Products</h1>
        <p class="text-slate-500 mt-2 text-lg">Monitor and manage products with low inventory levels</p>
      </div>
      <nav class="flex items-center space-x-3 text-base text-slate-500 font-medium">
        <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-300">
          <i class="fas fa-home mr-2"></i>
          Dashboard
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="<?php echo base_url('products') ?>"
          class="hover:text-blue-600 transition-colors duration-300">Products</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-slate-900 font-semibold">Low Stock</span>
      </nav>
    </div>
  </div>

  <!-- Flash Messages -->
  <div id="messages" class="mb-8">
    <?php if ($this->session->flashdata('success')): ?>
      <div
        class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl flex items-center justify-between shadow-sm">
        <div class="flex items-center">
          <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
          <span class="font-medium"><?php echo $this->session->flashdata('success'); ?></span>
        </div>
        <button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors"
          onclick="this.parentElement.style.display='none'">
          <i class="fas fa-times"></i>
        </button>
      </div>
    <?php elseif ($this->session->flashdata('error')): ?>
      <div
        class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl flex items-center justify-between shadow-sm">
        <div class="flex items-center">
          <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
          <span class="font-medium"><?php echo $this->session->flashdata('error'); ?></span>
        </div>
        <button type="button" class="text-red-500 hover:text-red-700 transition-colors"
          onclick="this.parentElement.style.display='none'">
          <i class="fas fa-times"></i>
        </button>
      </div>
    <?php endif; ?>
  </div>

  <!-- Alert Banner -->
  <div class="bg-gradient-to-r from-orange-50 to-red-50 border border-orange-200 rounded-2xl p-6 mb-8 shadow-sm">
    <div class="flex items-center">
      <div class="bg-orange-100 p-3 rounded-xl mr-4">
        <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
      </div>
      <div>
        <h3 class="text-lg font-semibold text-orange-900">Low Stock Alert</h3>
        <p class="text-orange-700 mt-1 text-sm">Review products below that are running low and may require
          restocking.</p>
      </div>
    </div>
  </div>

  <!-- Action Bar -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100/50 p-6 mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div class="flex items-center space-x-4">
        <div class="bg-orange-100 p-3 rounded-xl">
          <i class="fas fa-chart-line text-orange-600 text-lg"></i>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-slate-900">Low Stock Items</h3>
          <p class="text-slate-500 text-sm" id="low-stock-count">Loading...</p>
        </div>
      </div>
      <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-3">
        <!-- Store Filter -->
        <div class="input-container" data-type="store">
          <select id="store_filter" name="store_filter"
            class="select-input w-full sm:w-48 px-4 py-2 border border-slate-100 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">All Stores</option>
            <?php foreach ($stores as $k => $v): ?>
              <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
            <?php endforeach ?>
          </select>
          <input type="text" id="store_filter_autocomplete" name="store_filter_autocomplete"
            class="autocomplete-input w-full sm:w-48 px-4 py-2 border border-slate-100 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hidden"
            placeholder="Search stores" autocomplete="off">
          <input type="hidden" id="store_filter_id" name="store_filter_id">
        </div>
        <!-- Toggle Input Mode -->
        <label class="inline-flex items-center cursor-pointer">
          <span class="mr-3 text-sm font-medium text-slate-700">Autocomplete</span>
          <input type="checkbox" id="toggle-input-mode" class="sr-only peer">
          <div
            class="relative w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-blue-600 transition-colors">
            <div
              class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-sm peer-checked:translate-x-5 transition-transform">
            </div>
          </div>
        </label>
        <!-- Action Buttons -->
        <div class="flex space-x-3">
          <a href="<?php echo base_url('products') ?>"
            class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition-colors">
            <i class="fas fa-list mr-2"></i>
            All Products
          </a>
          <?php if (in_array('createProduct', $user_permission)): ?>
            <a href="<?php echo base_url('products/create') ?>"
              class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-sm hover:shadow-md">
              <i class="fas fa-plus mr-2"></i>
              Add Product
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Low Stock Products Table -->
  <div class="bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">
    <div class="bg-gradient-to-r from-orange-50 to-red-50 px-8 py-6 border-b border-slate-100">
      <div class="flex items-center">
        <div class="bg-orange-600 p-3 rounded-xl mr-4">
          <i class="fas fa-exclamation-triangle text-white text-lg"></i>
        </div>
        <div>
          <h3 class="text-2xl font-semibold text-slate-900">Low Stock Products</h3>
          <p class="text-slate-500 text-base mt-1">Products requiring immediate attention</p>
        </div>
      </div>
    </div>

    <div class="p-8">
      <div class="overflow-x-auto">
        <table id="manageTable" class="w-full">
          <thead>
            <tr class="border-b border-slate-100">
              <th class="text-left py-4 px-4 font-semibold text-slate-700">Image</th>
              <th class="text-left py-4 px-4 font-semibold text-slate-700">Product Name</th>
              <th class="text-left py-4 px-4 font-semibold text-slate-700">Item Number</th>
              <th class="text-left py-4 px-4 font-semibold text-slate-700">Cost</th>
              <th class="text-left py-4 px-4 font-semibold text-slate-700">Current Qty</th>
              <th class="text-left py-4 px-4 font-semibold text-slate-700">Low Threshold</th>
              <th class="text-left py-4 px-4 font-semibold text-slate-700">Store</th>
              <th class="text-left py-4 px-4 font-semibold text-slate-700">Status</th>
              <?php if (in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                <th class="text-left py-4 px-4 font-semibold text-slate-700">Action</th>
              <?php endif; ?>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <!-- Remove Product Modal -->
  <div id="removeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
      <div class="p-8">
        <div class="flex items-center mb-6">
          <div class="bg-red-100 p-3 rounded-full mr-4">
            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-slate-900">Confirm Delete</h3>
            <p class="text-slate-500 text-sm mt-1">This action cannot be undone</p>
          </div>
        </div>

        <form id="removeForm">
          <div class="mb-6">
            <p class="text-slate-600">Are you sure you want to delete this product? This will permanently
              remove the product from your inventory.</p>
            <input type="hidden" name="product_id" id="product_id_to_remove" />
          </div>

          <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeRemoveModal()"
              class="px-5 py-2.5 bg-slate-200 text-slate-700 rounded-xl hover:bg-slate-300 transition-colors font-medium">
              Cancel
            </button>
            <button type="submit"
              class="px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors font-medium">
              <i class="fas fa-trash mr-2"></i>
              Delete Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
  /* DataTable Styling */
  .dataTables_wrapper {
    @apply w-full;
  }

  .dataTables_length select {
    @apply border border-slate-200 rounded-lg px-3 py-2 text-sm focus: outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
  }

  .dataTables_filter input {
    @apply border border-slate-200 rounded-lg px-4 py-2 text-sm focus: outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
  }

  .dataTables_info {
    @apply text-slate-600 text-sm;
  }

  .dataTables_paginate .paginate_button {
    @apply px-3 py-2 mx-1 text-sm border border-slate-200 rounded-lg hover: bg-blue-50 hover:border-blue-300 transition-colors;
  }

  .dataTables_paginate .paginate_button.current {
    @apply bg-blue-600 text-white border-blue-600;
  }

  #manageTable tbody tr {
    @apply border-b border-slate-50 hover: bg-slate-25 transition-colors;
  }

  #manageTable tbody td {
    @apply py-4 px-4 text-slate-700;
  }

  .product-image {
    @apply w-12 h-12 rounded-lg object-cover border border-slate-100;
  }

  .product-name {
    @apply font-medium text-slate-900;
  }

  .product-name.low-stock {
    @apply text-orange-600;
  }

  .product-name.out-of-stock {
    @apply text-red-600;
  }

  .product-sku {
    @apply text-slate-600 text-sm;
  }

  .product-price {
    @apply font-semibold text-green-600;
  }

  .product-qty {
    @apply font-medium;
  }

  .qty-low {
    @apply text-orange-600 bg-orange-50 px-2 py-1 rounded-lg;
  }

  .qty-out {
    @apply text-red-600 bg-red-50 px-2 py-1 rounded-lg;
  }

  .qty-threshold {
    @apply text-slate-500 text-sm;
  }

  .status-badge {
    @apply px-3 py-1 rounded-full text-xs font-medium;
  }

  .status-low-stock {
    @apply bg-orange-100 text-orange-800;
  }

  .status-out-stock {
    @apply bg-red-100 text-red-800;
  }

  .action-btn {
    @apply px-3 py-1.5 text-xs font-medium rounded-lg transition-colors;
  }

  .edit-btn {
    @apply bg-blue-100 text-blue-700 hover: bg-blue-200;
  }

  .delete-btn {
    @apply bg-red-100 text-red-700 hover: bg-red-200;
  }

  .ui-autocomplete {
    @apply border border-slate-100 rounded-xl shadow-lg bg-white max-h-60 overflow-y-auto z-50;
  }

  .ui-autocomplete .ui-menu-item {
    @apply px-4 py-2 text-slate-700 hover: bg-blue-50 hover:text-blue-800 cursor-pointer;
  }

  .ui-autocomplete .ui-state-active {
    @apply bg-blue-600 text-white;
  }
</style>

<script type="text/javascript">
  var manageTable;

  $(document).ready(function() {
    $("#mainProductNav").addClass('active');

    // Toggle Input Mode
    function toggleInputMode(useAutocomplete) {
      const container = $('.input-container[data-type="store"]');
      const selectInput = container.find('.select-input');
      const autocompleteInput = container.find('.autocomplete-input');
      const hiddenInput = container.find('input[type="hidden"]');

      if (useAutocomplete) {
        selectInput.addClass('hidden').prop('disabled', true);
        autocompleteInput.removeClass('hidden').prop('disabled', false);
        hiddenInput.prop('disabled', false);
      } else {
        selectInput.removeClass('hidden').prop('disabled', false);
        autocompleteInput.addClass('hidden').prop('disabled', true);
        hiddenInput.prop('disabled', true);
      }
    }

    $('#toggle-input-mode').on('change', function() {
      toggleInputMode(this.checked);
      // Update table filter
      const storeId = this.checked ? $('#store_filter_id').val() : $('#store_filter').val();
      manageTable.column(6).search(storeId).draw();
    });

    // Initialize Autocomplete
    function initAutocomplete(inputId, hiddenId, data) {
      $(`#${inputId}`).autocomplete({
        source: data,
        minLength: 0,
        select: function(event, ui) {
          $(this).val(ui.item.label);
          $(`#${hiddenId}`).val(ui.item.value.split('|')[1]);
          manageTable.column(6).search(ui.item.value.split('|')[1]).draw();
          return false;
        },
        open: function() {
          $(this).autocomplete('widget').addClass('ui-autocomplete');
        }
      }).on('focus', function() {
        $(this).autocomplete('search', '');
      });
    }

    // Store Autocomplete
    const storeData = [<?php foreach ($stores as $v): ?> "<?php echo $v['name'] . '|' . $v['id'] ?>",
      <?php endforeach ?>
    ];
    initAutocomplete('store_filter_autocomplete', 'store_filter_id', storeData);

    // Initialize DataTable
    manageTable = $('#manageTable').DataTable({
      'ajax': '<?php echo base_url('products/fetchLowStockData'); ?>',
      'order': [
        [4, 'asc']
      ], // Order by quantity ascending (lowest first)
      'processing': true,
      'serverSide': false,
      'responsive': true,
      'language': {
        'search': '',
        'searchPlaceholder': 'Search low stock products...',
        'lengthMenu': 'Show _MENU_ products',
        'info': 'Showing _START_ to _END_ of _TOTAL_ low stock products',
        'infoEmpty': 'No low stock products found',
        'infoFiltered': '(filtered from _MAX_ total low stock products)',
        'paginate': {
          'first': 'First',
          'last': 'Last',
          'next': 'Next',
          'previous': 'Previous'
        }
      },
      'dom': '<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"<"flex items-center"l><"flex items-center"f>>rtip',
      'drawCallback': function(settings) {
        // Update low stock count
        var info = this.api().page.info();
        $('#low-stock-count').text(info.recordsTotal + ' products need attention');

        // Apply custom styling to new elements
        $('.dataTables_length').addClass('flex items-center space-x-2');
        $('.dataTables_length label').addClass('text-sm text-slate-600 font-medium');
        $('.dataTables_filter').addClass('flex items-center space-x-2');
        $('.dataTables_filter label').addClass('text-sm text-slate-600 font-medium');
        $('.dataTables_paginate').addClass('flex items-center justify-center space-x-1 mt-6');
      }
    });

    // Store Filter Change
    $('#store_filter').on('change', function() {
      manageTable.column(6).search(this.value).draw();
    });

    // Handle delete button click
    $(document).on('click', '.remove-btn', function() {
      var productId = $(this).data('id');
      $('#product_id_to_remove').val(productId);
      showRemoveModal();
    });

    // Handle form submission
    $("#removeForm").on('submit', function(event) {
      event.preventDefault();
      var productId = $('#product_id_to_remove').val();

      $.ajax({
        url: '<?php echo base_url('products/remove'); ?>',
        type: 'POST',
        data: {
          product_id: productId
        },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#messages').html(`
              <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                  <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                  <span class="font-medium">${response.messages}</span>
                </div>
                <button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors" onclick="this.parentElement.style.display='none'">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            `);
            closeRemoveModal();
            manageTable.ajax.reload(null, false);
          } else {
            $('#messages').html(`
              <div class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                  <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                  <span class="font-medium">${response.messages}</span>
                </div>
                <button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display='none'">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            `);
          }
        },
        error: function() {
          $('#messages').html(`
            <div class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl flex items-center justify-between shadow-sm">
              <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span class="font-medium">An error occurred while deleting the product.</span>
              </div>
              <button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
              </button>
            </div>
          `);
        }
      });
    });

    // Initial state: use select dropdown
    toggleInputMode(false);
  });

  function showRemoveModal() {
    $('#removeModal').removeClass('hidden').addClass('flex');
  }

  function closeRemoveModal() {
    $('#removeModal').addClass('hidden').removeClass('flex');
  }

  // Close modal when clicking outside
  $(document).on('click', '#removeModal', function(e) {
    if (e.target === this) {
      closeRemoveModal();
    }
  });
</script>
