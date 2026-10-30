 <div class="w-full max-w-none p-4 sm:p-6 lg:p-8">
     <!-- Content Header -->
     <div class="mb-8">
         <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
             <div>
                 <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manage Work Orders</h1>
                 <p class="text-slate-600 mt-1">Work Order request and status management</p>
             </div>
             <nav class="flex items-center space-x-2 text-sm text-slate-500">
                 <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
                     <i class="fas fa-home mr-1"></i>
                     Home
                 </a>
                 <i class="fas fa-chevron-right text-xs"></i>
                 <span class="text-slate-900 font-medium">Work Order</span>
             </nav>
         </div>
     </div>

     <!-- Flash Messages -->
     <div id="messages"></div>


     <!-- Action Bar -->
     <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
         <div class="flex items-center space-x-4">
             <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-slate-200">
                 <span class="text-sm text-slate-600">Total Orders: </span>
                 <span class="font-semibold text-slate-900" id="totalOrders"><?= $stats['total'] ?></span>
             </div>
             <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-slate-200">
                 <span class="text-sm text-slate-600">Pending Orders: </span>
                 <span class="font-semibold text-slate-900" id="pendingOrders"><?= $stats['pending'] ?></span>
             </div>
             <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-slate-200">
                 <span class="text-sm text-slate-600">In Progress: </span>
                 <span class="font-semibold text-slate-900" id="inProgress"><?= $stats['in progress'] ?></span>
             </div>
             <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-slate-200">
                 <span class="text-sm text-slate-600">Completed: </span>
                 <span class="font-semibold text-slate-900" id="CompletedOrders"><?= $stats['completed'] ?></span>
             </div>
             <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-slate-200">
                 <span class="text-sm text-slate-600">Closed: </span>
                 <span class="font-semibold text-slate-900" id="ClosedOrders"><?= $stats['closed'] ?></span>
             </div>
         </div>

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


 </div>

 <script type="text/javascript">
     var manageTable;
     var base_url = "<?php echo base_url(); ?>";

     // Modal show/hide functions
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

     $(document).ready(function() {

     });

     // Edit function
     function editFunc(id) {
         showModal('editModal');
         $.ajax({
             url: base_url + 'stores/fetchStoresDataById/' + id,
             type: 'post',
             dataType: 'json',
             success: function(response) {
                 if (response && response.name && response.active) {
                     $("#edit_store_id").val(id); // Set hidden input with store ID
                     $("#edit_store_name").val(response.name);
                     $("#edit_active").val(response.active);
                 } else {
                     $("#messages").html(
                         '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                         '<div class="flex items-center">' +
                         '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                         '<span class="font-medium">Failed to fetch store data</span>' +
                         '</div>' +
                         '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                         '<i class="fas fa-times"></i>' +
                         '</button>' +
                         '</div>');
                 }
             },
             error: function() {
                 $("#messages").html(
                     '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                     '<div class="flex items-center">' +
                     '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                     '<span class="font-medium">Failed to fetch store data</span>' +
                     '</div>' +
                     '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                     '<i class="fas fa-times"></i>' +
                     '</button>' +
                     '</div>');
             }
         });

         $("#updateForm").unbind('submit').bind('submit', function() {
             var form = $(this);
             $(".text-danger").remove();

             $.ajax({
                 url: form.attr('action') + '/' + id,
                 type: form.attr('method'),
                 data: form.serialize(),
                 dataType: 'json',
                 success: function(response) {
                     manageTable.ajax.reload(function(json) {
                         $('#totalStores').text(json.data.length); // Update total stores count
                     }, false);

                     if (response.success === true) {
                         $("#messages").html(
                             '<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                             '<div class="flex items-center">' +
                             '<i class="fas fa-check-circle text-emerald-500 mr-3"></i>' +
                             '<span class="font-medium">' + response.messages + '</span>' +
                             '</div>' +
                             '<button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                             '<i class="fas fa-times"></i>' +
                             '</button>' +
                             '</div>');
                         hideModal('editModal');
                         $("#updateForm .form-group").removeClass('has-error').removeClass(
                             'has-success');
                     } else {
                         if (response.messages instanceof Object) {
                             $.each(response.messages, function(index, value) {
                                 var id = $("#" + index);
                                 id.closest('.form-group')
                                     .removeClass('has-error')
                                     .removeClass('has-success')
                                     .addClass(value.length > 0 ? 'has-error' : 'has-success');
                                 id.after(value);
                             });
                         } else {
                             $("#editMessages").html(
                                 '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                                 '<div class="flex items-center">' +
                                 '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                                 '<span class="font-medium">' + response.messages + '</span>' +
                                 '</div>' +
                                 '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                                 '<i class="fas fa-times"></i>' +
                                 '</button>' +
                                 '</div>');
                         }
                     }
                 },
                 error: function() {
                     $("#editMessages").html(
                         '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                         '<div class="flex items-center">' +
                         '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                         '<span class="font-medium">An error occurred while updating the store</span>' +
                         '</div>' +
                         '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                         '<i class="fas fa-times"></i>' +
                         '</button>' +
                         '</div>');
                 }
             });
             return false;
         });
     }

     // Remove function
     function removeFunc(id) {
         $("#remove_store_id").val(id); // Set hidden input with store ID
         showModal('removeModal'); // Show remove modal immediately

         $("#removeForm").unbind('submit').bind('submit', function() {
             var form = $(this);
             $(".text-danger").remove();

             $.ajax({
                 url: form.attr('action'),
                 type: form.attr('method'),
                 data: {
                     store_id: $("#remove_store_id").val()
                 },
                 dataType: 'json',
                 success: function(response) {
                     manageTable.ajax.reload(function(json) {
                         $('#totalStores').text(json.data.length); // Update total stores count
                     }, false);

                     if (response.success === true) {
                         $("#messages").html(
                             '<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                             '<div class="flex items-center">' +
                             '<i class="fas fa-check-circle text-emerald-500 mr-3"></i>' +
                             '<span class="font-medium">' + response.messages + '</span>' +
                             '</div>' +
                             '<button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                             '<i class="fas fa-times"></i>' +
                             '</button>' +
                             '</div>');
                         hideModal('removeModal');
                     } else {
                         $("#messages").html(
                             '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                             '<div class="flex items-center">' +
                             '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                             '<span class="font-medium">' + response.messages + '</span>' +
                             '</div>' +
                             '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                             '<i class="fas fa-times"></i>' +
                             '</button>' +
                             '</div>');
                         hideModal('removeModal');
                     }
                 },
                 error: function() {
                     $("#messages").html(
                         '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                         '<div class="flex items-center">' +
                         '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                         '<span class="font-medium">An error occurred while removing the store</span>' +
                         '</div>' +
                         '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                         '<i class="fas fa-times"></i>' +
                         '</button>' +
                         '</div>');
                     hideModal('removeModal');
                 }
             });
             return false;
         });
     }
 </script>