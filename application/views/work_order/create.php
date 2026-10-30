<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <header class="w-full">
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Add Work Request</h1>
                    <p class="text-slate-600 mt-1">Create a work request to track maintenance, repairs.</p>
                </div>
                <nav class="flex items-center space-x-2 text-sm text-slate-500">
                    <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
                        <i class="fas fa-home mr-1"></i>
                        Home
                    </a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-slate-900 font-medium">Work Request</span>
                </nav>
            </div>
        </div>

        <!-- stage pagination -->
        <div class="max-w-4xl mx-auto flex justify-between items-center relative py-6">
            <?php
            $current_stage = 1;
            $stages = [
                1 => 'Request',
                2 => 'Approval',
                3 => 'Work Order',
                4 => 'Status',
                5 => 'Closed'
            ];
            ?>
            <div
                class="absolute top-11 w-full h-[1px] border-2 <?php echo $current_stage == 5 ? 'border-blue-500' : 'border-neutral-200' ?> z-10">
            </div>

            <?php foreach ($stages as $index => $stage_name): ?>
                <div class="flex flex-col gap-y-2 justify-center z-20">
                    <span
                        class="stage-circle w-10 h-10 text-white text-center p-2 rounded-full <?php echo $index < $current_stage ? 'bg-blue-600' : ($index == $current_stage ? 'bg-blue-500' : 'bg-neutral-300'); ?>">
                        <?php echo $index; ?>
                    </span>
                    <p class="text-xs text-neutral-500"><?php echo htmlspecialchars($stage_name); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </header>

    <div class="mt-6 bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden w-full">
        <form id="work-order-form" action="<?php echo base_url('work_order/store'); ?>" method="POST"
            enctype="multipart/form-data">
            <header>
                <div
                    class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-5 border-b border-slate-200 flex justify-between ">
                    <div class="flex items-center">
                        <div class="bg-blue-600 p-2 rounded-lg mr-3">
                            <span class="material-symbols-outlined text-white"> </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Add Work Order</h3>
                            <p class="text-slate-600 text-base">Delta Inc., 4 x 7.5MW WIS32 Diesel Power Plant</p>
                        </div>
                    </div>
                    <!-- <span name="request_no" class="font-semibold text-sm text-neutral-600">Request No:
                        <? ?></span> -->
                    <input type="hidden" readonly required name="request_no" value="<?php echo $request_no; ?>">

                    <div>
                        <label class="font-semibold text-sm text-neutral-600">Request No.</label>
                        <input type="text" value="<?php echo $request_no; ?>" readonly required
                            class="w-full border-gray-300 rounded p-2 bg-gray-100">
                    </div>
                </div>
            </header>
            <div class="w-full p-4" id="form-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-4">
                    <div>
                        <label class="block text-gray-700 py-2">Request Date</label>
                        <input type="date" required name="request_date" value="<?php echo date('d/m/y'); ?>"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            data-permission="requester">
                    </div>
                    <div>
                        <label class="block text-gray-700 py-2">Request Time</label>
                        <input type="time" required name="request_time" value="<?php echo date('h:i A'); ?>"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            data-permission="requester">
                    </div>
                    <div>
                        <label class="block text-gray-700 py-2">Priority Mode</label>
                        <div class="flex gap-x-4 items-center">
                            <button type="button" id="emergency-btn" class="bg-white rounded-md py-2 px-4 text-black"
                                data-permission="requester">Emergency</button>
                            <button type="button" id="normal-btn"
                                class="bg-green-500 border rounded-md py-2 px-4 text-white"
                                data-permission="requester">Normal</button>
                            <input value="Normal" type="hidden" name="priority_mode" id="priority_mode"
                                data-permission="requester">
                        </div>
                    </div>
                    <div class="border p-4 rounded-xl">
                        <label class="block text-gray-700 py-2">Maintenance</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 justify-self-start gap-2">

                            <span class="flex gap-2 items-center">
                                <input type="checkbox" name="type_of_project[]" value="improvement"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    data-permission="requester">
                                <p>IMPROVEMENT</p>
                            </span>
                            <span class="flex gap-2 items-center">
                                <input type="checkbox" name="type_of_project[]" value="safety"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    data-permission="requester">
                                <p>SAFETY</p>
                            </span>
                            <span class="flex gap-2 items-center">
                                <input type="checkbox" name="type_of_project[]" value="corrective"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    data-permission="requester">
                                <p>CORRECTIVE</p>
                            </span>
                            <span class="flex gap-2 items-center">
                                <input type="checkbox" name="type_of_project[]" value="preventive"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    data-permission="requester">
                                <p>PREVENTIVE</p>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 py-2">Request Title</label>
                    <input type="text" required name="request_title"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                        data-permission="requester">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 py-2">Description</label>
                    <textarea required name="description" maxlength="1000"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                        rows="4" data-permission="requester"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 py-2">Proposed Activities</label>
                    <textarea required name="proposed_activities" maxlength="1000"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                        rows="4" data-permission="requester"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 py-2">Important Usage</label>
                    <textarea type="text" required name="important_usage" maxlength="300"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                        data-permission="requester"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 py-2">Consequence of Inaction</label>
                    <textarea required name="consequence_of_inaction" maxlength="500"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                        rows="4" data-permission="requester"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 py-2">Safety Concerns</label>
                    <textarea required name="safety_concerns" maxlength="500"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                        rows="4" data-permission="requester"></textarea>
                </div>


                <div class="md:col-span-2">
                    <!-- Label -->
                    <label for="product-search" class="block text-gray-700 py-2">Supplies Needed</label>

                    <!-- Input Box -->
                    <input type="text" id="product-search"
                        class="w-full mb-2 px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                        placeholder="Search product name or SKU...">

                    <!-- Dynamic Dropdown -->
                    <select id="product-dropdown"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                        size="5" style="display: none;">
                        <!-- Options will be injected here -->
                    </select>
                    <div class="grid grid-cols-12 gap-4 mb-2">
                        <span class="col-span-2 px-4 text-gray-700">SKU</span>
                        <span class="col-span-3 px-4 text-gray-700">Item Name</span>
                        <span class="col-span-2 px-4 text-gray-700">Store Name</span>
                        <span class="col-span-3 px-4 text-gray-700">Description</span>
                        <span class="col-span-2 px-4 text-gray-700">Qty</span>
                    </div>

                    <div id="supplies-rows">

                    </div>

                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 py-2">Attachments</label>
                    <div id="attachments-preview" class="flex flex-wrap gap-4"></div>
                    <input type="file" multiple id="file-upload" class="hidden" accept="image/*"
                        data-permission="requester" name="attachments[]">
                    <button type="button" id="upload-btn" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg"
                        data-permission="requester">Upload Files</button>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 py-2">Requested by</label>
                    <select required name="requested_by"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm">
                        <option value="">-- Select User --</option>
                        <!-- <input type="text" name="requested_by" list="requester-list"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                data-permission="requester" placeholder="Enter or select name">
                            <datalist id="requester-list"> -->
                        <?php foreach ($requesters as $u): ?>
                            <option value="<?php echo $u->id; ?>"><?php echo $u->firstname . ' ' . $u->lastname; ?></option>
                        <?php endforeach; ?>
                        <!-- </datalist> -->
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 py-2">Checked by</label>
                    <select required name="checked_by"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm">
                        <option value="">-- Select User --</option>
                        <?php foreach ($checkers as $u): ?>
                            <option value="<?php echo $u->id; ?>"><?php echo $u->firstname . ' ' . $u->lastname; ?></option>
                        <?php endforeach; ?>
                        <!-- </datalist> -->
                    </select>
                </div>


                <div class="md:col-span-2 flex gap-x-4 justify-end mt-4">
                    <button type="button" class="bg-white border border-slate-300 text-black px-4 py-2 rounded-lg">
                        <i class="fa-solid fa-floppy-disk mr-2 text-slate-300"></i>Save as Template
                    </button>
                    <button type="button" class="bg-white border border-neutral-300 text-black px-4 py-2 rounded-lg">
                        Save as Draft
                    </button>
                    <button type="submit" id="submit-form" class="bg-green-500 text-white px-4 py-2 rounded-lg">
                        <i class="fa-solid fa-paper-plane mr-2"></i>Submit Request
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    if (window.serverErrors && Array.isArray(window.serverErrors)) {
        const combined = window.serverErrors.join('\n');
        showErrorToast(combined);
    }
    $(document).ready(function() {

        const checkboxes = document.querySelectorAll('input[name="type_of_project[]"]');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                if (cb.checked) {
                    checkboxes.forEach(other => {
                        if (other !== cb) other.checked = false;
                    });
                }
            });
        });

        function showErrorToast(message) {
            const toast = document.getElementById('error-toast');
            const msg = document.getElementById('error-toast-message');
            msg.textContent = message || 'An unexpected error occurred.';
            toast.classList.remove('hidden');
        }

        function closeErrorToast() {
            // document.getElementById('error-toast').classList.add('hidden');
            console.log(1);
        }
        // Simulated user permissions (replace with actual backend data)
        const userPermissions = <?php echo json_encode($user_permission); ?>;

        // Reusable function to control element accessibility based on permission
        function controlElementAccess(element, permission) {
            if (!userPermissions.includes(permission)) {
                $(element).prop('disabled', true);
                if ($(element).val()) {
                    $(element).addClass('bg-neutral-100');
                }
                if ($(element).is('button') || $(element).is('input[type="text"]') || $(element).is('input') || $(
                        element).is('textarea') ||
                    $(element).is('input[type="date"]') || $(element).is('input[type="time"]')) {
                    $(element).addClass('opacity-50 cursor-not-allowed');
                }
            } else {
                $(element).prop('disabled', false);
                if ($(element).is('button') || $(element).is('input[type="text"]') || $(element).is('input') || $(
                        element).is('textarea') ||
                    $(element).is('input[type="date"]') || $(element).is('input[type="time"]')) {
                    $(element).removeClass('opacity-50 cursor-not-allowed');
                }
            }
        }

        // Apply permissions to all elements with data-permission attribute
        $('[data-permission]').each(function() {
            const permission = $(this).data('permission');
            controlElementAccess(this, permission);
        });

        // Priority Mode Toggle
        $('#emergency-btn').click(function() {
            if (!$(this).prop('disabled')) {
                $(this).addClass('bg-red-500 text-white').removeClass('bg-white border text-black');
                $('#normal-btn').addClass('bg-white border text-black').removeClass(
                    'bg-green-500 text-white');
                $('#priority_mode').val('Emergency');
            }
        });
        $('#normal-btn').click(function() {
            if (!$(this).prop('disabled')) {
                $(this).addClass('bg-green-500 text-white').removeClass('bg-white border text-black');
                $('#emergency-btn').addClass('bg-white border text-black').removeClass(
                    'bg-red-500 text-white');
                $('#priority_mode').val('Normal');
            }
        });

        // // Add/Remove Supplies
        // $('#add-supply').click(function() {
        //     if (!$(this).prop('disabled')) {
        //         var newRow = $('.supply-row:first').clone();
        //         newRow.find('input').val('');
        //         newRow.find('.remove-supply').removeClass('hidden');
        //         $('#supplies-rows').append(newRow);
        //         if ($('#supplies-rows .supply-row').length > 1) {
        //             $('#supplies-rows .remove-supply').removeClass('hidden');
        //         }
        //         newRow.find('[data-permission]').each(function() {
        //             const permission = $(this).data('permission');
        //             controlElementAccess(this, permission);
        //         });
        //     }
        // });
        // $(document).on('click', '.remove-supply', function() {
        //     if (!$(this).prop('disabled')) {
        //         $(this).closest('.supply-row').remove();
        //         if ($('#supplies-rows .supply-row').length <= 1) {
        //             $('#supplies-rows .remove-supply').addClass('hidden');
        //         }
        //     }
        // });

        // Upload Files and Remove Images
        $('#upload-btn').click(function() {
            if (!$(this).prop('disabled')) {
                $('#file-upload').click();
            }
        });
        $('#file-upload').change(function() {
            if (!$(this).prop('disabled')) {
                var files = this.files;
                if (files.length > 5) {
                    showErrorToast("Maximum of 5 Attachments only.");
                    return;
                }
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (file.type.startsWith('image/')) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var imgContainer = $(
                                '<div class="relative w-24 h-24 bg-gray-300 flex items-center justify-center rounded-lg overflow-hidden mr-2 mb-2"><img src="' +
                                e.target.result +
                                '" class="w-full h-full object-cover"><button type="button" class="remove-image absolute top-1 right-1 text-red-500 bg-white rounded-full w-6 h-6 flex items-center justify-center" data-permission="requester"><i class="fas fa-times"></i></button></div>'
                            );
                            $('#attachments-preview').append(imgContainer);
                            controlElementAccess(imgContainer.find('.remove-image'), 'requester');
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        });
        $(document).on('click', '.remove-image', function() {
            if (!$(this).prop('disabled')) {
                $(this).closest('div').remove();
            }
        });

        // Add/Remove Team Members with Dynamic Indexing
        let teamIndex = 0;
        $('#add-team').click(function() {
            if (!$(this).prop('disabled')) {
                teamIndex++;
                var newRow = $('.team-row:first').clone();
                newRow.find('input').attr('name', 'teamMembers[' + teamIndex + ']').val('').attr(
                    'placeholder', 'Team Member ' + (teamIndex + 1));
                newRow.find('.remove-team').removeClass('hidden');
                $('#team-rows').append(newRow);
                newRow.find('[data-permission]').each(function() {
                    const permission = $(this).data('permission');
                    controlElementAccess(this, permission);
                });
            }
        });
        $(document).on('click', '.remove-team', function() {
            if (!$(this).prop('disabled')) {
                $(this).closest('.team-row').remove();
                $('#team-rows .team-row').each(function(index) {
                    $(this).find('input').attr('name', 'teamMembers[' + index + ']').attr(
                        'placeholder', 'Team Member ' + (index + 1));
                    controlElementAccess($(this).find('input'), 'approver');
                    controlElementAccess($(this).find('.remove-team'), 'approver');
                });
                teamIndex = $('#team-rows .team-row').length - 1;
            }
        });

        // Form Submission
        $('#work-order-form').on('submit', function(e) {
            e.preventDefault();
            const form = document.getElementById('work-order-form');

            const formData = new FormData(form);

            const requiredFields = [
                'request_no', 'request_date', 'request_time', 'request_title', 'description',
                'proposed_activities',
                'important_usage', 'consequence_of_inaction', 'safety_concerns', 'requested_by'
            ];


            let isValid = true;

            requiredFields.forEach(name => {
                let field = document.querySelector(`[name="${name}"]`);
                if (field && field.value.trim() === '') {
                    showErrorToast(
                        `Missing ${name.replace(/_/g, ' ').toLowerCase() .replace(/\b\w/g, char => char.toUpperCase())}`
                    );
                    return;
                }
            });
            const checkboxes = document.querySelectorAll('input[name="type_of_project[]"]:checked');
            // const errorMessage = document.getElementById('error-message');

            if (checkboxes.length === 0) {
                // event.preventDefault();
                isValid = false;
                showErrorToast("Missing Type of Project.");
                return;
            }

            const supplies = [];

            document.querySelectorAll('.supply-row').forEach((row, index) => {
                const itemInput = row.querySelector('[name="supplies[][item_id]"]');
                const qtyInput = row.querySelector('[name="supplies[][quantity]"]');

                if (!itemInput || !qtyInput) {
                    console.warn(`Missing inputs in row ${index}`);
                    return;
                }

                const itemId = itemInput.value.trim();
                const quantity = qtyInput.value.trim();

                if (itemId && quantity) {
                    supplies.push({
                        item_id: itemId,
                        quantity: quantity
                    });
                }
            });

            formData.append('supplies', JSON.stringify(supplies));

            if (!isValid) {
                showErrorToast("Please fill out all required fields.");
            } else {

                // this.submit();


                fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            showSuccessToast("Work order submitted successfully!");

                            setTimeout(() => {
                                window.location.href =
                                    "<?php echo base_url('workorder/'); ?>"; // ← your target page
                            }, 3000);
                        } else {
                            showErrorToast("Submission failed. Try again later.");
                            console.error(data.errors); // Your custom error renderer
                        }
                    })
                    .catch(err => console.error('AJAX error:', err));

            }
        });


        const products = [
            <?php foreach ($products as $product): ?> {
                    id: "<?= $product['id'] ?>",
                    name: "<?= $product['name'] ?>",
                    sku: "<?= $product['sku'] ?>",
                    store: "<?= $product['store'] ?>",
                    description: "<?= $product['description'] ?>",
                    qty: <?= $product['qty'] ?>
                },
            <?php endforeach; ?>
        ];
        // console.log(products);

        const searchInput = document.getElementById('product-search');
        const dropdown = document.getElementById('product-dropdown');
        const selectedLabel = document.getElementById('selected-product');

        // Filter and show matching products

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            dropdown.innerHTML = ''; // Clear previous options

            const matches = products.filter(p =>
                p.name.toLowerCase().includes(query) || p.sku.toLowerCase().includes(query)
            );

            if (matches.length > 0 && query !== '') {
                dropdown.style.display = 'block';
                matches.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.id;
                    option.textContent = `${p.name} (${p.sku})`;
                    option.dataset.name = p.name;
                    option.dataset.sku = p.sku;
                    option.dataset.store = p.store;
                    option.dataset.description = p.description;
                    option.dataset.qty = parseInt(p.qty);

                    dropdown.appendChild(option);
                });
            } else {
                dropdown.style.display = 'none';
            }
        });

        // Show selected product label
        dropdown.addEventListener('change', function() {

            let itemId = this.value;
            let itemName = this.options[this.selectedIndex].getAttribute('data-name');
            let itemSku = this.options[this.selectedIndex].getAttribute('data-sku');
            let itemStore = this.options[this.selectedIndex].getAttribute('data-store');
            let itemDescription = this.options[this.selectedIndex].getAttribute('data-description') || '';
            let maxQty = this.options[this.selectedIndex].getAttribute('data-qty');
            // console.log(maxQty);
            if (itemId) {
                let container = document.getElementById('supplies-rows');
                let item = document.createElement('div');
                item.id = `row-${Math.random().toString(36).substr(2, 9)}`; // Ensures unique ID


                item.className = "supply-row grid grid-cols-12 gap-4 mb-2";
                item.innerHTML = `
                        <input type="hidden" name="supplies[][item_id]" value="${itemId}" required>

                        <input id="${itemId}SKU" type="text" readonly placeholder="Item Number"
                            class="col-span-2 px-4 py-3 border border-slate-300 rounded-xl bg-white shadow-sm"
                            data-permission="requester" value="${itemSku}">

                        <input id="${itemId}itemName" type="text" readonly value="${itemName}" placeholder="Item Name"
                            class="col-span-3 px-4 py-3 border border-slate-300 rounded-xl bg-white shadow-sm"
                            data-permission="requester">

                        <input id="${itemId}itemStore" type="text" readonly value="${itemStore}" placeholder="Item Store"
                            class="col-span-2 px-4 py-3 border border-slate-300 rounded-xl bg-white shadow-sm"
                            data-permission="requester">

                        <textarea readonly name="description"
                            class="col-span-3 px-4 py-3 border border-slate-300 rounded-xl bg-white shadow-sm resize-y"
                            rows="1">${itemDescription}</textarea>

                        <div class="col-span-2 flex items-center">
                            <input id="${itemId}qty" required type="number" name="supplies[][quantity]" placeholder="Qty"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl bg-white shadow-sm"
                            data-permission="requester" min="1" max="${maxQty}">
                            <button type="button" class="remove-supply ml-2 text-red-500">
                            <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        `;


                container.appendChild(item);


            }



        });
        // Attach this once, ideally after DOM is ready
        document.getElementById('supplies-rows').addEventListener('click', function(e) {
            if (e.target.closest('.remove-supply')) {
                const row = e.target.closest('.supply-row');
                console.log('Clicked:', e.target);
                if (row) row.remove();
            }
        });

    });
    <?php if ($this->session->flashdata('errors')): ?>

        window.serverErrors = <?php echo json_encode($this->session->flashdata('errors')); ?>;
        if (window.serverErrors && Array.isArray(window.serverErrors)) {
            const combined = window.serverErrors.join('\n');
            showErrorToast(combined);
        }
    <?php endif; ?>


    function showErrorToast(message) {
        const toast = document.getElementById('error-toast');
        const msg = document.getElementById('error-toast-message');
        msg.textContent = message || 'An unexpected error occurred.';
        toast.classList.remove('hidden');
    }

    function closeErrorToast() {
        document.getElementById('error-toast').classList.add('hidden');
    }


    function showSuccessToast(message) {
        const toast = document.getElementById('success-toast');
        const msg = document.getElementById('success-toast-message');
        msg.textContent = message || 'Success!';
        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 4000);
    }

    function closeSuccessToast() {
        document.getElementById('success-toast').classList.add('hidden');
    }
