<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Content Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Edit Product</h1>
                    <p class="text-slate-600 mt-1">Update product information and inventory details</p>
                </div>
                <nav class="flex items-center space-x-2 text-sm text-slate-500">
                    <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
                        <i class="fas fa-home mr-1"></i>
                        Home
                    </a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <a href="<?php echo base_url('products/') ?>"
                        class="hover:text-blue-600 transition-colors duration-200">Products</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-slate-900 font-medium">Edit</span>
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
                        <i class="fas fa-edit text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-white">Product Information</h3>
                        <p class="text-blue-100 text-sm">Update product details and inventory settings</p>
                    </div>
                </div>
            </div>

            <!-- Fixed form action to point to correct update endpoint -->
            <form role="form" action="<?php echo base_url('products/update/' . $product_data['id']); ?>" method="post"
                enctype="multipart/form-data">
                <div class="p-6 lg:p-8 space-y-8">

                    <!-- Product Image Section -->
                    <div class="bg-slate-50 rounded-xl p-6 space-y-6">
                        <h4 class="text-lg font-semibold text-slate-800 flex items-center">
                            <i class="fas fa-image text-blue-500 mr-2"></i>
                            Product Image
                        </h4>

                        <div class="flex items-center space-x-6">
                            <div
                                class="relative w-32 h-32 rounded-xl overflow-hidden bg-white border border-slate-200 flex items-center justify-center shadow-sm">
                                <div id="image-preview" class="absolute inset-0 bg-cover bg-center"
                                    style="background-image: url('<?php echo base_url() . $product_data['image'] ?>')">
                                </div>
                                <i class="fas fa-camera text-slate-400 text-2xl hidden" id="image-placeholder"></i>
                            </div>
                            <div>
                                <label for="product_image"
                                    class="cursor-pointer inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                    <i class="fas fa-upload mr-2"></i>
                                    Update Image
                                </label>
                                <input id="product_image" name="product_image" type="file" class="sr-only"
                                    accept="image/*">
                                <p class="mt-2 text-xs text-slate-500">JPG, PNG, or GIF (Max 1.5MB)</p>
                            </div>
                        </div>
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
                                <label for="product_name" class="block text-sm font-semibold text-slate-700">Product
                                    Name</label>
                                <input type="text"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="product_name" name="product_name" placeholder="Enter product name"
                                    value="<?php echo $product_data['name']; ?>" autocomplete="off" required>
                            </div>

                            <!-- part number -->
                            <div class="space-y-3">
                                <label for="sku" class="block text-sm font-semibold text-slate-700">Part Number
                                </label>
                                <div class="relative">
                                    <input type="text"
                                        class="w-full px-4 py-3 pr-20 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        id="sku" name="part_number" placeholder="Enter part number"
                                        value="<?php echo $product_data['part_number']; ?>" autocomplete="off" required>
                                </div>
                            </div>

                            <!-- SKU -->
                            <div class="space-y-3">
                                <label for="sku" class="block text-sm font-semibold text-slate-700">Item Number
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="sku" name="sku" placeholder="Enter item number"
                                    value="<?php echo $product_data['sku']; ?>" autocomplete="off" required>
                            </div>

                            <!-- Price -->
                            <div class="space-y-3">
                                <label for="price" class="block text-sm font-semibold text-slate-700">Price</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-slate-500">$</span>
                                    </div>
                                    <input type="text"
                                        class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        id="price" name="price" placeholder="0.00"
                                        value="<?php echo $product_data['price']; ?>" required>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="space-y-3">
                                <label for="qty" class="block text-sm font-semibold text-slate-700">Quantity</label>
                                <input type="number"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="qty" name="qty" placeholder="Enter quantity"
                                    value="<?php echo $product_data['qty']; ?>" autocomplete="off" min="0" required>
                                <span id="qty_status" class="text-sm mt-2 block"></span>
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
                                    value="<?php echo $product_data['low_quantity']; ?>" autocomplete="off" min="0">
                                <div id="low-qty-alert" class="mt-2 hidden">
                                    <div class="flex items-center p-3 bg-yellow-50 border border-yellow-100 rounded-xl">
                                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                                        <span class="text-sm text-yellow-700">Quantity is at or below the low quantity
                                            threshold</span>
                                    </div>
                                </div>
                            </div>

                            <!-- High Quantity Alert -->
                            <div class="space-y-3">
                                <label for="high_quantity" class="block text-sm font-semibold text-slate-700">High
                                    Quantity Alert</label>
                                <input type="number"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="high_quantity" name="high_quantity" placeholder="Enter threshold"
                                    value="<?php echo isset($product_data['high_quantity']) ? $product_data['high_quantity'] : ''; ?>"
                                    autocomplete="off" min="0">
                                <div id="high-qty-alert" class="mt-2 hidden">
                                    <div class="flex items-center p-3 bg-green-50 border border-green-100 rounded-xl">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-sm text-green-700">Quantity exceeds the high quantity
                                            threshold</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Store -->
                            <div class="space-y-3">
                                <label for="store" class="block text-sm font-semibold text-slate-700">Rack
                                    Location</label>
                                <select
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="store" name="store" required>
                                    <?php foreach ($stores as $k => $v): ?>
                                        <option value="<?php echo $v['id'] ?>" <?php if ($product_data['store_id'] == $v['id']) {
                                                                                    echo "selected='selected'";
                                                                                } ?>><?php echo $v['name'] ?></option>
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
                                    <option value="1" <?php if ($product_data['availability'] == 1) {
                                                            echo "selected='selected'";
                                                        } ?>>In Stock</option>
                                    <option value="2" <?php if ($product_data['availability'] != 1) {
                                                            echo "selected='selected'";
                                                        } ?>>Out of Stock</option>
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
                                placeholder="Enter product description..."><?php echo $product_data['description']; ?></textarea>
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
                                <?php $brand_data = json_decode($product_data['brand_id']); ?>
                                <select
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="brands" name="brands[]" multiple>
                                    <?php foreach ($brands as $k => $v): ?>
                                        <option value="<?php echo $v['id'] ?>" <?php if (in_array($v['id'], $brand_data)) {
                                                                                    echo 'selected="selected"';
                                                                                } ?>><?php echo $v['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <!-- Categories -->
                            <div class="space-y-3">
                                <label for="category"
                                    class="block text-sm font-semibold text-slate-700">Categories</label>
                                <?php $category_data = json_decode($product_data['category_id']); ?>
                                <select
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                    id="category" name="category[]" multiple>
                                    <?php foreach ($category as $k => $v): ?>
                                        <option value="<?php echo $v['id'] ?>" <?php if (in_array($v['id'], $category_data)) {
                                                                                    echo 'selected="selected"';
                                                                                } ?>><?php echo $v['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <!-- Attributes -->
                        <?php $attribute_id = json_decode($product_data['attribute_value_id']); ?>
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
                                                <option value="<?php echo $v2['id'] ?>" <?php if (in_array($v2['id'], $attribute_id)) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $v2['value'] ?>
                                                </option>
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
                        Back to Products
                    </a>
                    <button type="submit" id="updateProductBtn"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <span class="btn-text">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </span>
                        <span class="btn-loading hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Updating...
                        </span>
                    </button>
                </div>
            </form>
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#mainProductNav").addClass('active');
        $("#manageProductNav").addClass('active');

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

        // Quantity validation
        function checkQuantity() {
            const qty = parseInt($('#qty').val()) || 0;
            const lowQty = parseInt($('#low_quantity').val()) || 0;
            const highQty = parseInt($('#high_quantity').val()) || 0;

            if (qty <= lowQty && lowQty > 0) {
                $('#low-qty-alert').removeClass('hidden');
                $('#qty_status').text('Low stock!').addClass('text-orange-600');
            } else if (qty <= 0) {
                $('#low-qty-alert').addClass('hidden');
                $('#qty_status').text('Out of stock!').addClass('text-red-600');
            } else if (qty >= highQty && highQty > 0) {
                $('#low-qty-alert').addClass('hidden');
                $('#high-qty-alert').removeClass('hidden');
                $('#qty_status').text('High stock!').addClass('text-green-600');
            } else {
                $('#low-qty-alert').addClass('hidden');
                $('#high-qty-alert').addClass('hidden');
                $('#qty_status').text('').removeClass('text-orange-600 text-red-600 text-green-600');
            }
        }

        $('#qty, #low_quantity, #high_quantity').on('input', checkQuantity);
        checkQuantity();

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
            const submitBtn = $('#updateProductBtn');
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
</script>