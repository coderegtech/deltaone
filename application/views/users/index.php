<div class="w-full max-w-none p-6 sm:p-8 lg:p-10 bg-gradient-to-b from-slate-50 to-white min-h-screen">
    <!-- Content Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manage Users</h1>
                <p class="text-slate-600 mt-1">Oversee user accounts and permissions across your system</p>
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

    <!-- Flash Messages -->
    <div id="messages" class="mb-8"></div>

    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div class="flex items-center space-x-4">
            <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-slate-100">
                <span class="text-sm text-slate-600">Total Users: </span>
                <span class="font-semibold text-slate-900" id="totalUsers"><?php echo count($user_data); ?></span>
            </div>
        </div>

        <?php if (in_array('createUser', $user_permission)): ?>
            <a href="<?php echo base_url('users/create') ?>"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-sm hover:shadow-md">
                <i class="fas fa-user-plus mr-2"></i>
                Add User
            </a>
        <?php endif; ?>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5 border-b border-slate-100">
            <div class="flex items-center">
                <div class="bg-blue-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-users text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-semibold text-slate-900">User Accounts</h3>
                    <p class="text-slate-500 text-base mt-1">Manage user accounts and permissions</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table id="userTable" class="w-full min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Username</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Name</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Phone</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Group</th>
                            <?php if (in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                    Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <?php if ($user_data): ?>
                            <?php foreach ($user_data as $k => $v): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-semibold text-slate-900">
                                                <?php echo $v['user_info']['username']; ?></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-envelope text-slate-400 mr-2"></i>
                                            <span class="text-sm text-slate-900"><?php echo $v['user_info']['email']; ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm font-medium text-slate-900">
                                            <?php echo $v['user_info']['firstname'] . ' ' . $v['user_info']['lastname']; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-slate-400 mr-2"></i>
                                            <span class="text-sm text-slate-900"><?php echo $v['user_info']['phone']; ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        <?php
                                        switch (strtolower($v['user_group']['group_name'])) {
                                            case 'admin':
                                                echo 'bg-red-100 text-red-800';
                                                break;
                                            case 'editors':
                                                echo 'bg-blue-100 text-blue-800';
                                                break;
                                            default:
                                                echo 'bg-gray-100 text-gray-800';
                                                break;
                                        }
                                        ?>">
                                            <i class="fas fa-user-tag mr-1"></i>
                                            <?php echo $v['user_group']['group_name']; ?>
                                        </span>
                                    </td>
                                    <?php if (in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <?php if (in_array('updateUser', $user_permission)): ?>

                                                    <a href="<?php echo base_url('users/edit/' . $v['user_info']['id']) ?>"
                                                        class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200">
                                                        <i class="fas fa-pencil text-sm"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (in_array('deleteUser', $user_permission)): ?>
                                                    <button onclick="openDeleteModal(<?php echo $v['user_info']['id']; ?>)"
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
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="removeModal" class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-50">
        <div
            class="bg-white rounded-3xl shadow-2xl border border-slate-100/50 w-full max-w-md transform scale-95 opacity-0 transition-all duration-300">
            <div
                class="bg-gradient-to-r from-red-50 to-rose-50 px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <h4 class="text-xl font-semibold text-slate-900">Delete User</h4>
                <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors"
                    onclick="hideModal('removeModal')">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form id="removeForm" action="<?php echo base_url('users/delete') ?>" method="post">
                <div class="p-8">
                    <div class="text-center mb-6">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900 mb-3">Are you sure you want to delete this user?
                        </h3>
                        <p class="text-slate-500 text-base">This action is permanent and cannot be undone. All
                            associated
                            data will be lost.</p>
                    </div>
                    <input type="hidden" name="user_id" id="user_id_to_remove">
                </div>
                <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3">
                    <button type="button"
                        class="px-5 py-2.5 bg-slate-200 text-slate-700 rounded-xl hover:bg-slate-300 transition-colors font-medium"
                        onclick="hideModal('removeModal')">Cancel</button>
                    <button type="submit" id="deleteUserBtn"
                        class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors font-medium">
                        <span class="btn-text">Delete User</span>
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

    // Modal show/hide functions
    function showModal(modalId) {
        const modal = $('#' + modalId);
        const modalContent = modal.find('.transform');

        modal.removeClass('hidden');
        setTimeout(() => {
            modalContent.removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
        }, 10);
    }

    function hideModal(modalId) {
        const modal = $('#' + modalId);
        const modalContent = modal.find('.transform');

        modalContent.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
        setTimeout(() => {
            modal.addClass('hidden');
        }, 300);
    }

    $(document).ready(function() {
        var userTable = $('#userTable').DataTable({
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
            dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"<"flex items-center"l><"flex items-center"f>>rt<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-6"<"flex items-center"i><"flex items-center"p>>',
            language: {
                search: '',
                searchPlaceholder: 'Search users...',
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
                'border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
            );
        }

        function stylePagination() {
            $('.dataTables_paginate').addClass('flex items-center space-x-1');
            $('.dataTables_paginate .paginate_button').each(function() {
                $(this)
                    .addClass(
                        'px-3 py-1 mx-1 rounded-lg border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 transition-colors duration-200 inline-flex items-center justify-center'
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
                'border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
            );
        }

    });

    function openDeleteModal(id) {
        $('#user_id_to_remove').val(id);
        showModal('removeModal');
    }

    $(document).on('submit', '#removeForm', function(e) {
        e.preventDefault();

        const deleteBtn = $('#deleteUserBtn');
        const btnText = deleteBtn.find('.btn-text');
        const btnLoading = deleteBtn.find('.btn-loading');

        btnText.addClass('hidden');
        btnLoading.removeClass('hidden');
        deleteBtn.prop('disabled', true);

        const userId = $('#user_id_to_remove').val();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: {
                user_id: userId
            },
            dataType: 'json',
            success: function(response) {
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
                btnText.removeClass('hidden');
                btnLoading.addClass('hidden');
                deleteBtn.prop('disabled', false);

                $('#messages').html(`
                    <div class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl flex items-center justify-between shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <span class="font-medium">An error occurred while deleting the user</span>
                        </div>
                        <button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);
            }
        });
    });

    $(document).on('click', '#removeModal', function(e) {
        if (e.target === this) {
            hideModal('removeModal');
        }
    });
</script>