</script>



<!-- Error Toast -->
<div id="error-toast" class="fixed bottom-4 right-4 z-50 hidden">
    <div class="bg-red-600 bg-opacity-90 text-white text-sm rounded shadow-lg px-4 py-3 max-w-xs w-full space-y-1">
        <div class="flex justify-between items-start">
            <h2 class="text-base font-semibold">Error</h2>
            <button onclick="closeErrorToast()" class="text-white hover:text-gray-200 font-bold">&times;</button>
        </div>
        <p id="error-toast-message" class="text-sm">
            Something went wrong. Please try again.
        </p>
    </div>
</div>


<!-- Error Toast -->
<div id="error-toast" class="fixed bottom-4 right-4 z-50 hidden">
    <div class="bg-red-600 bg-opacity-90 text-white text-sm rounded shadow-lg px-4 py-3 max-w-xs w-full space-y-1">
        <div class="flex justify-between items-start">
            <h2 class="text-base font-semibold">Error</h2>
            <button onclick="closeErrorToast()" class="text-white hover:text-gray-200 font-bold">&times;</button>
        </div>
        <p id="error-toast-message" class="text-sm">
            Something went wrong. Please try again.
        </p>
    </div>
</div>


<!-- Success Toast -->
<div id="success-toast" class="fixed bottom-6 right-6 z-50 hidden">
    <div
        class="bg-green-600 bg-opacity-95 text-white text-base rounded-lg shadow-2xl px-6 py-4 max-w-md w-full space-y-2 animate-slide-in">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <h2 class="text-lg font-bold">Success</h2>
            </div>
            <button onclick="closeSuccessToast()"
                class="text-white hover:text-gray-200 font-bold text-xl">&times;</button>
        </div>
        <p id="success-toast-message" class="text-base">
            Your action was completed successfully!
        </p>
    </div>
</div>