<div class="w-full max-w-none p-4 sm:p-6 lg:p-8">
  <!-- Content Header -->
  <div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manage Brands</h1>
        <p class="text-slate-600 mt-1">Brand management and configuration</p>
      </div>
      <nav class="flex items-center space-x-2 text-sm text-slate-500">
        <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
          <i class="fas fa-home mr-1"></i>
          Home
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-slate-900 font-medium">Brands</span>
      </nav>
    </div>
  </div>

  <!-- Flash Messages -->
  <div id="messages"></div>

  <!-- Action Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div class="flex items-center space-x-4">
      <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-slate-200">
        <span class="text-sm text-slate-600">Total Brands: </span>
        <span class="font-semibold text-slate-900" id="totalBrands">0</span>
      </div>
    </div>

    <?php if (in_array('createBrand', $user_permission)): ?>
      <button
        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl"
        onclick="showModal('addModal')">
        <i class="fas fa-plus mr-2"></i>
        Add Brand
      </button>
    <?php endif; ?>
  </div>

  <!-- Brands Table -->
  <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden w-full">
    <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-5 border-b border-slate-200">
      <div class="flex items-center">
        <div class="bg-blue-600 p-2 rounded-lg mr-3">
          <i class="fas fa-tags text-white"></i>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-slate-900">Manage Brands</h3>
          <p class="text-slate-600 text-sm">Brand management and configuration</p>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto w-full">
      <table id="manageTable" class="w-full min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-8 py-5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
              Brand Name</th>
            <th class="px-8 py-5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
              Status</th>
            <?php if (in_array('updateBrand', $user_permission) || in_array('deleteBrand', $user_permission)): ?>
              <th class="px-8 py-5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                Action</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200"></tbody>
      </table>
    </div>
  </div>

  <!-- Add Brand Modal -->
  <?php if (in_array('createBrand', $user_permission)): ?>
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
      <div
        class="bg-white rounded-2xl shadow-2xl border border-slate-200/60 w-full max-w-lg transform scale-95 opacity-0 transition-all duration-150">
        <div
          class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
          <h4 class="text-xl font-semibold text-slate-900">Add Brand</h4>
          <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors"
            onclick="hideModal('addModal')">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <form role="form" action="<?php echo base_url('brands/create') ?>" method="post" id="createForm">
          <div class="p-6">
            <div class="form-group mb-4">
              <label for="brand_name" class="text-sm font-medium text-slate-700">Brand Name</label>
              <input type="text"
                class="form-control border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full"
                id="brand_name" name="brand_name" placeholder="Enter brand name" autocomplete="off">
            </div>
            <div class="form-group mb-4">
              <label for="active" class="text-sm font-medium text-slate-700">Status</label>
              <select
                class="form-control border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full"
                id="active" name="active">
                <option value="1">Active</option>
                <option value="2">Inactive</option>
              </select>
            </div>
          </div>
          <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end space-x-2">
            <button type="button"
              class="px-4 py-2 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 transition-colors"
              onclick="hideModal('addModal')">Close</button>
            <button type="submit" id="createBrandBtn"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
              <span class="btn-text">Save changes</span>
              <span class="btn-loading hidden">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Saving...
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  <?php endif; ?>

  <!-- Edit Brand Modal -->
  <?php if (in_array('updateBrand', $user_permission)): ?>
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
      <div
        class="bg-white rounded-2xl shadow-2xl border border-slate-200/60 w-full max-w-lg transform scale-95 opacity-0 transition-all duration-150">
        <div
          class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
          <h4 class="text-xl font-semibold text-slate-900">Edit Brand</h4>
          <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors"
            onclick="hideModal('editModal')">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <form role="form" action="<?php echo base_url('brands/update') ?>" method="post" id="updateForm">
          <div class="p-6">
            <div id="editMessages"></div>
            <input type="hidden" id="edit_brand_id" name="brand_id">
            <div class="form-group mb-4">
              <label for="edit_brand_name" class="text-sm font-medium text-slate-700">Brand Name</label>
              <input type="text"
                class="form-control border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full"
                id="edit_brand_name" name="edit_brand_name" placeholder="Enter brand name"
                autocomplete="off">
            </div>
            <div class="form-group mb-4">
              <label for="edit_active" class="text-sm font-medium text-slate-700">Status</label>
              <select
                class="form-control border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full"
                id="edit_active" name="edit_active">
                <option value="1">Active</option>
                <option value="2">Inactive</option>
              </select>
            </div>
          </div>
          <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end space-x-2">
            <button type="button"
              class="px-4 py-2 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 transition-colors"
              onclick="hideModal('editModal')">Close</button>
            <button type="submit" id="updateBrandBtn"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
              <span class="btn-text">Save changes</span>
              <span class="btn-loading hidden">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Updating...
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  <?php endif; ?>

  <!-- Remove Brand Modal -->
  <?php if (in_array('deleteBrand', $user_permission)): ?>
    <div id="removeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
      <div
        class="bg-white rounded-2xl shadow-2xl border border-slate-200/60 w-full max-w-lg transform scale-95 opacity-0 transition-all duration-150">
        <div
          class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
          <h4 class="text-xl font-semibold text-slate-900">Remove Brand</h4>
          <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors"
            onclick="hideModal('removeModal')">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <form action="<?php echo base_url('brands/remove') ?>" method="post" id="removeForm">
          <div class="p-6">
            <input type="hidden" id="remove_brand_id" name="brand_id">
            <p class="text-slate-700">Do you really want to remove this brand?</p>
            <p class="text-sm text-slate-500 mt-2">All products under this brand will be affected.</p>
          </div>
          <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end space-x-2">
            <button type="button"
              class="px-4 py-2 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 transition-colors"
              onclick="hideModal('removeModal')">Close</button>
            <button type="submit" id="deleteBrandBtn"
              class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
              <span class="btn-text">Remove</span>
              <span class="btn-loading hidden">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Removing...
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  <?php endif; ?>
</div>

