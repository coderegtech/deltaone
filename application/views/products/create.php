<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Content Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Add Item</h1>
                    <p class="text-slate-600 mt-1">Create a new item in your inventory</p>
                </div>
                <nav class="flex items-center space-x-2 text-sm text-slate-500">
                    <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
                        <i class="fas fa-home mr-1"></i>
                        Home
                    </a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-slate-900 font-medium">Items</span>
                </nav>
            </div>
        </div>

        <!-- Flash Messages -->
        <div id="messages" class="mb-8">
        </div>

        <!-- Product Form -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                <div class="flex items-center">
                    <div class="bg-white/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-box text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-white">Item Information</h3>
                        <p class="text-blue-100 text-sm">Fill in the details below to create a new item</p>
                    </div>
                </div>
            </div>

            <form role="form" action="<?php echo base_url('products/create'); ?>" method="post"
                enctype="multipart/form-data">
                <div class="p-6 lg:p-8 space-y-8">

                    <?php if (validation_errors()): ?>
                        <div class="bg-red-50 border-l-4 border-red-400 text-red-800 px-4 py-3 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                                <div><?php echo validation_errors(); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Product Image Section -->
                    <div class="bg-slate-50 rounded-xl p-6 space-y-6">
                        <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                            <i class="fas fa-image text-blue-500 mr-2"></i>
                            Item Image
                        </h4>

                        <div class="flex items-center space-x-6">
                            <div
                                class="relative w-32 h-32 rounded-xl overflow-hidden bg-white border border-slate-200 flex items-center justify-center shadow-sm">
                                <div id="image-preview" class="absolute inset-0 bg-cover bg-center hidden"></div>
                                <i class="fas fa-camera text-slate-400 text-2xl" id="image-placeholder"></i>
                            </div>
                            <div>
                                <label for="product_image"
                                    class="cursor-pointer inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                    <i class="fas fa-upload mr-2"></i>
                                    Upload Image
                                </label>
                                <input id="product_image" name="product_image" type="file" class="sr-only"
                                    accept="image/*">
                                <p class="mt-2 text-xs text-slate-500">JPG, PNG, or GIF (Max 1.5MB)</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="space-x-2 cursor-pointer inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <span class="material-symbols-outlined">
                            barcode_scanner
                        </span>
                        <p>Connect Scanner</p>
                    </div>

                    <!-- Basic Information Section -->
                    <div class="bg-slate-50 rounded-xl p-6 space-y-6">
                        <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Basic Information
                        </h4>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Product Name -->
                            <div class="space-y-3">
                                <label for="product_name" class="block text-sm font-semibold text-slate-700">Item
                                    Name</label>
                                <input type="text"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="product_name" name="product_name" placeholder="Enter product name"
                                    autocomplete="off" required>
                            </div>

                            <!-- part number -->
                            <div class="space-y-3">
                                <label for="sku" class="block text-sm font-semibold text-slate-700">Part Number
                                </label>
                                <div class="relative">
                                    <input type="text"
                                        class="w-full px-4 py-3 pr-20 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        id="sku" name="part_number" placeholder="Enter part number" autocomplete="off"
                                        required>
                                </div>
                            </div>

                            <!-- SKU -->
                            <div class="space-y-3">
                                <label for="sku" class="block text-sm font-semibold text-slate-700">Item Number
                                </label>
                                <div class="relative">
                                    <input type="text"
                                        class="w-full px-4 py-3 pr-20 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        id="sku" name="sku" placeholder="Enter item number" autocomplete="off" required>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="space-y-3">
                                <label for="price" class="block text-sm font-semibold text-slate-700">Price</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-slate-500">&#8369;</span>
                                    </div>
                                    <input type="text"
                                        class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        id="price" name="price" placeholder="0.00" autocomplete="off" required>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="space-y-3">
                                <label for="qty" class="block text-sm font-semibold text-slate-700">Quantity</label>
                                <input type="number"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="qty" name="qty" placeholder="Enter quantity" autocomplete="off" min="0"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Management Section -->
                    <div class="bg-slate-50 rounded-xl p-6 space-y-6">
                        <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                            <i class="fas fa-warehouse text-blue-500 mr-2"></i>
                            Inventory Management
                        </h4>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Low Quantity Alert -->
                            <div class="space-y-3">
                                <label for="low_quantity" class="block text-sm font-semibold text-slate-700">Low
                                    Quantity Alert</label>
                                <input type="number"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="low_quantity" name="low_quantity" placeholder="Enter threshold"
                                    autocomplete="off" min="0">
                            </div>

                            <!-- High Quantity Alert -->
                            <div class="space-y-3">
                                <label for="high_quantity" class="block text-sm font-semibold text-slate-700">High
                                    Quantity Alert</label>
                                <input type="number"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="high_quantity" name="high_quantity" placeholder="Enter threshold"
                                    autocomplete="off" min="0">
                            </div>

                            <!-- Store -->
                            <div class="space-y-3">
                                <label for="store" class="block text-sm font-semibold text-slate-700">Rack
                                    Location</label>
                                <select
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="store" name="store" required>
                                    <option value="">Select a rack location</option>
                                    <?php foreach ($stores as $k => $v): ?>
                                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <!-- Availability -->
                            <div class="space-y-3">
                                <label for="availability"
                                    class="block text-sm font-semibold text-slate-700">Availability</label>
                                <select
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="availability" name="availability" required>
                                    <option value="1">In Stock</option>
                                    <option value="2">Out of Stock</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="bg-slate-50 rounded-xl p-6 space-y-6">
                        <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                            <i class="fas fa-align-left text-blue-500 mr-2"></i>
                            Product Description
                        </h4>

                        <div class="space-y-3">
                            <!-- Added tinymce-editor class to enable rich text editing -->
                            <textarea
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                id="description" name="description" rows="6"
                                placeholder="Enter product description..."></textarea>
                        </div>
                    </div>

                    <!-- Categories and Attributes Section -->
                    <div class="bg-slate-50 rounded-xl p-6 space-y-6">
                        <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                            <i class="fas fa-tags text-blue-500 mr-2"></i>
                            Categories & Attributes
                        </h4>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Brands -->
                            <div class="space-y-3">
                                <label for="brands" class="block text-sm font-semibold text-slate-700">Brands</label>
                                <select
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="brands" name="brands[]" multiple>
                                    <?php foreach ($brands as $k => $v): ?>
                                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <!-- Categories -->
                            <div class="space-y-3">
                                <label for="category"
                                    class="block text-sm font-semibold text-slate-700">Categories</label>
                                <select
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="category" name="category[]" multiple>
                                    <?php foreach ($category as $k => $v): ?>
                                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <!-- Attributes -->
                        <?php if ($attributes): ?>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <?php foreach ($attributes as $k => $v): ?>
                                    <div class="space-y-3">
                                        <label for="attributes_value_id_<?php echo $v['attribute_data']['id'] ?>"
                                            class="block text-sm font-semibold text-slate-700"><?php echo $v['attribute_data']['name'] ?></label>
                                        <select
                                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                            id="attributes_value_id_<?php echo $v['attribute_data']['id'] ?>"
                                            name="attributes_value_id[]" multiple>
                                            <?php foreach ($v['attribute_value'] as $k2 => $v2): ?>
                                                <option value="<?php echo $v2['id'] ?>"><?php echo $v2['value'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Form Actions -->
                <div
                    class="px-6 lg:px-8 py-6 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="<?php echo base_url('products/') ?>"
                        class="px-6 py-3 text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-all duration-200 font-medium text-center shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Items
                    </a>
                    <button type="submit" id="createProductBtn"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <span class="btn-text">
                            <i class="fas fa-plus mr-2"></i>
                            Create Item
                        </span>
                        <span class="btn-loading hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Creating...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add New Brand Modal -->
<div id="brandModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Add New Brand</h3>
            <input type="text" id="new_brand_name"
                class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Brand name">
            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" onclick="closeBrandModal()"
                    class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl hover:bg-slate-300">Cancel</button>
                <button type="button" onclick="addNewBrand()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Add Brand</button>
            </div>
        </div>
    </div>
</div>

<!-- Add New Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Add New Category</h3>
            <input type="text" id="new_category_name"
                class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Category name">
            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" onclick="closeCategoryModal()"
                    class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl hover:bg-slate-300">Cancel</button>
                <button type="button" onclick="addNewCategory()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Add Category</button>
            </div>
        </div>
    </div>
</div>

<style>
    .select2-container--default {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple {
        border: 1px solid #d1d5db !important;
        border-radius: 0.75rem !important;
        padding: 0.5rem !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
        border-radius: 0.375rem !important;
        margin-right: 0.3rem !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__clear {
        color: black !important;
        margin-left: 0.25rem !important;
        font-size: 1rem !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        border: none !important;
        color: black;
        padding: 0.25rem 0.8rem !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice:hover {
        background-color: rgba(0, 0, 0, 0.2) !important;
        color: white !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #f3f4f6;
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#mainProductNav").addClass('active');
        $("#createProductNav").addClass('active');

        $('#generate_sku').on('click', function() {
            const productName = $('#product_name').val();
            const timestamp = Date.now().toString().slice(-6);
            let sku = '';

            if (productName) {
                const words = productName.split(' ').filter(word => word.length > 0);
                sku = words.map(word => word.substring(0, 3).toUpperCase()).join('') + timestamp;
            } else {
                sku = 'PRD' + timestamp;
            }

            $('#sku').val(sku);
        });

        $('#product_image').change(function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 1.5 * 1024 * 1024) {
                    alert('File size must be less than 1.5MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').css('background-image', `url(${e.target.result})`).removeClass(
                        'hidden');
                    $('#image-placeholder').addClass('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        $('#price').on('input', function() {
            let value = this.value.replace(/[^0-9.]/g, '');
            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }
            if (parts[1] && parts[1].length > 2) {
                value = parts[0] + '.' + parts[1].substring(0, 2);
            }
            this.value = value;
        });

        $('form').on('submit', function(e) {
            const submitBtn = $('#createProductBtn');
            const btnText = submitBtn.find('.btn-text');
            const btnLoading = submitBtn.find('.btn-loading');

            const productName = $('#product_name').val().trim();
            const sku = $('#sku').val().trim();
            const price = $('#price').val().trim();
            const qty = $('#qty').val().trim();
            const store = $('#store').val();

            if (!productName || !sku || !price || !qty || !store) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }

            btnText.addClass('hidden');
            btnLoading.removeClass('hidden');
            submitBtn.prop('disabled', true);
        });

        if (typeof $.fn.select2 !== 'undefined') {
            $('#brands, #category').select2({
                placeholder: 'Select options',
                allowClear: true
            });

            <?php if ($attributes): ?>
                <?php foreach ($attributes as $k => $v): ?>
                    $('#attributes_value_id_<?php echo $v['attribute_data']['id'] ?>').select2({
                        placeholder: 'Select <?php echo strtolower($v['attribute_data']['name']) ?>',
                        allowClear: true
                    });
                <?php endforeach ?>
            <?php endif; ?>
        }
    });

    function closeBrandModal() {
        $('#brandModal').addClass('hidden').removeClass('flex');
        $('#new_brand_name').val('');
    }

    function closeCategoryModal() {
        $('#categoryModal').addClass('hidden').removeClass('flex');
        $('#new_category_name').val('');
    }

    function addNewBrand() {
        const brandName = $('#new_brand_name').val().trim();
        if (brandName) {
            const newOption = new Option(brandName, 'new_' + Date.now(), true, true);
            $('#brands').append(newOption).trigger('change');
            closeBrandModal();
        }
    }

    function addNewCategory() {
        const categoryName = $('#new_category_name').val().trim();
        if (categoryName) {
            const newOption = new Option(categoryName, 'new_' + Date.now(), true, true);
            $('#category').append(newOption).trigger('change');
            closeCategoryModal();
        }
    }
</script>