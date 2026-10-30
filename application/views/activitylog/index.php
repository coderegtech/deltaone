<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Activity Log</h1>
                <p class="text-sm text-gray-600 mt-1">Track all system activities and user actions</p>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <form method="get" action="<?php echo base_url('activitylog'); ?>">
        <div class="bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between space-x-4">
                <div class="flex flex-wrap items-center gap-4">

                    <!-- Filter by Start Date -->
                    <div class="flex items-center space-x-2">
                        <label for="start_date" class="text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Filter by End Date -->
                    <div class="flex items-center space-x-2">
                        <label for="end_date" class="text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Filter by User -->
                    <div class="flex items-center space-x-2">
                        <label for="user_name" class="text-sm font-medium text-gray-700">User</label>
                        <input type="text" name="user_name" id="user_name" placeholder="Search users..."
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-48">
                    </div>

                    <!-- Filter by Action Type -->
                    <div class="flex items-center space-x-2">
                        <label for="action_type" class="text-sm font-medium text-gray-700">Action Type</label>
                        <select name="action_type" id="action_type"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All</option>
                            <option value="Login">Login</option>
                            <option value="Logout">Logout</option>
                            <option value="Create">Create</option>
                            <option value="Update">Update</option>
                            <option value="Delete">Delete</option>
                        </select>
                    </div>
                </div>

                <!-- Submit + Download -->
                <div class="flex items-center space-x-2">
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Filter
                    </button>

                    <a href="<?php echo base_url('activitylog/download'); ?>"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-download"></i>
                        <span>Download</span>
                    </a>
                </div>
            </div>
        </div>
    </form>
    <!-- Activity Log Table -->
    <div class="p-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Time</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">User</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">System</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Action</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Description</th>
                        </tr>
                    </thead>
                    <tbody id="activityTableBody">
                        <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-900">
                                <?= date('m/d/y, g:i A', strtotime($log['log_time'])) ?>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700"><?= htmlspecialchars($log['user_name']) ?></td>
                            <td class="py-3 px-4 text-sm text-gray-600"><?= htmlspecialchars($log['system'] ?? '-') ?>
                            </td>
                            <td class="py-3 px-4">
                                <?php
                                        $action = $log['action_type'] ?? '';
                                        switch ($action) {
                                            case 'Login':
                                                $badge_class = 'bg-green-100 text-green-800';
                                                break;
                                            case 'Update':
                                                $badge_class = 'bg-yellow-100 text-yellow-800';
                                                break;
                                            case 'Create':
                                                $badge_class = 'bg-blue-100 text-blue-800';
                                                break;
                                            case 'Delete':
                                                $badge_class = 'bg-red-100 text-red-800';
                                                break;
                                            case 'Logout':
                                                $badge_class = 'bg-orange-100 text-orange-800';
                                                break;
                                            default:
                                                $badge_class = 'bg-gray-100 text-gray-800';
                                                break;
                                        }
                                        ?>
                                <span class="px-2 py-1 text-xs font-medium rounded-full <?= $badge_class ?>">
                                    <?= htmlspecialchars($action) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700"><?= htmlspecialchars($log['description']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-sm text-gray-500">No activity logs found.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium"><?= $start_index ?></span> to <span
                            class="font-medium"><?= $end_index ?></span> of <span
                            class="font-medium"><?= $total_rows ?></span> results
                    </div>
                    <div class="flex items-center space-x-2">
                        <?php if ($current_page > 1): ?>
                        <a href="<?= base_url("activitylog?page=" . ($current_page - 1) . $query_string) ?>"
                            class="px-3 py-1 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                            Previous
                        </a>
                        <?php else: ?>
                        <span
                            class="px-3 py-1 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed">Previous</span>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="<?= base_url("activitylog?page=$i" . $query_string) ?>"
                            class="px-3 py-1 <?= $i == $current_page ? 'bg-blue-600 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-100' ?> rounded-lg transition-colors">
                            <?= $i ?>
                        </a>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                        <a href="<?= base_url("activitylog?page=" . ($current_page + 1) . $query_string) ?>"
                            class="px-3 py-1 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                            Next
                        </a>
                        <?php else: ?>
                        <span
                            class="px-3 py-1 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed">Next</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // User filter autocomplete
        $('#userFilter').on('input', function() {
            const value = $(this).val().toLowerCase();
            const suggestions = $('#userSuggestions');

            if (value.length > 0) {
                suggestions.removeClass('hidden');
                suggestions.find('div').each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.includes(value)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            } else {
                suggestions.addClass('hidden');
            }
        });

        // User selection
        $(document).on('click', '#userSuggestions div', function() {
            $('#userFilter').val($(this).data('value'));
            $('#userSuggestions').addClass('hidden');
            filterTable();
        });

        // Date filter
        $('#dateFilter').on('change', function() {
            filterTable();
        });

        // Filter table function
        function filterTable() {
            const dateFilter = $('#dateFilter').val();
            const userFilter = $('#userFilter').val().toLowerCase();

            $('#activityTableBody tr').each(function() {
                const row = $(this);
                const rowDate = row.find('td:first').text();
                const rowUser = row.find('td:nth-child(2)').text().toLowerCase();

                let showRow = true;

                // Date filter logic (you can implement date parsing here)
                if (dateFilter && !rowDate.includes(dateFilter)) {
                    // showRow = false;
                }

                // User filter
                if (userFilter && !rowUser.includes(userFilter)) {
                    showRow = false;
                }

                if (showRow) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        }

        // Hide suggestions when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.relative').length) {
                $('#userSuggestions').addClass('hidden');
            }
        });

        // Table sorting
        $('th[class*="cursor-pointer"]').on('click', function() {
            const table = $(this).closest('table');
            const tbody = table.find('tbody');
            const rows = tbody.find('tr').toArray();
            const columnIndex = $(this).index();
            const isAscending = !$(this).hasClass('sort-desc');

            // Remove existing sort classes
            $('th').removeClass('sort-asc sort-desc');

            // Add sort class
            if (isAscending) {
                $(this).addClass('sort-asc');
            } else {
                $(this).addClass('sort-desc');
            }

            // Sort rows
            rows.sort(function(a, b) {
                const aText = $(a).find('td').eq(columnIndex).text().trim();
                const bText = $(b).find('td').eq(columnIndex).text().trim();

                if (isAscending) {
                    return aText.localeCompare(bText);
                } else {
                    return bText.localeCompare(aText);
                }
            });

            // Reorder rows
            tbody.empty().append(rows);
        });
    });
    </script>

    <style>
    .sort-asc .fa-sort:before {
        content: "\f0de";
    }

    .sort-desc .fa-sort:before {
        content: "\f0dd";
    }
    </style>