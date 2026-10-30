<!-- Modern Tailwind Groups Management UI -->
<div class="w-full max-w-none p-4 sm:p-6 lg:p-8">
  <!-- Content Header -->
  <div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manage Groups</h1>
        <p class="text-slate-600 mt-1">User group and permission management</p>
      </div>
      <nav class="flex items-center space-x-2 text-sm text-slate-500">
        <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
          <i class="fas fa-home mr-1"></i>
          Home
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-slate-900 font-medium">Groups</span>
      </nav>
    </div>
  </div>

  <!-- Flash Messages -->
  <div id="messages" class="mb-8">

  </div>

  <!-- Action Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div class="flex items-center space-x-4">
      <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-slate-200">
        <span class="text-sm text-slate-600">Total Groups: </span>
        <span class="font-semibold text-slate-900" id="totalGroups"><?php echo count($groups_data); ?></span>
      </div>
    </div>

    <?php if (in_array('createGroup', $user_permission)): ?>
      <a href="<?php echo base_url('groups/create') ?>"
        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
        <i class="fas fa-plus mr-2"></i>
        Add Group
      </a>
    <?php endif; ?>
  </div>

  <!-- Groups Table -->
  <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden w-full">
    <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-5 border-b border-slate-200">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <div class="bg-blue-600 p-2 rounded-lg mr-3">
            <i class="fas fa-users text-white"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-slate-900">Manage Groups</h3>
            <p class="text-slate-600 text-sm">User groups and permissions management</p>
          </div>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto w-full">
      <table id="groupTable" class="w-full min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
              Group Name</th>
            <?php if (in_array('updateGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                Action</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200">
          <?php if ($groups_data): ?>
            <?php foreach ($groups_data as $k => $v): ?>
              <tr class="hover:bg-slate-50 transition-colors duration-200">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div
                      class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                      <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-semibold text-slate-900"><?php echo $v['group_name']; ?>
                      </div>
                    </div>
                  </div>
                </td>

                <?php if (in_array('updateGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-2">
                      <?php if (in_array('updateGroup', $user_permission)): ?>
                        <a href="<?php echo base_url('groups/edit/' . $v['id']) ?>"
                          class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200">
                          <i class="fas fa-pencil text-sm"></i>
                        </a>
                      <?php endif; ?>
                      <?php if (in_array('deleteGroup', $user_permission)): ?>
                        <!-- Replaced direct link with button that opens modal -->
                        <button
                          onclick="openDeleteModal(<?php echo $v['id']; ?>, '<?php echo addslashes($v['group_name']); ?>')"
                          class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200">
                          <i class="fas fa-trash text-sm"></i>
                        </button>
                      <?php endif; ?>
                    </div>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Enhanced Delete Confirmation Modal -->
  <div id="removeModal" class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-50">
    <div
      class="bg-white rounded-3xl shadow-2xl border border-slate-100/50 w-full max-w-md transform scale-95 opacity-0 transition-all duration-300">
      <div
        class="bg-gradient-to-r from-red-50 to-rose-50 px-8 py-5 border-b border-slate-100 flex items-center justify-between">
        <div class="flex items-center">
          <!-- Added icon and improved header design to match delete.php -->
          <div class="bg-red-600 p-2 rounded-lg mr-3">
            <i class="fas fa-users-slash text-white"></i>
          </div>
          <div>
            <h4 class="text-xl font-semibold text-slate-900">Confirm Group Deletion</h4>
            <p class="text-slate-600 text-sm">This action cannot be undone</p>
          </div>
        </div>
        <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors"
          onclick="hideModal('removeModal')">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      <form id="removeForm" action="<?php echo base_url('groups/delete') ?>" method="post">
        <div class="p-8">
          <div class="text-center mb-6">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
              <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-3">Are you sure you want to delete this group?
            </h3>
            <p class="text-slate-500 text-base mb-2">Group: <span id="groupNameDisplay"
                class="font-semibold text-slate-700"></span></p>
            <p class="text-slate-500 text-base">This action is permanent and cannot be undone. All users in
              this group may lose their permissions.</p>
          </div>
          <input type="hidden" name="group_id" id="group_id_to_remove">
        </div>
        <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3">
          <!-- Enhanced button styling to match delete.php design -->
          <button type="button"
            class="inline-flex items-center px-6 py-3 border border-slate-300 text-sm font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm"
            onclick="hideModal('removeModal')">
            Cancel
          </button>
          <button type="submit" name="confirm" id="deleteGroupBtn"
            class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-sm">
            <span class="btn-text">
              <i class="fas fa-trash-alt mr-2"></i>
              Confirm Delete
            </span>
            <span class="btn-loading hidden">
              <i class="fas fa-spinner fa-spin mr-2"></i>
              Deleting...
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

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

  function openDeleteModal(id, groupName) {
    $('#group_id_to_remove').val(id);
    $('#groupNameDisplay').text(groupName);
    showModal('removeModal');
  }

  $(document).ready(function() {
    var groupTable = $('#groupTable').DataTable({
      responsive: true,
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      order: [
        [0, 'asc']
      ],
      columnDefs: [{
        orderable: false,
        targets: -1
      }],
      dom: '<"flex md:flex-row md:items-center justify-between p-4"<"mb-4 md:mb-0"l><"flex items-center"f>>rt<"flex flex-row md:items-center justify-between p-4"<"mb-4 md:mb-0"i><"flex items-center"p>>',
      language: {
        search: '',
        searchPlaceholder: 'Search groups...',
        lengthMenu: 'Show _MENU_ groups',
        info: 'Showing _START_ to _END_ of _TOTAL_ groups',
        paginate: {
          first: '<i class="fas fa-angle-double-left"></i>',
          previous: '<i class="fas fa-angle-left"></i>',
          next: '<i class="fas fa-angle-right"></i>',
          last: '<i class="fas fa-angle-double-right"></i>'
        }
      },
      initComplete: function() {
        stylePagination();
        styleSearchInput();
        styleLengthMenu();
      },
      drawCallback: function() {
        stylePagination();
      }
    });

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

    $("#mainGroupNav").addClass('active');
    $("#manageGroupNav").addClass('active');

    $(document).on('submit', '#removeForm', function(e) {
      var form = $(this);
      e.preventDefault();

      const deleteBtn = $('#deleteGroupBtn');
      const btnText = deleteBtn.find('.btn-text');
      const btnLoading = deleteBtn.find('.btn-loading');

      // Show loading state
      btnText.addClass('hidden');
      btnLoading.removeClass('hidden');
      deleteBtn.prop('disabled', true);

      const groupId = $('#group_id_to_remove').val();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: {
          group_id: groupId
        },
        dataType: 'json',
        success: function(response) {

          console.log(response);
          // Reset button state
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          deleteBtn.prop('disabled', false);

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

            // Reload the page to refresh group list
            setTimeout(function() {
              window.location.reload();
            }, 10);

            hideModal('removeModal');
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
          // Reset button state
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          deleteBtn.prop('disabled', false);

          $('#messages').html(`
            <div class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl flex items-center justify-between shadow-sm">
              <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span class="font-medium">An error occurred while deleting the group</span>
              </div>
              <button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
              </button>
            </div>
          `);
        }
      });
    });

    // Close modal when clicking outside
    $(document).on('click', '#removeModal', function(e) {
      if (e.target === this) {
        hideModal('removeModal');
      }
    });
  });
</script>