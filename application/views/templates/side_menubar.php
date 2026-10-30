<!-- Full Sidebar -->
<aside
    class="fixed left-0 top-0 bottom-0 w-64 bg-white shadow-xl border-r border-gray-100 sidebar-transition transform -translate-x-full lg:translate-x-0 z-30 overflow-hidden transition-all duration-300"
    id="sidebar-full">
    <div class="flex flex-col h-full">
        <!-- Brand header -->
        <a href="<?php echo base_url('') ?>"
            class="px-4 sm:px-6 py-4 border-b border-gray-100 flex-shrink-0 brand-header">
            <div class="flex items-center space-x-3">
                <div class="rounded-lg flex items-center justify-center flex-shrink-0">
                    <img src="<?php echo base_url('assets/images/deltaone.png'); ?>" alt="DeltaOne Logo"
                        class="h-10 w-10 object-contain brand-text">
                </div>
                <div class="min-w-0 brand-text">
                    <h1 class="text-lg font-bold text-gray-900 truncate">DeltaOne</h1>
                    <p class="text-xs text-gray-500 truncate">Asset Management System</p>
                </div>
            </div>
        </a>

        <!-- Sidebar content -->
        <nav
            class="flex-1 px-2 sm:px-4 py-4 sm:py-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <ul class="space-y-1">

                <li>
                    <a href="<?php echo base_url('dashboard') ?>"
                        class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                        id="dashboardMainMenu" data-page="dashboard">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                            <i class="fas fa-tachometer-alt text-gray-600 nav-icon text-sm sm:text-base"></i>
                        </div>
                        <span class="font-medium text-sm sm:text-base truncate nav-text">Dashboard</span>
                    </a>
                </li>

                <?php if ($user_permission): ?>

                    <?php if (in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                        <li class="menu-item" id="mainProductNav">
                            <button
                                class="flex items-center justify-between w-full px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 menu-toggle nav-item group"
                                data-page="products">
                                <div class="flex items-center min-w-0">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 icon-bg group-hover:bg-blue-200">
                                        <i class="fas fa-cube text-gray-600 nav-icon text-sm sm:text-base"></i>
                                    </div>
                                    <span class="font-medium text-sm sm:text-base truncate nav-text">Inventory</span>
                                </div>
                                <i
                                    class="fas fa-chevron-down w-4 h-4 transition-transform duration-200 text-gray-400 flex-shrink-0 nav-text chevron-icon"></i>
                            </button>
                            <ul class="ml-8 sm:ml-14 mt-2 space-y-1 hidden submenu">
                                <?php if (in_array('createProduct', $user_permission)): ?>
                                    <li id="addProductNav">
                                        <a href="<?php echo base_url('products/create') ?>"
                                            class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                            data-page="products/create">
                                            <i
                                                class="fas fa-plus w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                            <span class="truncate nav-text">Add Item</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                                    <li id="manageProductNav">
                                        <a href="<?php echo base_url('products') ?>"
                                            class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                            data-page="products">
                                            <i
                                                class="fas fa-cog w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                            <span class="truncate nav-text">Manage Item</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (in_array('viewProduct', $user_permission)): ?>
                                    <li id="lowStockNav">
                                        <a href="<?php echo base_url('lowindex') ?>"
                                            class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                            data-page="lowindex">
                                            <i
                                                class="fas fa-exclamation-triangle w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                            <span class="truncate nav-text">Low Stock</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createWorkOrder', $user_permission) || in_array('updateWorkOrder', $user_permission) || in_array('viewWorkOrder', $user_permission) || in_array('deleteWorkOrder', $user_permission)): ?>
                        <li class="menu-item" id="mainOrderNav">
                            <button
                                class="flex items-center justify-between w-full px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 menu-toggle nav-item group"
                                data-page="workorder">
                                <div class="flex items-center min-w-0">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 icon-bg group-hover:bg-blue-200">
                                        <span class="material-symbols-outlined text-gray-600 nav-icon text-2xl">
                                            order_play
                                        </span>
                                    </div>
                                    <span class="font-medium text-sm sm:text-base truncate nav-text">Work Order</span>
                                </div>
                                <i
                                    class="fas fa-chevron-down w-4 h-4 transition-transform duration-200 text-gray-400 flex-shrink-0 nav-text chevron-icon"></i>
                            </button>
                            <ul class="ml-8 sm:ml-14 mt-2 space-y-1 hidden submenu">
                                <?php if (in_array('createWorkOrder', $user_permission)): ?>
                                    <li id="addOrderNav">
                                        <a href="<?php echo base_url('work_order/create') ?>"
                                            class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                            data-page="Workorder/create">
                                            <i
                                                class="fas fa-plus w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                            <span class="truncate nav-text">Create Work Request</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (in_array('viewWorkOrder', $user_permission)): ?>
                                    <li id="manageOrderNav">
                                        <a href="<?php echo base_url('work_order') ?>"
                                            class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                            data-page="Workorder">
                                            <i
                                                class="fas fa-cog w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                            <span class="truncate nav-text">View Work Order</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createStore', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
                        <li id="storeNav">
                            <a href="<?php echo base_url('stores/') ?>"
                                class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="stores">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">

                                    <span
                                        class="material-symbols-outlined text-gray-600 group-hover:text-blue-700 text-xl nav-icon">
                                        shelves
                                    </span>

                                </div>
                                <span class="font-medium text-sm sm:text-base truncate nav-text">Rack Location</span>
                            </a>
                        </li>
                    <?php endif; ?>



                    <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                        <li class="menu-item" id="mainUserNav">
                            <button
                                class="flex items-center justify-between w-full px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 menu-toggle nav-item group"
                                data-page="users">
                                <div class="flex items-center min-w-0">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 icon-bg group-hover:bg-blue-200">
                                        <i class="fas fa-users text-gray-600 nav-icon text-sm sm:text-base"></i>
                                    </div>
                                    <span class="font-medium text-sm sm:text-base truncate nav-text">Users</span>
                                </div>
                                <i
                                    class="fas fa-chevron-down w-4 h-4 transition-transform duration-200 text-gray-400 flex-shrink-0 nav-text chevron-icon"></i>
                            </button>
                            <ul class="ml-8 sm:ml-14 mt-2 space-y-1 hidden submenu">
                                <?php if (in_array('createUser', $user_permission)): ?>
                                    <li id="createUserNav">
                                        <a href="<?php echo base_url('users/create') ?>"
                                            class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                            data-page="users/create">
                                            <i
                                                class="fas fa-plus w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                            <span class="truncate nav-text">Add User</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                                    <li id="manageUserNav">
                                        <a href="<?php echo base_url('users') ?>"
                                            class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                            data-page="users">
                                            <i
                                                class="fas fa-cog w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                            <span class="truncate nav-text">Manage Users</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                        <li class="menu-item" id="mainOrderNav">
                            <button
                                class="flex items-center justify-between w-full px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 menu-toggle nav-item group"
                                data-page="work_order">
                                <div class="flex items-center min-w-0">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 icon-bg group-hover:bg-blue-200">
                                        <i class="fas fa-truck text-gray-600 nav-icon text-sm sm:text-base"></i>
                                    </div>
                                    <span class="font-medium text-sm sm:text-base truncate nav-text">Work Order</span>
                                </div>
                                <i
                                    class="fas fa-chevron-down w-4 h-4 transition-transform duration-200 text-gray-400 flex-shrink-0 nav-text chevron-icon"></i>
                            </button>
                            <ul class="ml-8 sm:ml-14 mt-2 space-y-1 hidden submenu">
                                <li id="addOrderNav">
                                    <a href="<?php echo base_url('work_order/create') ?>"
                                        class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                        data-page="work_order/store">
                                        <i
                                            class="fas fa-plus w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                        <span class="truncate nav-text">Create Work Order</span>
                                    </a>
                                </li>
                                <li id="manageOrderNav">
                                    <a href="<?php echo base_url('work_order') ?>"
                                        class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                        data-page="work_order">
                                        <i
                                            class="fas fa-cog w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                        <span class="truncate nav-text">View Work Order</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                        <li class="menu-item" id="mainGroupNav">
                            <button
                                class="flex items-center justify-between w-full px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 menu-toggle nav-item group"
                                data-page="groups">
                                <div class="flex items-center min-w-0">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 icon-bg group-hover:bg-blue-200">
                                        <i class="fas fa-layer-group text-gray-600 nav-icon text-sm sm:text-base"></i>
                                    </div>
                                    <span class="font-medium text-sm sm:text-base truncate nav-text">Groups</span>
                                </div>
                                <i
                                    class="fas fa-chevron-down w-4 h-4 transition-transform duration-200 text-gray-400 flex-shrink-0 nav-text chevron-icon"></i>
                            </button>
                            <ul class="ml-8 sm:ml-14 mt-2 space-y-1 hidden submenu">
                                <?php if (in_array('createGroup', $user_permission)): ?>
                                    <li id="addGroupNav">
                                        <a href="<?php echo base_url('groups/create') ?>"
                                            class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                            data-page="groups/create">
                                            <i
                                                class="fas fa-plus w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                            <span class="truncate nav-text">Add Group</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                                    <li id="manageGroupNav">
                                        <a href="<?php echo base_url('groups') ?>"
                                            class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                            data-page="groups">
                                            <i
                                                class="fas fa-cog w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                            <span class="truncate nav-text">Manage Groups</span>
                                        </a>
                                    </li>
                                    <template id="manageGroupNav-template">
                                        <li id="manageGroupNav">
                                            <a href="<?php echo base_url('groups') ?>"
                                                class="flex items-center px-3 sm:px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 nav-item"
                                                data-page="groups">
                                                <i
                                                    class="fas fa-cog w-3 h-3 sm:w-4 sm:h-4 mr-3 text-gray-400 flex-shrink-0 nav-icon"></i>
                                                <span class="truncate nav-text">Manage Groups</span>
                                            </a>
                                        </li>
                                    </template>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>



                    <?php if (in_array('createBrand', $user_permission) || in_array('updateBrand', $user_permission) || in_array('viewBrand', $user_permission) || in_array('deleteBrand', $user_permission)): ?>
                        <li id="brandNav">
                            <a href="<?php echo base_url('brands/') ?>"
                                class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="brands">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-tags text-gray-600 nav-icon text-sm sm:text-base"></i>
                                </div>
                                <span class="font-medium text-sm sm:text-base truncate nav-text">Brands</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
                        <li id="categoryNav">
                            <a href="<?php echo base_url('category/') ?>"
                                class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="category">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-folder text-gray-600 nav-icon text-sm sm:text-base"></i>
                                </div>
                                <span class="font-medium text-sm sm:text-base truncate nav-text">Category</span>
                            </a>
                        </li>
                    <?php endif; ?>



                    <?php if (in_array('createAttribute', $user_permission) || in_array('updateAttribute', $user_permission) || in_array('viewAttribute', $user_permission) || in_array('deleteAttribute', $user_permission)): ?>
                        <li id="attributeNav">
                            <a href="<?php echo base_url('attributes/') ?>"
                                class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="attributes">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-list-ul text-gray-600 nav-icon text-sm sm:text-base"></i>
                                </div>
                                <span class="font-medium text-sm sm:text-base truncate nav-text">Attributes</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- <?php if (in_array('viewReports', $user_permission)): ?>
            <li id="reportNav">
              <a href="<?php echo base_url('reports/') ?>"
                class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                data-page="reports">
                <div
                  class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                  <i class="fas fa-chart-bar text-gray-600 nav-icon text-sm sm:text-base"></i>
                </div>
                <span class="font-medium text-sm sm:text-base truncate nav-text">Reports</span>
              </a>
            </li>
          <?php endif; ?> -->

                    <?php if (in_array('updateCompany', $user_permission)): ?>
                        <li id="companyNav">
                            <a href="<?php echo base_url('company/') ?>"
                                class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="company">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-building text-gray-600 nav-icon text-sm sm:text-base"></i>
                                </div>
                                <span class="font-medium text-sm sm:text-base truncate nav-text">Company</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Divider -->
                    <li class="my-4 sm:my-6">
                        <hr class="border-gray-200">
                    </li>

                    <!-- Activity Log -->
                    <?php if (in_array('viewActivityLog', $user_permission)): ?>
                        <li id="activityLogNav">
                            <a href="<?php echo base_url('activitylog') ?>"
                                class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="activitylog">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-history text-gray-600 nav-icon text-sm sm:text-base"></i>
                                </div>
                                <span class="font-medium text-sm sm:text-base truncate nav-text">Activity Log</span>
                            </a>
                        </li>
                    <?php endif; ?>


                    <?php if (in_array('viewProfile', $user_permission)): ?>
                        <li>
                            <a href="<?php echo base_url('users/profile/') ?>"
                                class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="users/profile">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-user text-gray-600 nav-icon text-sm sm:text-base"></i>
                                </div>
                                <span class="font-medium text-sm sm:text-base truncate nav-text">Profile</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('updateSetting', $user_permission)): ?>
                        <li>
                            <a href="<?php echo base_url('users/setting/') ?>"
                                class="flex items-center px-3 sm:px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="users/setting">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-cog text-gray-600 nav-icon text-sm sm:text-base"></i>
                                </div>
                                <span class="font-medium text-sm sm:text-base truncate nav-text">Settings</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Close the main $user_permission block -->

                <li class="mt-4 sm:mt-6">
                    <a href="<?php echo base_url('auth/logout') ?>"
                        class="flex items-center px-3 sm:px-4 py-3 text-red-600 rounded-xl hover:bg-red-50 hover:text-red-700 transition-all duration-200 group">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors flex-shrink-0">
                            <i
                                class="fas fa-sign-out-alt text-red-600 group-hover:text-red-700 text-sm sm:text-base"></i>
                        </div>
                        <span class="font-medium text-sm sm:text-base truncate nav-text">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Collapsed Sidebar (Icons Only) -->
