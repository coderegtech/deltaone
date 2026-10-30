<!-- Main Content Wrapper -->
<div class="w-full p-6 sm:p-8 lg:p-10 bg-gradient-to-b from-slate-50 to-white min-h-screen">
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
                <a href="<?php echo htmlspecialchars(base_url('products')); ?>"
                    class="hover:text-blue-600 transition-colors duration-300">Products</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-slate-900 font-semibold">Low Stock</span>
            </nav>
        </div>
    </div>

    <!-- Flash Messages -->
    <div id="messages" class="mb-8">
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

            </div>
            <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-3">
                <!-- Store Filter -->
                <div class="input-container" data-type="store">
                    <select id="store_filter" name="store_filter"
                        class="select-input w-full sm:w-48 px-4 py-2 border border-slate-100 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Stores</option>
                        <?php foreach ($stores as $k => $v): ?>
                            <option value="<?php echo htmlspecialchars($v['id']); ?>">
                                <?php echo htmlspecialchars($v['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" id="store_filter_autocomplete" name="store_filter_autocomplete"
                        class="autocomplete-input w-full sm:w-48 px-4 py-2 border border-slate-100 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hidden"
                        placeholder="Search stores" autocomplete="off">
                    <input type="hidden" id="store_filter_id" name="store_filter_id">
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <a href="<?php echo htmlspecialchars(base_url('products')); ?>"
                        class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition-colors">
                        <i class="fas fa-list mr-2"></i>
                        All Items
                    </a>
                    <?php if (in_array('createProduct', $user_permission)): ?>
                        <a href="<?php echo base_url('products/create') ?>"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Item
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
                    <h3 class="text-2xl font-semibold text-slate-900">Low Stock Item</h3>
                    <p class="text-slate-500 text-base mt-1">Item requiring immediate attention</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="relative overflow-x-auto">
                <div id="loading-spinner"
                    class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                    <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
                <table id="manageTable" class="w-full text-sm text-left text-slate-700">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="py-4 px-4 font-semibold text-slate-700">Image</th>
                            <th class="py-4 px-4 font-semibold text-slate-700">Product Name</th>
                            <th class="py-4 px-4 font-semibold text-slate-700">Item Number</th>
                            <th class="py-4 px-4 font-semibold text-slate-700">Cost</th>
                            <th class="py-4 px-4 font-semibold text-slate-700">Current Qty</th>
                            <th class="py-4 px-4 font-semibold text-slate-700">Low Threshold</th>
                            <th class="py-4 px-4 font-semibold text-slate-700">Store</th>
                            <th class="py-4 px-4 font-semibold text-slate-700">Status</th>
                            <?php if (in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                                <th class="py-4 px-4 font-semibold text-slate-700">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($low_quantity_products)): ?>
                            <?php foreach ($low_quantity_products as $product): ?>
                                <tr class="border-b border-slate-100">
                                    <td class="py-2 px-4">
                                        <?php if (!empty($product['image']) && strpos($product['image'], 'You did not select') === false): ?>
                                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image"
                                                class="h-12 w-12 object-cover">
                                        <?php else: ?>
                                            <span class="text-slate-400 italic">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-2 px-4"><?= htmlspecialchars($product['name']) ?></td>
                                    <td class="py-2 px-4"><?= htmlspecialchars($product['sku']) ?></td>
                                    <td class="py-2 px-4">₱<?= number_format($product['price'], 2) ?></td>
                                    <td class="py-2 px-4"><?= $product['qty'] ?></td>
                                    <td class="py-2 px-4"><?= $product['low_quantity'] ?></td>
                                    <td class="py-2 px-4">Store <?= $product['store_id'] ?></td>
                                    <td class="py-2 px-4">
                                        <?= $product['availability'] ? '<span class="text-green-600 font-semibold">Available</span>' : '<span class="text-red-600 font-semibold">Out of Stock</span>' ?>
                                    </td>

                                    <?php if (in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                                        <td class="py-2 px-4 space-x-2 flex">
                                            <?php if (in_array('updateProduct2', $user_permission)): ?>
                                                <a href="<?php echo base_url('products/update2/'); ?><?= $product['id'] ?>"
                                                    class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200"><i
                                                        class="fas fa-edit text-sm"></i></a>
                                            <?php endif; ?>
                                            <?php if (in_array('updateProduct', $user_permission)): ?>
                                                <a href="<?php echo base_url('products/update/'); ?><?= $product['id'] ?>"
                                                    class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200"><i
                                                        class="fas fa-pencil text-sm"></i></a>
                                            <?php endif; ?>
                                            <?php if (in_array('deleteProduct', $user_permission)): ?>
                                                <button onclick="openDeleteModal(<?= $product['id'] ?>, '<?= $product['name'] ?>')"
                                                    class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200"><i
                                                        class="fas fa-trash text-sm"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
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
    var manageTable;

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


    // Handle delete button click
    $(document).on('click', '.remove-btn', function() {
        var productId = $(this).data('id');
        $('#product_id_to_remove').val(productId);
        showRemoveModal();
    });

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
</script>