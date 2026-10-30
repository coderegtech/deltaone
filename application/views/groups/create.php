<!-- Replaced AdminLTE content wrapper with modern Tailwind layout -->
<div class="min-h-screen bg-gray-50">
    <div class="p-6">
        <!-- Content Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Add Group</h1>
                    <p class="text-gray-600 mt-1">Create a new user group with permissions</p>
                </div>
                <nav class="flex items-center space-x-2 text-sm text-gray-500">
                    <a href="#" class="flex items-center hover:text-blue-600 transition-colors">
                        <i class="fas fa-home mr-1"></i>
                        Home
                    </a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-900">Groups</span>
                </nav>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                <span><?php echo $this->session->flashdata('success'); ?></span>
                <button type="button" class="alert alert-success alert-dismissible text-green-500 hover:text-green-700"
                    onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div
                class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                <span><?php echo $this->session->flashdata('error'); ?></span>
                <button type="button" class="alert alert-error alert-dismissible text-red-500 hover:text-red-700"
                    data-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Group Form -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                <div class="flex items-center">
                    <!-- <div class="bg-white/20 p-2 rounded-lg mr-3">
            <i class="fas fa-user-plus text-white text-lg"></i>
          </div> -->
                    <div>
                        <h3 class="text-xl font-semibold text-white">Group Information</h3>
                    </div>
                </div>
            </div>

            <form role="form" action="<?php echo base_url('groups/create'); ?>" method="post">
                <div class="p-6 space-y-6">

                    <?php if (validation_errors()): ?>
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Group Name -->
                    <div class="space-y-2">
                        <label for="group_name" class="block text-sm font-medium text-gray-700">Group Name</label>
                        <input type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            id="group_name" name="group_name" placeholder="Enter group name">
                    </div>

                    <!-- Permissions -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700">Permissions</label>

                        <div class="bg-gray-50 rounded-lg p-4 overflow-x-auto">
                            <table class="w-full min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left py-3 px-4 font-medium text-gray-900">Module</th>
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Create</th>
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Update</th>
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">View</th>
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Users</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="createUser"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateUser"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewUser"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="deleteUser"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr>

                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Work Request</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox" name="permission[]"
                                                value="createWorkOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateWorkOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewWorkOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="deleteWorkOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr>

                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Groups</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="createGroup"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateGroup"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewGroup"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="deleteGroup"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Brands</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="createBrand"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateBrand"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewBrand"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="deleteBrand"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Category</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="createCategory"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateCategory"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewCategory"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="deleteCategory"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Rack Location</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="createStore"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateStore"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewStore"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="deleteStore"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Attributes</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="createAttribute"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateAttribute"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewAttribute"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="deleteAttribute"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Inventory</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="createProduct"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateProduct"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>

                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewProduct"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="deleteProduct"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <!-- <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Orders</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox" name="permission[]"
                                                value="createOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox" name="permission[]"
                                                value="updateOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox" name="permission[]"
                                                value="viewOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox" name="permission[]"
                                                value="deleteOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr> -->
                                    <!-- <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Reports</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox" name="permission[]"
                                                value="viewReports"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                    </tr> -->
                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Company</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateCompany"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                    </tr>

                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Activity Log</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewActivityLog"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                    </tr>

                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Profile</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="viewProfile"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                    </tr>
                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Setting</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="updateSetting"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <label class="block text-sm font-medium text-gray-700">Work Request Permissions</label>

                        <div class="bg-gray-50 rounded-lg p-4 overflow-x-auto">
                            <table class="w-full min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Requester</th>
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Checker</th>
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Endorser</th>
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Receiver</th>
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Supervisor</th>
                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Approver</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr class="hover:bg-white">
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="requester"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="checker"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="endorser"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="receiver"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="supervisor"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="py-3 px-4 text-center clickable-td"><input type="checkbox"
                                                name="permission[]" value="approver"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div
                    class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col-reverse justify-center space-y-3 sm:flex-row sm:justify-end sm:space-x-3 rounded-b-xl">
                    <a href="<?php echo base_url('groups/') ?>"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Groups
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        Save Group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#mainGroupNav").addClass('active');
        $("#addGroupNav").addClass('active');

        // Add select all functionality for each column
        $('th input[type="checkbox"]').on('change', function() {
            var column = $(this).closest('th').index();
            var checked = $(this).prop('checked');
            $('tbody tr').each(function() {
                $(this).find('td').eq(column).find('input[type="checkbox"]').prop('checked',
                    checked);
            });
        });
        document.querySelectorAll('.clickable-td').forEach(td => {
            td.addEventListener('click', function(e) {
                // Prevent double toggling if the checkbox itself was clicked
                if (e.target.tagName.toLowerCase() === 'input') return;

                const checkbox = td.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    // Optional: trigger change event if needed
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });

    });
</script>