<aside
    class="fixed left-0 top-0 bottom-0  bg-white shadow-xl border-r border-gray-100 sidebar-transition z-30 overflow-visible transition-all duration-300 hidden"
    id="sidebar-collapsed">
    <div class="flex flex-col h-full">
        <!-- Brand header -->
        <a href="<?php echo base_url('') ?>"
            class="px-3 py-4 border-b border-gray-100 flex-shrink-0 flex justify-center brand-header">
            <img src="<?php echo base_url('assets/images/deltaone.png'); ?>" alt="DeltaOne Logo"
                class="h-10 w-10 object-contain">
        </a>

        <!-- Collapsed sidebar content -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <ul class="space-y-1">
                <li>
                    <a href="<?php echo base_url('dashboard') ?>"
                        class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                        id="dashboardMainMenuCollapsed" data-page="dashboard" title="Dashboard">
                        <div
                            class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                            <i class="fas fa-tachometer-alt text-gray-600 nav-icon text-base"></i>
                        </div>
                    </a>
                </li>
                <?php if ($user_permission): ?>

                    <?php if (in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                        <li class="menu-item" id="mainProductNavCollapsed">
                            <button
                                class="flex justify-center w-full px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 menu-toggle nav-item group"
                                data-page="products" title="Products">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-cube text-gray-600 nav-icon text-base"></i>
                                </div>
                            </button>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createWorkOrder', $user_permission) || in_array('updateWorkOrder', $user_permission) || in_array('viewWorkOrder', $user_permission) || in_array('deleteWorkOrder', $user_permission)): ?>
                        <li class="menu-item" id="mainWorkOrderNavCollapsed">
                            <button
                                class="flex justify-center w-full px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 menu-toggle nav-item group"
                                data-page="Workorder" title="Work Order">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <span class="material-symbols-outlined text-gray-600 nav-icon text-2xl">
                                        order_play
                                    </span>
                                </div>
                            </button>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createStore', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
                        <li id="storeNavCollapsed">
                            <a href="<?php echo base_url('stores/') ?>"
                                class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="stores" title="Storage Location">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <span
                                        class="material-symbols-outlined text-gray-600 group-hover:text-blue-700 text-xl nav-icon">
                                        shelves
                                    </span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                        <li class="menu-item" id="mainUserNavCollapsed">
                            <button
                                class="flex justify-center w-full px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 menu-toggle nav-item group"
                                data-page="users" title="Users">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-users text-gray-600 nav-icon text-base"></i>
                                </div>
                            </button>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                        <li class="menu-item" id="mainOrderNavCollapsed">
                            <button
                                class="flex justify-center w-full px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 menu-toggle nav-item group"
                                data-page="job_order" title="Job Order">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-truck text-gray-600 nav-icon text-base"></i>
                                </div>
                            </button>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createBrand', $user_permission) || in_array('updateBrand', $user_permission) || in_array('viewBrand', $user_permission) || in_array('deleteBrand', $user_permission)): ?>
                        <li id="brandNavCollapsed">
                            <a href="<?php echo base_url('brands/') ?>"
                                class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="brands" title="Brands">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-tags text-gray-600 nav-icon text-base"></i>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
                        <li id="categoryNavCollapsed">
                            <a href="<?php echo base_url('category/') ?>"
                                class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="category" title="Category">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-folder text-gray-600 nav-icon text-base"></i>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>



                    <?php if (in_array('createAttribute', $user_permission) || in_array('updateAttribute', $user_permission) || in_array('viewAttribute', $user_permission) || in_array('deleteAttribute', $user_permission)): ?>
                        <li id="attributeNavCollapsed">
                            <a href="<?php echo base_url('attributes/') ?>"
                                class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="attributes" title="Attributes">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-list-ul text-gray-600 nav-icon text-base"></i>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- <?php if (in_array('viewReports', $user_permission)): ?>
            <li id="reportNavCollapsed">
              <a href="<?php echo base_url('reports/') ?>"
                class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                data-page="reports" title="Reports">
                <div
                  class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                  <i class="fas fa-chart-bar text-gray-600 nav-icon text-base"></i>
                </div>
              </a>
            </li>
          <?php endif; ?> -->

                    <?php if (in_array('updateCompany', $user_permission)): ?>
                        <li id="companyNavCollapsed">
                            <a href="<?php echo base_url('company/') ?>"
                                class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="company" title="Company">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-building text-gray-600 nav-icon text-base"></i>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Divider -->
                    <li class="my-4">
                        <hr class="border-gray-200">
                    </li>

                    <!-- Activity Log -->

                    <?php if (in_array('viewActivityLog', $user_permission)): ?>
                        <li id="activityLogNavCollapsed">
                            <a href="<?php echo base_url('activitylog/') ?>"
                                class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="activitylog" title="Activity Log">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-history text-gray-600 nav-icon text-base"></i>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>


                    <?php if (in_array('viewProfile', $user_permission)): ?>
                        <li>
                            <a href="<?php echo base_url('users/profile/') ?>"
                                class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="users/profile" title="Profile">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-user text-gray-600 nav-icon text-base"></i>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array('updateSetting', $user_permission)): ?>
                        <li>
                            <a href="<?php echo base_url('users/setting/') ?>"
                                class="flex justify-center px-2 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group nav-item"
                                data-page="users/setting" title="Settings">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0 icon-bg">
                                    <i class="fas fa-cog text-gray-600 nav-icon text-base"></i>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Close the main $user_permission block -->

                <li class="mt-4">
                    <a href="<?php echo base_url('auth/logout') ?>"
                        class="flex justify-center px-2 py-3 text-red-600 rounded-xl hover:bg-red-50 hover:text-red-700 transition-all duration-200 group"
                        title="Logout">
                        <div
                            class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition-colors flex-shrink-0">
                            <i class="fas fa-sign-out-alt text-red-600 group-hover:text-red-700 text-base"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>


<!-- JavaScript (unchanged from previous version) -->
<script>
    $(document).ready(function() {
        const $sidebarFull = $('#sidebar-full');
        const $sidebarCollapsed = $('#sidebar-collapsed');
        const $overlay = $('#sidebar-overlay');
        const $sidebarToggle = $('#sidebar-toggle');
        const $body = $('body');

        let sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        function initSidebarState() {
            if ($(window).width() >= 1024) {
                $sidebarFull.removeClass('-translate-x-full');
                $sidebarCollapsed.addClass('hidden');
                $overlay.addClass('hidden');

                if (sidebarCollapsed) {
                    collapseSidebar();
                } else {
                    expandSidebar();
                }
            } else {
                $sidebarFull.addClass('-translate-x-full');
                $sidebarCollapsed.addClass('hidden');
                expandSidebar();
            }
        }

        function collapseSidebar() {
            $sidebarFull.addClass('hidden');
            $sidebarCollapsed.removeClass('hidden').addClass('w-16');
            $('.main-content-wrapper').css('margin-left', '4rem').css('width', 'calc(100% - 4rem)');
            $('.content-wrapper').css('padding-left', '4rem');
            sidebarCollapsed = true;
            localStorage.setItem('sidebarCollapsed', 'true');
        }

        function expandSidebar() {
            $sidebarFull.removeClass('hidden');
            $sidebarCollapsed.addClass('hidden');
            if ($(window).width() >= 1024) {
                $('.main-content-wrapper').css('margin-left', '16rem').css('width', 'calc(100% - 16rem)');
                $('.content-wrapper').css('padding-left', '16rem');
            }
            sidebarCollapsed = false;
            localStorage.setItem('sidebarCollapsed', 'false');
        }

        function toggleSidebarCollapse() {
            if ($(window).width() >= 1024) {
                if (sidebarCollapsed) {
                    expandSidebar();
                } else {
                    collapseSidebar();
                }
            } else {
                toggleMobileSidebar();
            }
        }

        function toggleMobileSidebar() {
            $sidebarFull.toggleClass('-translate-x-full');
            $sidebarCollapsed.addClass('hidden');
            $overlay.toggleClass('hidden');
            $body.toggleClass('overflow-hidden');
        }

        initSidebarState();

        $(document).on('click', '#sidebar-toggle', function(e) {
            e.preventDefault();
            toggleSidebarCollapse();
        });

        $overlay.on('click', function() {
            toggleMobileSidebar();
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && !$sidebarFull.hasClass('-translate-x-full') && $(window).width() <
                1024) {
                toggleMobileSidebar();
            }
        });

        $(window).on('resize', function() {
            initSidebarState();
        });

        $('.menu-toggle', $sidebarFull).on('click', function(e) {
            e.preventDefault();
            if (sidebarCollapsed && $(window).width() >= 1024) {
                expandSidebar();
                return;
            }

            const $menuItem = $(this).closest('.menu-item');
            const $submenu = $menuItem.find('.submenu');
            const $icon = $(this).find('.fa-chevron-down');

            $submenu.slideToggle(200);
            $icon.toggleClass('rotate-180');

            $('.menu-item', $sidebarFull).not($menuItem).each(function() {
                const $otherSubmenu = $(this).find('.submenu');
                const $otherIcon = $(this).find('.fa-chevron-down');
                const hasActive = $otherSubmenu.find('.active-nav').length > 0;

                if (!hasActive) {
                    $otherSubmenu.slideUp(200);
                    $otherIcon.removeClass('rotate-180');
                }
            });
        });

        $('.menu-toggle', $sidebarCollapsed).on('click', function(e) {
            e.preventDefault();
            expandSidebar();
        });

        function setActiveNavItem() {
            const currentPath = window.location.pathname;
            const currentUrl = window.location.href;

            $('.nav-item').removeClass('bg-blue-600 text-white active-nav bg-blue-50 text-blue-600');
            $('.icon-bg').removeClass('bg-blue-500 bg-blue-100').addClass('bg-gray-100');
            $('.nav-icon').removeClass('text-white text-blue-600').addClass('text-gray-600');
            $('.chevron-icon').removeClass('rotate-180 text-blue-600 text-white').addClass('text-gray-400');
            $('.menu-toggle').removeClass('parent-active');

            let activeFound = false;

            $('.nav-item').each(function() {
                const $item = $(this);
                const href = $item.attr('href') || $item.find('a').first().attr('href');
                const dataPage = $item.attr('data-page') || $item.find('a').first().attr('data-page');

                if (href && (currentUrl === href || currentPath === href.replace(window.location.origin,
                        ''))) {
                    $item.addClass('bg-blue-600 text-white active-nav');
                    $item.find('.icon-bg').removeClass('bg-gray-100').addClass('bg-blue-500');
                    $item.find('.nav-icon').removeClass('text-gray-600').addClass('text-white');
                    $item.find('.chevron-icon').removeClass('text-gray-400').addClass('text-white');

                    const $parentMenu = $item.closest('.submenu');
                    if ($parentMenu.length) {
                        $parentMenu.removeClass('hidden').show();
                        const $parentToggle = $parentMenu.siblings('.menu-toggle');
                        $parentToggle.addClass('bg-blue-600 text-white active-nav parent-active');
                        $parentToggle.find('.icon-bg').removeClass('bg-gray-100').addClass('bg-blue-500');
                        $parentToggle.find('.nav-icon').removeClass('text-gray-600').addClass('text-white');
                        $parentToggle.find('.chevron-icon').addClass('rotate-180 text-white').removeClass(
                            'text-gray-400');
                    }

                    activeFound = true;
                    return false;
                }
            });


        }


        setActiveNavItem();
    });