<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  // Modal show/hide functions
  function showModal(modalId) {
    $('#' + modalId).removeClass('hidden').find('.transform').css({
      'transform': 'scale(0.95)',
      'opacity': '0'
    }).animate({
      'transform': 'scale(1)',
      'opacity': '1'
    }, 50);
  }

  function hideModal(modalId) {
    $('#' + modalId).find('.transform').animate({
      'transform': 'scale(0.95)',
      'opacity': '0'
    }, 50, function() {
      $('#' + modalId).addClass('hidden');
    });
  }

  $(document).ready(function() {
    $("#brandNav").addClass('active');

    // Initialize the datatable
    manageTable = $('#manageTable').DataTable({
      ajax: {
        url: base_url + 'brands/fetchBrandData',
        dataSrc: 'data'
      },
      order: [],
      responsive: true,
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      columnDefs: [{
          targets: 0,
          render: function(data, type, row) {
            return `
        <div class="flex items-center">
          <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
            <i class="fas fa-tag text-blue-600"></i>
          </div>
          <div class="ml-4">
            <div class="text-sm font-semibold text-slate-900">${data}</div>
          </div>
        </div>
      `;
          }
        },
        {
          targets: -1,
          render: function(data, type, row) {
            let id = row[3];
            let actions = '';

            <?php if (in_array('updateBrand', $user_permission)): ?>
              actions += `
          <button onclick="editFunc(${id})"
            class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200">
            <i class="fas fa-pencil text-sm"></i>
          </button>
        `;
            <?php endif; ?>

            <?php if (in_array('deleteBrand', $user_permission)): ?>
              actions += `
          <button onclick="removeFunc(${id})"
            class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200">
            <i class="fas fa-trash text-sm"></i>
          </button>
        `;
            <?php endif; ?>

            return `<div class="flex items-center space-x-2">${actions}</div>`;
          }
        }
      ],

      dom: '<"flex md:flex-row md:items-center justify-between p-4"<"mb-4 md:mb-0"l><"flex items-center"f>>rt<"flex flex-row md:items-center justify-between p-4"<"mb-4 md:mb-0"i><"flex items-center"p>>',
      language: {
        search: '',
        searchPlaceholder: 'Search brands...',
        lengthMenu: 'Show _MENU_ brands',
        info: 'Showing _START_ to _END_ of _TOTAL_ brands',
        paginate: {
          first: '<i class="fas fa-angle-double-left"></i>',
          previous: '<i class="fas fa-angle-left"></i>',
          next: '<i class="fas fa-angle-right"></i>',
          last: '<i class="fas fa-angle-double-right"></i>'
        }
      },
      initComplete: function(settings, json) {
        padding();
        $('#totalBrands').text(json.data.length); // Update total brands count
        stylePagination();
        styleSearchInput();
        styleLengthMenu();
      },
      drawCallback: function() {
        stylePagination();
        padding();
      }
    });

    function padding() {
      $('th').addClass('px-4 py-3'); // Header cells
      $('td').addClass('px-4 py-3'); // Data cells
    }

    function styleSearchInput() {
      $('.dataTables_filter input').addClass(
        'border border-slate-200 rounded-md px-3 ml-1 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
      );
    }

    function stylePagination() {
      $('.dataTables_paginate').addClass('flex items-center space-x-2 mt-4');
      $('.dataTables_paginate .paginate_button').each(function() {
        $(this)
          .addClass(
            'px-3 py-1 mx-1 rounded-md border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-colors duration-200 inline-flex items-center justify-center'
          )
          .removeClass('current disabled');
      });
      $('.dataTables_paginate .paginate_button.current').addClass(
        'bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700'
      );
      $('.dataTables_paginate .paginate_button.disabled').addClass(
        'opacity-50 cursor-not-allowed hover:bg-white'
      );
    }

    function styleLengthMenu() {
      $('.dataTables_length select').addClass(
        'border border-slate-200 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
      );
    }

    // Submit the create form
    $("#createForm").unbind('submit').on('submit', function() {
      var form = $(this);
      $(".text-danger").remove();

      const createBtn = $('#createBrandBtn');
      const btnText = createBtn.find('.btn-text');
      const btnLoading = createBtn.find('.btn-loading');

      btnText.addClass('hidden');
      btnLoading.removeClass('hidden');
      createBtn.prop('disabled', true);

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          createBtn.prop('disabled', false);

          manageTable.ajax.reload(function(json) {
            $('#totalBrands').text(json.data.length);
          }, false);

          if (response.success === true) {
            $("#messages").html(
              '<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
              '<div class="flex items-center">' +
              '<i class="fas fa-check-circle text-emerald-500 mr-3"></i>' +
              '<span class="font-medium">' + response.messages + '</span>' +
              '</div>' +
              '<button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
              '<i class="fas fa-times"></i>' +
              '</button>' +
              '</div>');
            hideModal('addModal');
            $("#createForm")[0].reset();
            $("#createForm .form-group").removeClass('has-error').removeClass(
              'has-success');
          } else {
            if (response.messages instanceof Object) {
              $.each(response.messages, function(index, value) {
                var id = $("#" + index);
                id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' :
                    'has-success');
                id.after(value);
              });
            } else {
              $("#messages").html(
                '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                '<div class="flex items-center">' +
                '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                '<span class="font-medium">' + response.messages +
                '</span>' +
                '</div>' +
                '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                '<i class="fas fa-times"></i>' +
                '</button>' +
                '</div>');
            }
          }
        },
        error: function() {
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          createBtn.prop('disabled', false);

          $("#messages").html(
            '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
            '<div class="flex items-center">' +
            '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
            '<span class="font-medium">An error occurred while creating the brand</span>' +
            '</div>' +
            '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
            '<i class="fas fa-times"></i>' +
            '</button>' +
            '</div>');
        }
      });
      return false;
    });

  });


  // Edit function
  function editFunc(id) {
    showModal('editModal');
    $.ajax({
      url: base_url + 'brands/fetchBrandDataById/' + id,
      type: 'post',
      dataType: 'json',
      success: function(response) {
        if (response && response.name && response.active) {
          $("#edit_brand_id").val(id); // Set hidden input with brand ID
          $("#edit_brand_name").val(response.name);
          $("#edit_active").val(response.active);
        } else {
          $("#messages").html(
            '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
            '<div class="flex items-center">' +
            '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
            '<span class="font-medium">Failed to fetch brand data</span>' +
            '</div>' +
            '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
            '<i class="fas fa-times"></i>' +
            '</button>' +
            '</div>');
        }
      },
      error: function() {
        $("#messages").html(
          '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
          '<div class="flex items-center">' +
          '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
          '<span class="font-medium">Failed to fetch brand data</span>' +
          '</div>' +
          '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
          '<i class="fas fa-times"></i>' +
          '</button>' +
          '</div>');
      }
    });

    $("#updateForm").unbind('submit').bind('submit', function() {
      var form = $(this);
      $(".text-danger").remove();

      const updateBtn = $('#updateBrandBtn');
      const btnText = updateBtn.find('.btn-text');
      const btnLoading = updateBtn.find('.btn-loading');

      btnText.addClass('hidden');
      btnLoading.removeClass('hidden');
      updateBtn.prop('disabled', true);

      $.ajax({
        url: form.attr('action') + '/' + id,
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          updateBtn.prop('disabled', false);

          manageTable.ajax.reload(function(json) {
            $('#totalBrands').text(json.data.length);
          }, false);

          if (response.success === true) {
            $("#messages").html(
              '<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
              '<div class="flex items-center">' +
              '<i class="fas fa-check-circle text-emerald-500 mr-3"></i>' +
              '<span class="font-medium">' + response.messages +
              '</span>' +
              '</div>' +
              '<button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
              '<i class="fas fa-times"></i>' +
              '</button>' +
              '</div>');
            hideModal('editModal');
            $("#updateForm .form-group").removeClass('has-error').removeClass(
              'has-success');
          } else {
            if (response.messages instanceof Object) {
              $.each(response.messages, function(index, value) {
                var id = $("#" + index);
                id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' :
                    'has-success');
                id.after(value);
              });
            } else {
              $("#editMessages").html(
                '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                '<div class="flex items-center">' +
                '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                '<span class="font-medium">' + response.messages +
                '</span>' +
                '</div>' +
                '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                '<i class="fas fa-times"></i>' +
                '</button>' +
                '</div>');
            }
          }
        },
        error: function() {
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          updateBtn.prop('disabled', false);

          $("#editMessages").html(
            '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
            '<div class="flex items-center">' +
            '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
            '<span class="font-medium">An error occurred while updating the brand</span>' +
            '</div>' +
            '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
            '<i class="fas fa-times"></i>' +
            '</button>' +
            '</div>');
        }
      });
      return false;
    });
  }

  // Remove function
  function removeFunc(id) {
    $("#remove_brand_id").val(id); // Set hidden input with brand ID
    showModal('removeModal'); // Show remove modal immediately

    $("#removeForm").unbind('submit').bind('submit', function() {
      var form = $(this);
      $(".text-danger").remove();

      const deleteBtn = $('#deleteBrandBtn');
      const btnText = deleteBtn.find('.btn-text');
      const btnLoading = deleteBtn.find('.btn-loading');

      btnText.addClass('hidden');
      btnLoading.removeClass('hidden');
      deleteBtn.prop('disabled', true);

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          deleteBtn.prop('disabled', false);

          manageTable.ajax.reload(function(json) {
            $('#totalBrands').text(json.data.length);
          }, false);

          if (response.success === true) {
            $("#messages").html(
              '<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
              '<div class="flex items-center">' +
              '<i class="fas fa-check-circle text-emerald-500 mr-3"></i>' +
              '<span class="font-medium">' + response.messages +
              '</span>' +
              '</div>' +
              '<button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
              '<i class="fas fa-times"></i>' +
              '</button>' +
              '</div>');
            hideModal('removeModal');
          } else {
            $("#messages").html(
              '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
              '<div class="flex items-center">' +
              '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
              '<span class="font-medium">' + response.messages +
              '</span>' +
              '</div>' +
              '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
              '<i class="fas fa-times"></i>' +
              '</button>' +
              '</div>');
            hideModal('removeModal');
          }
        },
        error: function() {
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          deleteBtn.prop('disabled', false);

          $("#messages").html(
            '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
            '<div class="flex items-center">' +
            '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
            '<span class="font-medium">An error occurred while removing the brand</span>' +
            '</div>' +
            '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
            '<i class="fas fa-times"></i>' +
            '</button>' +
            '</div>');
          hideModal('removeModal');
        }
      });
      return false;
    });
  }
</script>