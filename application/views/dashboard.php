<div class="min-h-screen bg-gray-50 font-sans antialiased">
    <!-- Enhanced dashboard with better visual hierarchy and modern card design -->
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Content Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-slate-900">Dashboard</h1>
                    <p class="text-slate-600 mt-4 text-lg">Welcome to Delta One Asset Management System.</p>
                </div>
                <nav class="flex items-center space-x-2 text-sm text-slate-500">
                    <a href="#" class="flex items-center hover:text-primary transition-colors duration-200">
                        <i class="fas fa-home mr-1"></i>
                        Home
                    </a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-slate-900 font-medium">Dashboard</span>
                </nav>
            </div>
        </div>

        <!-- workorder_stats Cards -->
        <?php if ($is_admin): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Products Card -->
                <div
                    class=" bg-white rounded-2xl shadow-lg border border-slate-200/60 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden relative">
                    <span
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-400/20 to-blue-500/20 rounded-full -translate-y-16 translate-x-16">
                    </span>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-cyan-500 to-blue-600 p-3 rounded-xl shadow-lg">
                                <i class="fas fa-cube text-2xl text-white"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-600">Total Items</p>
                                <p class="text-3xl font-bold text-slate-900"><?php echo $total_products; ?></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-emerald-600">
                                <i class="fas fa-arrow-up text-sm mr-1"></i>
                                <span class="text-sm font-medium">Active</span>
                            </div>
                            <a href="<?php echo base_url('products/'); ?>"
                                class="inline-flex items-center text-sm font-medium text-cyan-600 hover:text-cyan-700 transition-colors duration-200">
                                View All
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Low Quantity Products Card -->
                <div
                    class=" bg-white rounded-2xl shadow-lg border border-slate-200/60 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden relative">
                    <span
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-400/20 to-pink-500/20 rounded-full -translate-y-16 translate-x-16">
                    </span>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-red-500 to-pink-600 p-3 rounded-xl shadow-lg">
                                <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-600">Low Stock Alert</p>
                                <p class="text-3xl font-bold text-slate-900">
                                    <?php echo isset($low_quantity_count) ? $low_quantity_count : '0'; ?></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-red-600">
                                <i class="fas fa-exclamation-circle text-sm mr-1"></i>
                                <span class="text-sm font-medium">Needs Attention</span>
                            </div>
                            <a href="<?php echo base_url('lowindex'); ?>"
                                class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-700 transition-colors duration-200">
                                View All
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total Users Card -->
                <div
                    class=" bg-white rounded-2xl shadow-lg border border-slate-200/60 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden relative">
                    <span
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-400/20 to-orange-500/20 rounded-full -translate-y-16 translate-x-16">
                    </span>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-3 rounded-xl shadow-lg">
                                <i class="fas fa-users text-2xl text-white"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-600">Asset Users</p>
                                <p class="text-3xl font-bold text-slate-900"><?php echo $total_users; ?></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-amber-600">
                                <i class="fas fa-user-check text-sm mr-1"></i>
                                <span class="text-sm font-medium">Registered</span>
                            </div>
                            <a href="<?php echo base_url('users/'); ?>"
                                class="inline-flex items-center text-sm font-medium text-amber-600 hover:text-amber-700 transition-colors duration-200">
                                Manage
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total Stores Card -->
                <div
                    class=" bg-white rounded-2xl shadow-lg border border-slate-200/60 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden relative">
                    <span
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-400/20 to-green-500/20 rounded-full -translate-y-16 translate-x-16">
                    </span>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-emerald-500 to-green-600 p-3 rounded-xl shadow-lg">
                                <span class="material-symbols-outlined text-3xl text-white">
                                    shelves
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-600">Rack Locations</p>
                                <p class="text-3xl font-bold text-slate-900"><?php echo $total_stores; ?></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-emerald-600">
                                <i class="fas fa-map-marker-alt text-sm mr-1"></i>
                                <span class="text-sm font-medium">Active</span>
                            </div>
                            <a href="<?php echo base_url('stores/'); ?>"
                                class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 transition-colors duration-200">
                                View All
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Maximum Quantity Products Card -->
                <div
                    class=" bg-white rounded-2xl shadow-lg border border-slate-200/60 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden relative">
                    <span
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-400/20 to-pink-500/20 rounded-full -translate-y-16 translate-x-16">
                    </span>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-red-500 to-pink-600 p-3 rounded-xl shadow-lg">
                                <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-600">Over Stock Alert</p>
                                <p class="text-3xl font-bold text-slate-900">
                                    <?php echo isset($high_quantity_count) ? $high_quantity_count : '0'; ?></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-red-600">
                                <i class="fas fa-exclamation-circle text-sm mr-1"></i>
                                <span class="text-sm font-medium">Needs Attention</span>
                            </div>
                            <a href="<?php echo base_url('products'); ?>"
                                class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-700 transition-colors duration-200">
                                View All
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Job Order Card -->
                <div
                    class=" bg-white rounded-2xl shadow-lg border border-slate-200/60 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden relative">
                    <span
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-teal-400/20 to-green-500/20 rounded-full -translate-y-16 translate-x-16">
                    </span>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-teal-500 to-green-600 p-3 rounded-xl shadow-lg">
                                <i class="fas fa-clipboard-list text-2xl text-white"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-600">Work Order</p>
                                <p class="text-3xl font-bold text-slate-900"><?php echo $pending_wo ?></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-teal-600">
                                <i class="fas fa-tasks text-sm mr-1"></i>
                                <span class="text-sm font-medium">Pending</span>
                            </div>
                            <a href="<?php echo base_url('work_order/'); ?>"
                                class="inline-flex items-center text-sm font-medium text-teal-600 hover:text-teal-700 transition-colors duration-200">
                                View All
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- For Approval Card -->
                <div
                    class=" bg-white rounded-2xl shadow-lg border border-slate-200/60 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden relative">
                    <span
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-rose-400/20 to-red-500/20 rounded-full -translate-y-16 translate-x-16">
                    </span>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-rose-500 to-red-600 p-3 rounded-xl shadow-lg">
                                <i class="fas fa-check-double text-2xl text-white"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-600">For Approval</p>
                                <p class="text-3xl font-bold text-slate-900"><?php echo $inProgress_wo ?></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-rose-600">
                                <i class="fas fa-hourglass-half text-sm mr-1"></i>
                                <span class="text-sm font-medium">Pending</span>
                            </div>
                            <a href="<?php echo base_url('work_order/'); ?>"
                                class="inline-flex items-center text-sm font-medium text-rose-600 hover:text-rose-700 transition-colors duration-200">
                                View All
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php if (in_array('viewWorkOrder', $user_permission) || in_array('createWorkOrder', $user_permission)): ?>
            <!-- Action Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div></div>

                <?php if (in_array('createWorkOrder', $user_permission)): ?>
                    <a href="<?php echo base_url('work_order/create') ?>"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-plus mr-2"></i>
                        Create Work Request
                    </a>
                <?php endif; ?>
            </div>

            <div class="w-full">
                <div class="mb-8">
                    <div class="w-full flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div class="flex items-center space-x-2">
                            <input type="text" placeholder="Search by title or ID..." class="p-2 px-4 border rounded">
                            <select class="p-2 px-4 border rounded">
                                <option>All Statuses</option>
                                <option>Completed</option>
                                <option>In Progress</option>
                                <option>Pending</option>
                                <option>Closed</option>
                            </select>
                        </div>



                    </div>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($work_orders as $wo): ?>
                        <?php
                        // Determine border & status colors based on status
                        $status = strtoupper($wo->status);
                        $sign_need = intval($wo->sign_need);
                        $statusColors = [
                            'COMPLETED' => ['border' => 'border-green-500', 'badgeBg' => 'bg-green-100', 'badgeText' => 'text-green-800', 'title' => 'text-green-500'],
                            'IN PROGRESS' => ['border' => 'border-yellow-500', 'badgeBg' => 'bg-yellow-100', 'badgeText' => 'text-yellow-800', 'title' => 'text-yellow-500'],
                            'PENDING' => ['border' => 'border-orange-500', 'badgeBg' => 'bg-orange-100', 'badgeText' => 'text-orange-800', 'title' => 'text-orange-500'],
                            'CLOSED' => ['border' => 'border-gray-500', 'badgeBg' => 'bg-gray-100', 'badgeText' => 'text-gray-800', 'title' => 'text-gray-500'],
                        ];
                        $colors = $statusColors[$status] ?? $statusColors['PENDING'];

                        // Check if Closed for opacity
                        $opacity = ($status == 'CLOSED') ? 'opacity-50' : '';
                        ?>

                        <div
                            class="min-h-56 bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden relative <?= $colors['border'] ?> <?= $opacity ?>">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="<?= $colors['title'] ?> font-semibold text-xl"><?= $wo->request_no ?></p>
                                    <p class="text-gray-600 text-base"><?= $wo->request_title ?></p>
                                    <p class="text-gray-500 text-sm"><?= substr($wo->description, 0, 60) ?>...</p>
                                </div>
                                <div class="status-tags">
                                    <div class="<?= $colors['badgeBg'] ?> px-2.5 py-0.5 rounded">
                                        <span
                                            class="inline-block  <?= $colors['badgeText'] ?> text-xs font-medium "><?= $status ?></span>
                                    </div>
                                    <?php if ($status === 'PENDING' && $sign_need > 0): ?>
                                        <div style="margin-top: 4px;" class="bg-red-100 px-2.5 py-0.5 rounded">
                                            <span class="badge badge-warning text-red-600 ">
                                                <i class="fas fa-exclamation-triangle"></i> Sign<br> Needed (<?= $sign_need ?>)
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <!-- <span class="inline-block <?= $colors['badgeBg'] ?> <?= $colors['badgeText'] ?> text-xs font-medium px-2.5 py-0.5 rounded"><?= $status ?></span> -->
                            </div>
                            <div class="text-gray-500 text-sm mt-4">
                                <p>Requested By: <?= isset($wo->requested_by['firstname'], $wo->requested_by['lastname'])
                                                        ? $wo->requested_by['firstname'] . ' ' . $wo->requested_by['lastname']
                                                        : 'Unknown' ?></p>
                                <p>Priority: <?= $wo->priority_mode ?></p>
                                <p><?= ($status == 'COMPLETED') ? 'Completion Date' : (($status == 'CLOSED') ? 'Closed Date' : 'Request Date') ?>:
                                    <?= date('M d, Y', strtotime($wo->request_date)) ?></p>
                            </div>

                            <div class="absolute bottom-4 right-4 flex gap-x-2 items-center">
                                <?php if (in_array('updateWorkOrder', $user_permission) || $sign_need > 0): ?>
                                    <a href="<?= base_url('work_order/edit/' . $wo->id) ?>"
                                        class="items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-pencil text-sm"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (in_array('deleteWorkOrder', $user_permission)): ?>
                                    <a href="<?= base_url('work_order/delete/' . $wo->id) ?>"
                                        onclick="return confirm('Are you sure you want to delete this work order?');"
                                        class="items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-trash text-sm"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        <?php endif; ?>
    </div>
</div>