</script>

<!-- Styles (unchanged) -->
<style>
    .rotate-180 {
        transform: rotate(180deg);
    }

    .nav-item {
        position: relative;
    }

    .nav-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 0;
        background: #fe9801;
        border-radius: 3px;
        transition: height 0.2s ease;
    }

    .nav-item.active-nav::before {
        height: 30px;
    }

    .nav-item:hover {
        background-color: #00ccff !important;
        color: white !important;
    }

    .nav-item:hover .icon-bg {
        background-color: #5CDEFF !important;
    }

    .nav-item:hover .nav-icon {
        color: white !important;
    }

    .nav-item:hover .chevron-icon {
        color: white !important;
    }

    .nav-item.active-nav {
        background-color: #00ccff !important;
        color: white !important;
    }

    .nav-item.active-nav .icon-bg {
        background-color: #5CDEFF !important;
    }

    .nav-item.active-nav .nav-icon {
        color: white !important;
    }

    .nav-item.active-nav .chevron-icon {
        color: white !important;
    }

    .menu-toggle.parent-active {
        background-color: #00ccff !important;
        color: white !important;
    }

    .menu-toggle.parent-active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 30px;
        background: #fe9801;
        border-radius: 0 2px 2px 0;
    }

    .menu-toggle.parent-active .icon-bg {
        background-color: #5CDEFF !important;
    }

    .menu-toggle.parent-active .nav-icon {
        color: white !important;
    }

    .menu-toggle.parent-active .chevron-icon {
        color: white !important;
    }

    #sidebar-collapsed .nav-item {
        justify-content: center;
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }

    #sidebar-collapsed .submenu {
        display: none !important;
    }

    #sidebar-collapsed .brand-header {
        justify-content: center;
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }

    .scrollbar-thin {
        scrollbar-width: 0;
    }

    .scrollbar-thin::-webkit-scrollbar {
        width: 0;
    }

    .scrollbar-thumb-gray-300::-webkit-scrollbar-thumb {
        background-color: transparent;
    }

    .scrollbar-track-gray-100::-webkit-scrollbar-track {
        background-color: #f3f4f6;
    }

    @media (max-width: 640px) {
        .nav-item::before {
            width: 2px;
        }

        .nav-item.active-nav::before {
            height: 16px;
        }

        .menu-toggle.parent-active::before {
            width: 2px;
            height: 16px;
        }
    }

    @media (max-width: 1023px) {
        aside {
            z-index: 30 !important;
        }
    }

    .sidebar-transition {
        transition: all 0.3s ease;
    }

    .nav-item[title]:hover::after {
        content: attr(title);
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        background: #1f2937;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        white-space: nowrap;
        z-index: 1000;
        margin-left: 0.5rem;
        opacity: 0;
        animation: fadeIn 0.2s ease forwards;
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }

    .main-content-wrapper {
        transition: margin-left 0.3s ease, width 0.3s ease;
    }

    .content-wrapper {
        transition: padding-left 0.3s ease;
    }
</style>