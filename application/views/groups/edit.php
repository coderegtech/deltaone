<!-- Replaced AdminLTE content wrapper with modern Tailwind layout -->
<div class="min-h-screen bg-gray-50">
        <div class="p-6">
                <!-- Content Header -->
                <div class="mb-8">
                        <div class="flex items-center justify-between">
                                <div>
                                        <h1 class="text-3xl font-bold text-gray-900">Edit Group</h1>
                                        <p class="text-gray-600 mt-1">Update group name and permissions</p>
                                </div>
                                <nav class="flex items-center space-x-2 text-sm text-gray-500">
                                        <a href="<?php echo base_url('dashboard') ?>"
                                                class="flex items-center hover:text-blue-600 transition-colors">
                                                <i class="fas fa-home mr-1"></i>
                                                Home
                                        </a>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                        <a href="<?php echo base_url('groups/') ?>" class="hover:text-blue-600 transition-colors">Groups</a>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                        <span class="text-gray-900">Edit</span>
                                </nav>
                        </div>
                </div>

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('success')): ?>
                        <div
                                class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                                <span><?php echo $this->session->flashdata('success'); ?></span>
                                <button type="button" class="text-green-500 hover:text-green-700"
                                        onclick="this.parentElement.style.display='none'">
                                        <i class="fas fa-times"></i>
                                </button>
                        </div>
                <?php elseif ($this->session->flashdata('error')): ?>
                        <div
                                class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                                <span><?php echo $this->session->flashdata('error'); ?></span>
                                <button type="button" class="text-red-500 hover:text-red-700"
                                        onclick="this.parentElement.style.display='none'">
                                        <i class="fas fa-times"></i>
                                </button>
                        </div>
                <?php endif; ?>

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
                        <!-- Permissions -->
                        <div class="space-y-4">

                                <?php $serialize_permission = unserialize($group_data['permission']); ?>


                                <form role="form" action="<?php echo base_url('groups/edit/' . $group_data['id']); ?>" method="post">
                                        <div class="p-6 space-y-6">

                                                <?php if (validation_errors()): ?>
                                                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                                                                <?php echo validation_errors(); ?>
                                                        </div>
                                                <?php endif; ?>

                                                <!-- Group Name -->
                                                <div class="space-y-2">
                                                        <label for="group_name" class="block text-sm font-medium text-gray-700">Group
                                                                Name</label>
                                                        <input type="text"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                                id="group_name" name="group_name" placeholder="Enter group name"
                                                                value="<?php echo $group_data['group_name']; ?>">
                                                </div>

                                                <!-- Permissions -->
                                                <div class="space-y-4">
                                                        <label class="block text-sm font-medium text-gray-700">Permissions</label>

                                                        <?php $serialize_permission = unserialize($group_data['permission']); ?>

                                                        <div class="bg-gray-50 rounded-lg p-4 overflow-x-auto">
                                                                <table class="w-full min-w-full">
                                                                        <thead>
                                                                                <tr class="border-b border-gray-200">
                                                                                        <th class="text-left py-3 px-4 font-medium text-gray-900">Module
                                                                                        </th>
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Create
                                                                                        </th>
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Update
                                                                                        </th>
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">View
                                                                                        </th>
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Delete
                                                                                        </th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody class="divide-y divide-gray-200">
                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Users</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="createUser"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('createUser', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateUser"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateUser', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewUser"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewUser', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="deleteUser"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('deleteUser', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                </tr>

                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Work Order</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="createWorkOrder"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('createWorkOrder', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateWorkOrder"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateWorkOrder', $serialize_permission)) echo "checked"; ?>>

                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewWorkOrder"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewWorkOrder', $serialize_permission)) echo "checked"; ?>>

                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="deleteWorkOrder"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('deleteWorkOrder', $serialize_permission)) echo "checked"; ?>>

                                                                                        </td>
                                                                                </tr>


                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Groups</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="createGroup"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('createGroup', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateGroup"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateGroup', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewGroup"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewGroup', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="deleteGroup"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('deleteGroup', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                </tr>
                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Brands</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="createBrand"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('createBrand', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateBrand"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateBrand', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewBrand"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewBrand', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="deleteBrand"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('deleteBrand', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                </tr>
                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Category</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="createCategory"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('createCategory', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateCategory"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateCategory', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewCategory"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewCategory', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="deleteCategory"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('deleteCategory', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                </tr>
                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Rack Location</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="createStore"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('createStore', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateStore"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateStore', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewStore"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewStore', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="deleteStore"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('deleteStore', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                </tr>
                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Attributes</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="createAttribute"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('createAttribute', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateAttribute"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateAttribute', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewAttribute"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewAttribute', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="deleteAttribute"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('deleteAttribute', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                </tr>
                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Inventory</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="createProduct"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('createProduct', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateProduct"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateProduct', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewProduct"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewProduct', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="deleteProduct"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('deleteProduct', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                </tr>
                                                                                <!-- <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Orders</td>
                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                value="createOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                <?php if ($serialize_permission && in_array('createOrder', $serialize_permission)) echo "checked"; ?>>
                                        </td>
                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                value="updateOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                <?php if ($serialize_permission && in_array('updateOrder', $serialize_permission)) echo "checked"; ?>>
                                        </td>
                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                value="viewOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                <?php if ($serialize_permission && in_array('viewOrder', $serialize_permission)) echo "checked"; ?>>
                                        </td>
                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                value="deleteOrder"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                <?php if ($serialize_permission && in_array('deleteOrder', $serialize_permission)) echo "checked"; ?>>
                                        </td>
                                    </tr> -->
                                                                                <!-- <tr class="hover:bg-white">
                                        <td class="py-3 px-4 font-medium text-gray-900">Reports</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                value="viewReports"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                <?php if ($serialize_permission && in_array('viewReports', $serialize_permission)) echo "checked"; ?>>
                                        </td>
                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                    </tr> -->
                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Company</td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateCompany"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateCompany', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                </tr>

                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Activity Log</td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewActivityLog"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewActivityLog', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                </tr>

                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Profile</td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="viewProfile"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('viewProfile', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                </tr>
                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 font-medium text-gray-900">Setting</td>
                                                                                        <td class="py-3 px-4 text-center text-gray-400">-</td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="updateSetting"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('updateSetting', $serialize_permission)) echo "checked"; ?>>
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
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">
                                                                                                Requester</th>
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Checker
                                                                                        </th>
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Endorser
                                                                                        </th>
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Receiver
                                                                                        </th>
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Supervisor</th>
                                                                                        <th class="text-center py-3 px-4 font-medium text-gray-900">Approver
                                                                                        </th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody class="divide-y divide-gray-200">
                                                                                <tr class="hover:bg-white">
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="requester"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('requester', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="checker"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('checker', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="endorser"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('endorser', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="receiver"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('receiver', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="supervisor"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('supervisor', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                        <td class="py-3 px-4 text-center"><input type="checkbox" name="permission[]"
                                                                                                        value="approver"
                                                                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                                                        <?php if ($serialize_permission && in_array('approver', $serialize_permission)) echo "checked"; ?>>
                                                                                        </td>
                                                                                </tr>
                                                                        </tbody>
                                                                </table>
                                                        </div>
                                                </div>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3 rounded-b-xl">
                                                <a href="<?php echo base_url('groups/') ?>"
                                                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                        Back
                                                </a>
                                                <button type="submit"
                                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                                        Update Group
                                                </button>
                                        </div>
                                </form>
                        </div>
                </div>

                <script type="text/javascript">
                        $(document).ready(function() {
                                $("#mainGroupNav").addClass('active');
                                $("#manageGroupNav").addClass('active');

                                // Add select all functionality for each column
                                $('th input[type="checkbox"]').on('change', function() {
                                        var column = $(this).closest('th').index();
                                        var checked = $(this).prop('checked');
                                        $('tbody tr').each(function() {
                                                $(this).find('td').eq(column).find('input[type="checkbox"]').prop(
                                                        'checked',
                                                        checked);
                                        });
                                });
                        });
                </script>