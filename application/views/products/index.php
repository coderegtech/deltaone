<div class="w-full max-w-none p-6 sm:p-8 lg:p-10 bg-gradient-to-b from-slate-50 to-white min-h-screen">
    <!-- Content Header -->
    <div class="mb-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manage Items</h1>
                <p class="text-slate-500 mt-2 text-lg">Streamlined inventory and item catalog management</p>
            </div>
            <nav class="flex items-center space-x-3 text-base text-slate-500 font-medium">
                <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-300">
                    <i class="fas fa-home mr-2"></i>
                    Dashboard
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-slate-900 font-semibold">Items</span>
            </nav>
        </div>
    </div>

    <!-- Flash Messages -->
    <div id="messages" class="mb-8"></div>

    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-8">
        <div class="flex items-center space-x-6">
            <div class="bg-white rounded-2xl px-6 py-3 shadow-md border border-slate-100/50 flex items-center gap-3">
                <span class="text-base text-slate-600 font-medium">Total Items:</span>
                <span class="font-bold text-slate-900 text-lg" id="totalProducts">0</span>
            </div>
        </div>
        <?php if (in_array('createProduct', $user_permission)): ?>
            <a href="<?php echo base_url('products/create') ?>"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i>
                Add New Item
            </a>
        <?php endif; ?>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100/50 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-slate-100">
            <div class="flex items-center">
                <div class="bg-blue-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-box text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-semibold text-slate-900">Item Inventory</h3>
                    <p class="text-slate-500 text-base mt-1">Efficiently manage your item catalog and stock levels
                    </p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="manageTable" class="w-full min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th
                            class="px-8 py-5 whitespace-nowrap text-left text-xs font-semibold text-slate-600 uppercase tracking-widest">
                            Image</th>
                        <th
                            class="px-8 py-5 whitespace-nowrap text-left text-xs font-semibold text-slate-600 uppercase tracking-widest">
                            Item Name</th>
                        <th
                            class="px-8 py-5 whitespace-nowrap text-left text-xs font-semibold text-slate-600 uppercase tracking-widest">
                            Item Number</th>
                        <th
                            class="px-8 py-5 whitespace-nowrap text-left text-xs font-semibold text-slate-600 uppercase tracking-widest">
                            Price</th>
                        <th
                            class="px-8 py-5 whitespace-nowrap text-left text-xs font-semibold text-slate-600 uppercase tracking-widest">
                            Quantity</th>
                        <th
                            class="px-8 py-5 whitespace-nowrap text-left text-xs font-semibold text-slate-600 uppercase tracking-widest">
                            Store</th>
                        <th
                            class="px-8 py-5 whitespace-nowrap text-left text-xs font-semibold text-slate-600 uppercase tracking-widest">
                            Availability</th>
                        <th
                            class="px-8 py-5 whitespace-nowrap text-left text-xs font-semibold text-slate-600 uppercase tracking-widest">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100"></tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="removeModal" class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-50">
        <div
            class="bg-white rounded-3xl shadow-2xl border border-slate-100/50 w-full max-w-md transform scale-95 opacity-0 transition-all duration-300">
            <div
                class="bg-gradient-to-r from-red-50 to-rose-50 px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <h4 class="text-xl font-semibold text-slate-900">Delete Product</h4>
                <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors"
                    onclick="hideModal('removeModal')">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form id="removeForm" action="<?php echo base_url('products/remove') ?>" method="post">
                <div class="p-8">
                    <div class="text-center mb-6">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900 mb-3">Are you sure you want to delete this
                            product?</h3>
                        <p class="text-slate-500 text-base mb-2">Product: <span id="productNameDisplay"
                                class="font-semibold text-slate-700"></span></p>
                        <p class="text-slate-500 text-base">This action is permanent and cannot be undone. All
                            associated data will be lost.</p>
                    </div>
                    <input type="hidden" name="product_id" id="product_id_to_remove">
                </div>
                <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100 flex justify-end space-x-3">
                    <button type="button"
                        class="px-5 py-2.5 bg-slate-200 text-slate-700 rounded-xl hover:bg-slate-300 transition-colors font-medium"
                        onclick="hideModal('removeModal')">Cancel</button>
                    <button type="submit" id="deleteProductBtn"
                        class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors font-medium">
                        <span class="btn-text">Delete Product</span>
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

    function openDeleteModal(id, productName) {
        $('#product_id_to_remove').val(id);
        $('#productNameDisplay').text(productName);
        showModal('removeModal');
    }

    $(document).ready(function() {
        $("#mainProductNav").addClass('active');

        var manageTable = $('#manageTable').DataTable({
            ajax: {
                url: base_url + 'products/fetchProductData',
                dataSrc: 'data'
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return row[0].replace('img-circle',
                            'rounded-full object-cover w-12 h-12 ml-8');
                    },
                    className: 'py-4 px-2'
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `<span class="font-semibold">${row[1]}</span>`;
                    },
                    className: 'py-4 px-2'
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `<span class="text-slate-600">${row[2]}</span>`;
                    },
                    className: 'py-4 px-2'
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `<span class="text-slate-600">$${parseFloat(row[3]).toFixed(2)}</span>`;
                    },
                    className: 'py-4 px-2'
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `<span class="text-slate-600">${row[4]}</span>`;
                    },
                    className: 'py-4 px-2'
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `<span class="text-slate-600">${row[5]}</span>`;
                    },
                    className: 'py-4 px-2'
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return row[6].replace('label label-success',
                                'inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 bg-green-100/80 rounded-full'
                            )
                            .replace('label label-warning',
                                'inline-flex items-center px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100/80 rounded-full'
                            );
                    },
                    className: 'py-4 px-2'
                },
                {
                    targets: -1,
                    render: function(data, type, row) {
                        let id = row[8];
                        let productName = row[1].replace(/<[^>]*>/g, '');
                        let actions = '';
                        <?php if (in_array('updateProduct2', $user_permission)): ?>
                            actions +=
                                `<a href="<?php echo base_url('products/update2/'); ?>${id}" class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200"><i class="fas fa-edit text-sm"></i></a>`;
                        <?php endif; ?>
                        <?php if (in_array('updateProduct', $user_permission)): ?>
                            actions +=
                                `<a href="<?php echo base_url('products/update/'); ?>${id}" class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200"><i class="fas fa-pencil text-sm"></i></a>`;
                        <?php endif; ?>
                        <?php if (in_array('deleteProduct', $user_permission)): ?>
                            actions +=
                                `<button onclick="openDeleteModal(${id}, '${productName}')" class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200"><i class="fas fa-trash text-sm"></i></button>`;
                        <?php endif; ?>
                        return `<div class="flex items-center space-x-2">${actions}</div>`;
                    },
                    className: 'py-4 px-2',
                    orderable: false
                }
            ],
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            dom: '<"flex md:flex-row md:items-center justify-between p-6"<"mb-4 md:mb-0"l><"flex items-center"f>>rt<"flex flex-row md:items-center justify-between p-6"<"mb-4 md:mb-0"i><"flex items-center"p>>',
            language: {
                search: '',
                searchPlaceholder: 'Search products...',
                lengthMenu: 'Show _MENU_ products',
                info: 'Showing _START_ to _END_ of _TOTAL_ products',
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    previous: '<i class="fas fa-angle-left"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>'
                }
            },
            initComplete: function(settings, json) {
                stylePagination();
                styleLengthMenu();
                styleSearchInput();
                $('#totalProducts').text(json.data.length);
            },
            drawCallback: function() {
                stylePagination();
            },
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('hover:bg-slate-50/50 transition-colors duration-200');
            }
        });

        function styleSearchInput() {
            $('.dataTables_filter input').addClass(
                'border border-slate-200 rounded-md px-3 ml-1 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
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

        $(document).on('submit', '#removeForm', function(e) {
            e.preventDefault();
            const deleteBtn = $('#deleteProductBtn');
            const btnText = deleteBtn.find('.btn-text');
            const btnLoading = deleteBtn.find('.btn-loading');
            btnText.addClass('hidden');
            btnLoading.removeClass('hidden');
            deleteBtn.prop('disabled', true);
            const productId = $('#product_id_to_remove').val();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: {
                    product_id: productId
                },
                dataType: 'json',
                success: function(response) {
                    btnText.removeClass('hidden');
                    btnLoading.addClass('hidden');
                    deleteBtn.prop('disabled', false);
                    if (response.success) {
                        $('#messages').html(`
              <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl mb-8 flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                  <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                  <span class="font-medium">${response.messages}</span>
                </div>
                <button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors" onclick="this.parentElement.style.display='none'">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            `);
                        $('#manageTable').DataTable().ajax.reload(null, false);
                        hideModal('removeModal');
                    } else {
                        $('#messages').html(`
              <div class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl mb-8 flex items-center justify-between shadow-sm">
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
            <div class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl mb-8 flex items-center justify-between shadow-sm">
              <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span class="font-medium">An error occurred while deleting the product</span>
              </div>
              <button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
              </button>
            </div>
          `);

                    $('#manageTable').DataTable().ajax.reload(null, false);
                    hideModal('removeModal');
                }
            });
        });

        $(document).on('click', '#removeModal', function(e) {
            if (e.target === this) {
                hideModal('removeModal');
            }
        });
    });
</script>