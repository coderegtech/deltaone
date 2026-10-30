<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <header class="w-full">
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Edit Work Request</h1>
                    <p class="text-slate-600 mt-1">Update an existing work order request for maintenance or repairs.</p>
                </div>
                <nav class="flex items-center space-x-2 text-sm text-slate-500">
                    <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
                        <i class="fas fa-home mr-1"></i>
                        Home
                    </a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-slate-900 font-medium">Edit Work Request</span>
                </nav>
            </div>
        </div>

        <!-- Flash Messages -->
        <div id="messages"></div>

        <!-- Stage Pagination -->
        <div class="max-w-4xl mx-auto flex justify-between items-center relative py-6">
            <?php
            $current_stage = isset($current_stage) ? $current_stage : 1;
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
                    <p class="text-xs text-neutral-500"><?php echo $stage_name; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </header>

    <div class="mt-6 bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden w-full">
        <form id="work-order-form" action="<?php echo base_url('workorder/update/' . ($id ?? '')); ?>" method="post"
            enctype="multipart/form-data">
            <header>
                <div
                    class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-5 border-b border-slate-200 flex justify-between flex justify-between ">
                    <div class="flex items-center">
                        <div class="bg-blue-600 p-2 rounded-lg mr-3">
                            <span class="material-symbols-outlined text-white"> </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Edit Work Order</h3>
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

                <!-- stage 1 -->
                <!-- requester -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-4">
                        <div>
                            <label class="block text-gray-700 py-2">Request Date</label>
                            <input type="date" name="request_date"
                                value="<?php echo htmlspecialchars($request_date ?? date('Y-m-d')); ?>"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                data-permission="requester">
                        </div>
                        <div>
                            <label class="block text-gray-700 py-2">Request Time</label>
                            <input type="time" name="request_time"
                                value="<?php echo htmlspecialchars($request_time ?? date('H:i')); ?>"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                data-permission="requester">
                        </div>
                        <div>
                            <label class="block text-gray-700 py-2">Priority Mode</label>
                            <div class="flex gap-x-4 items-center">
                                <button type="button" id="emergency-btn"
                                    class="rounded-md py-2 px-4 text-white <?php echo ($priority_mode ?? '') == 'Emergency' ? 'bg-red-500' : 'bg-white border text-black'; ?>"
                                    data-permission="requester">Emergency</button>
                                <button type="button" id="normal-btn"
                                    class="rounded-md py-2 px-4 <?php echo ($priority_mode ?? '') == 'Normal' ? 'bg-green-500 text-white' : 'bg-white border text-black'; ?>"
                                    data-permission="requester">Normal</button>
                                <input type="hidden" name="priority_mode" id="priority_mode"
                                    value="<?php echo htmlspecialchars($priority_mode ?? ''); ?>"
                                    data-permission="requester">
                            </div>
                        </div>
                        <div class="border p-4 rounded-xl">
                            <label class="block text-gray-700 py-2">Maintenance</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 justify-self-start gap-2">
                                <?php
                                $project_types = explode(',', $type_of_project ?? '');
                                ?>
                                <span class="flex gap-2 items-center">
                                    <input type="checkbox" name="type_of_project" value="improvement"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        data-permission="requester"
                                        <?php echo in_array('improvement', $project_types) ? 'checked' : ''; ?>>
                                    <p>IMPROVEMENT</p>
                                </span>
                                <span class="flex gap-2 items-center">
                                    <input type="checkbox" name="type_of_project" value="safety"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        data-permission="requester"
                                        <?php echo in_array('safety', $project_types) ? 'checked' : ''; ?>>
                                    <p>SAFETY</p>
                                </span>
                                <span class="flex gap-2 items-center">
                                    <input type="checkbox" name="type_of_project" value="corrective"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        data-permission="requester"
                                        <?php echo in_array('corrective', $project_types) ? 'checked' : ''; ?>>
                                    <p>CORRECTIVE</p>
                                </span>
                                <span class="flex gap-2 items-center">
                                    <input type="checkbox" name="type_of_project" value="preventive"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        data-permission="requester"
                                        <?php echo in_array('preventive', $project_types) ? 'checked' : ''; ?>>
                                    <p>PREVENTIVE</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Request Title</label>
                        <input type="text" name="request_title"
                            value="<?php echo htmlspecialchars($request_title ?? ''); ?>"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            data-permission="requester">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Description</label>
                        <textarea name="description"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            rows="4"
                            data-permission="requester"><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Proposed Activities</label>
                        <textarea name="proposed_activities"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            rows="4"
                            data-permission="requester"><?php echo htmlspecialchars($proposed_activities ?? ''); ?></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Important Usage</label>
                        <input type="text" name="important_usage"
                            value="<?php echo htmlspecialchars($important_usage ?? ''); ?>"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            data-permission="requester">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Consequence of Inaction</label>
                        <input type="text" name="consequence_of_inaction"
                            value="<?php echo htmlspecialchars($consequence_of_inaction ?? ''); ?>"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            data-permission="requester">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Safety Concerns</label>
                        <textarea name="safety_concerns"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            rows="4"
                            data-permission="requester"><?php echo htmlspecialchars($safety_concerns ?? ''); ?></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Supplies Needed</label>
                        <div id="supplies-rows">
                            <?php
                            $supplies = $supplies ?? array([]);
                            foreach ($supplies as $index => $supply):
                            ?>
                                <div class="supply-row grid grid-cols-1 md:grid-cols-5 gap-4 mb-2">
                                    <input type="text" placeholder="Item Number"
                                        value="<?php echo htmlspecialchars($supply->item_number ?? ''); ?>"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        name="supplies[<?php echo $index; ?>][item_number]" data-permission="requester">
                                    <input type="text" placeholder="Part Number"
                                        value="<?php echo htmlspecialchars($supply->part_number ?? ''); ?>"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        name="supplies[<?php echo $index; ?>][part_number]" data-permission="requester">
                                    <input type="text" placeholder="Item Name"
                                        value="<?php echo htmlspecialchars($supply->item_name ?? ''); ?>"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        name="supplies[<?php echo $index; ?>][item_name]" data-permission="requester">
                                    <input type="number" placeholder="Qty"
                                        value="<?php echo htmlspecialchars($supply->quantity ?? ''); ?>"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        name="supplies[<?php echo $index; ?>][quantity]" data-permission="requester">
                                    <div class="flex items-center">
                                        <button type="button"
                                            class="description-btn inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl"
                                            data-index="<?php echo $index; ?>" data-permission="requester">
                                            <i class="fas fa-plus mr-2"></i>
                                            Description
                                        </button>
                                        <button type="button"
                                            class="remove-supply ml-2 text-red-500 <?php echo $index == 0 ? 'hidden' : ''; ?>"
                                            data-permission="requester">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <input type="hidden" name="supplies[<?php echo $index; ?>][description]"
                                            value="<?php echo htmlspecialchars($supply->description ?? ''); ?>"
                                            class="supply-description" data-permission="requester">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-supply" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg"
                            data-permission="requester">Add Item</button>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Attachments</label>
                        <div id="attachments-preview" class="flex flex-wrap gap-4">
                            <?php
                            $attachments = $workorder_data['attachments'] ?? [];
                            foreach ($attachments as $attachment):
                            ?>
                                <div
                                    class="relative w-24 h-24 bg-gray-300 flex items-center justify-center rounded-lg overflow-hidden mr-2 mb-2">
                                    <img src="<?php echo htmlspecialchars($attachment['url'] ?? ''); ?>"
                                        class="w-full h-full object-cover">
                                    <button type="button"
                                        class="remove-image absolute top-1 right-1 text-red-500 bg-white rounded-full w-6 h-6 flex items-center justify-center"
                                        data-permission="requester"><i class="fas fa-times"></i></button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <input type="file" multiple id="file-upload" class="hidden" accept="image/*"
                            data-permission="requester">
                        <button type="button" id="upload-btn" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg"
                            data-permission="requester">Upload Files</button>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Requested by</label>
                        <select name="requested_by"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            data-permission="requester">
                            <option value="">Select name</option>
                            <?php foreach ($list_of_performers as $k => $us): ?>
                                <option value="<?php echo htmlspecialchars($us->firstname); ?>"
                                    <?php echo ($requested_by ?? '') == $us->firstname ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($us->firstname); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <!-- end requester -->

                <!-- checker -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Checked by</label>
                        <select name="checked_by"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            data-permission="checker">
                            <option value="">Select name</option>
                            <?php foreach ($list_of_performers as $k => $us): ?>
                                <option value="<?php echo htmlspecialchars($us->firstname); ?>"
                                    <?php echo ($checked_by ?? '') == $us->firstname ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($us->firstname); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <!-- end checker -->
                <!-- end stage 1 -->


                <!-- stage 2 -->
                <!-- endorser -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="border border-slate-200 p-2 my-3 rounded-xl">
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 py-2">Endorsed by</label>
                            <select name="endorsed_by"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                data-permission="endorser">
                                <option value="">Select name</option>
                                <?php foreach ($list_of_performers as $k => $us): ?>
                                    <option value="<?php echo htmlspecialchars($us->firstname); ?>"
                                        <?php echo ($endorsed_by ?? '') == $us->firstname ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($us->firstname); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 py-2">Add Comment</label>
                            <textarea name="endorser_comment"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                rows="4"
                                data-permission="endorser"><?php echo htmlspecialchars($endorser_comment ?? ''); ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- end endorser -->

                <!-- approver -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Approved by</label>
                        <select name="approved_by"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            data-permission="approver">
                            <option value="">Select name</option>
                            <?php foreach ($list_of_performers as $k => $us): ?>
                                <option value="<?php echo htmlspecialchars($us->firstname); ?>"
                                    <?php echo ($approved_by ?? '') == $us->firstname ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($us->firstname); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <!-- end approver -->


                <!-- receiver -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="border border-slate-200 p-2 my-3 rounded-xl">
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 py-2">Received by</label>
                            <select name="received_by"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                data-permission="receiver">
                                <option value="">Select name</option>
                                <?php foreach ($list_of_performers as $k => $us): ?>
                                    <option value="<?php echo htmlspecialchars($us->firstname); ?>"
                                        <?php echo ($received_by ?? '') == $us->firstname ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($us->firstname); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 py-2">Add Comment</label>
                            <textarea name="receiver_comment"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                rows="4"
                                data-permission="receiver"><?php echo htmlspecialchars($receiver_comment ?? ''); ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- end receiver -->

                <!-- supervisor -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Maintenance Closure</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <select name="shift_supervisor_before"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                data-permission="supervisor">
                                <option value="">Shift Supervisor (Before)</option>
                                <?php foreach ($list_of_performers as $k => $us): ?>
                                    <option value="<?php echo htmlspecialchars($us->firstname); ?>"
                                        <?php echo ($shift_supervisor_before ?? '') == $us->firstname ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($us->firstname); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="date" name="before_date"
                                value="<?php echo htmlspecialchars($before_date ?? ''); ?>"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                data-permission="supervisor">
                            <select name="shift_supervisor_after"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                data-permission="supervisor">
                                <option value="">Shift Supervisor (After)</option>
                                <?php foreach ($list_of_performers as $k => $us): ?>
                                    <option value="<?php echo htmlspecialchars($us->firstname); ?>"
                                        <?php echo ($shift_supervisor_after ?? '') == $us->firstname ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($us->firstname); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="date" name="after_date" value="<?php echo htmlspecialchars($after_date ?? ''); ?>"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                data-permission="supervisor">
                        </div>
                    </div>
                <?php endif; ?>
                <!-- end supervisor -->
                <!-- end stage 2 -->


                <!-- stage 3 -->

                <!-- work order status -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Work Order Status</label>
                        <select name="work_order_status" data-permission="requester"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm">
                            <option value="Select status">Select status</option>
                            <option value="Successful"
                                <?php echo ($work_order_status ?? '') == 'Successful' ? 'selected' : ''; ?>>
                                Successful</option>
                            <option value="Successful with issue"
                                <?php echo ($work_order_status ?? '') == 'Successful with issue' ? 'selected' : ''; ?>>
                                Successful with issue</option>
                            <option value="Unsuccessful"
                                <?php echo ($work_order_status ?? '') == 'Unsuccessful' ? 'selected' : ''; ?>>
                                Unsuccessful</option>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- team members -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Performed by</label>
                        <div id="team-rows" class="space-y-2">
                            <?php
                            $team_members = $team_members ?? array([]);
                            foreach ($team_members as $index => $member):
                            ?>
                                <div class="team-row flex items-center">
                                    <input type="text" name="team_members[<?php echo $index; ?>][name]"
                                        placeholder="Team Member <?php echo $index + 1; ?>"
                                        value="<?php echo htmlspecialchars($member->name ?? ''); ?>"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                                        data-permission="requester">
                                    <button type="button"
                                        class="remove-team ml-2 text-red-500 <?php echo $index == 0 ? 'hidden' : ''; ?>"
                                        data-permission="requester"><i class="fas fa-trash"></i></button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-team" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg"
                            data-permission="requester">Add Team Member</button>
                    </div>
                <?php endif; ?>

                <!-- activity remarks -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Activity Remarks</label>
                        <textarea name="activity_remarks"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            rows="4"
                            data-permission="requester"><?php echo htmlspecialchars($activity_remarks ?? ''); ?></textarea>
                    </div>
                <?php endif; ?>
                <!-- end stage 3 -->

                <!-- stage 4 -->

                <!-- closure notes -->
                <?php if (in_array('requester', $user_permission) || in_array('checker', $user_permission) || in_array('endorser', $user_permission) || in_array('receiver', $user_permission) || in_array('supervisor', $user_permission) || in_array('approver', $user_permission)): ?>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 py-2">Closure Notes</label>
                        <textarea name="closure_notes"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                            rows="4"
                            data-permission="approver"><?php echo htmlspecialchars($closure_notes ?? ''); ?></textarea>
                    </div>
                <?php endif; ?>
                <!-- end stage  -->


                <div class="md:col-span-2 flex justify-end mt-4">
                    <button type="submit" id="submit-form"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <span>Update</span>
                        <i class="fas fa-spinner fa-spin ml-2 hidden" id="submit-loading"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal for Supply Description -->
    <div id="supply-description-modal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Supply Description</h3>
                <button type="button" id="close-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div>
                <label class="block text-gray-700 py-2">Description</label>
                <textarea id="supply-description"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm"
                    rows="4" data-permission="requester"></textarea>
            </div>
            <div class="flex justify-end mt-4">
                <button type="button" id="save-description" class="bg-blue-500 text-white px-4 py-2 rounded-lg"
                    data-permission="requester">Save</button>
            </div>
        </div>
    </div>
</div>

<style>
    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7' /%3E%3C/svg%3E");
        background-position: right 1rem center;
        background-repeat: no-repeat;
        background-size: 1em;
    }

    .hidden {
        display: none !important;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Simulated user permissions (replace with actual backend data)
        const userPermissions = <?php echo json_encode($user_permission); ?>;

        // Reusable function to control element accessibility based on permission
        function controlElementAccess(element, permission) {
            if (!userPermissions.includes(permission)) {
                $(element).prop('disabled', true);
                if ($(element).val()) {
                    $(element).addClass('bg-neutral-100');
                }
                if ($(element).is('button') || $(element).is('input[type="text"]') || $(element).is('input') ||
                    $(element).is('textarea') || $(element).is('input[type="date"]') ||
                    $(element).is('input[type="time"]') || $(element).is('select')) {
                    $(element).addClass('opacity-50 cursor-not-allowed');
                }
            } else {
                $(element).prop('disabled', false);
                if ($(element).is('button') || $(element).is('input[type="text"]') || $(element).is('input') ||
                    $(element).is('textarea') || $(element).is('input[type="date"]') ||
                    $(element).is('input[type="time"]') || $(element).is('select')) {
                    $(element).removeClass('opacity-50 cursor-not-allowed');
                }
            }
        }

        // Apply permissions to all elements with data-permission attribute
        $('[data-permission]').each(function() {
            const permission = $(this).data('permission');
            controlElementAccess(this, permission);
        });

        // Ensure submit button is in initial state
        $('#submit-form').prop('disabled', false);
        $('#submit-loading').addClass('hidden');

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

        // Add/Remove Supplies
        let supplyIndex = <?php echo count($supplies ?? []) - 1; ?>;
        $('#add-supply').click(function() {
            if (!$(this).prop('disabled')) {
                supplyIndex++;
                var newRow = $('.supply-row:first').clone();
                newRow.find('input').val('');
                newRow.find('.remove-supply').removeClass('hidden');
                newRow.find('input').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        $(this).attr('name', name.replace(/supplies\[\d+\]/,
                            `supplies[${supplyIndex}]`));
                    }
                });
                newRow.find('.description-btn').attr('data-index', supplyIndex);
                $('#supplies-rows').append(newRow);
                if ($('#supplies-rows .supply-row').length > 1) {
                    $('#supplies-rows .remove-supply').removeClass('hidden');
                }
                newRow.find('[data-permission]').each(function() {
                    const permission = $(this).data('permission');
                    controlElementAccess(this, permission);
                });
            }
        });

        $(document).on('click', '.remove-supply', function() {
            if (!$(this).prop('disabled')) {
                $(this).closest('.supply-row').remove();
                if ($('#supplies-rows .supply-row').length <= 1) {
                    $('#supplies-rows .remove-supply').addClass('hidden');
                }
                $('#supplies-rows .supply-row').each(function(index) {
                    $(this).find('input').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            $(this).attr('name', name.replace(/supplies\[\d+\]/,
                                `supplies[${index}]`));
                        }
                    });
                    $(this).find('.description-btn').attr('data-index', index);
                });
                supplyIndex = $('#supplies-rows .supply-row').length - 1;
            }
        });

        // Supply Description Modal
        let currentSupplyIndex = 0;
        $(document).on('click', '.description-btn', function() {
            if (!$(this).prop('disabled')) {
                currentSupplyIndex = $(this).data('index');
                const description = $(`input[name="supplies[${currentSupplyIndex}][description]"]`).val();
                $('#supply-description').val(description);
                $('#supply-description-modal').removeClass('hidden');
                controlElementAccess('#supply-description', 'requester');
                controlElementAccess('#save-description', 'requester');
            }
        });

        $('#close-modal').click(function() {
            $('#supply-description-modal').addClass('hidden');
            $('#supply-description').val('');
        });

        $('#save-description').click(function() {
            if (!$(this).prop('disabled')) {
                const description = $('#supply-description').val();
                $(`input[name="supplies[${currentSupplyIndex}][description]"]`).val(description);
                $('#supply-description-modal').addClass('hidden');
                $('#supply-description').val('');
            }
        });

        // Upload Files and Remove Images
        let uploadedFiles = [];
        const maxFiles = 5;
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        $('#upload-btn').click(function() {
            if (!$(this).prop('disabled')) {
                $('#file-upload').click();
            }
        });

        $('#file-upload').change(function() {
            if (!$(this).prop('disabled')) {
                var files = this.files;
                var errors = [];
                var validFiles = uploadedFiles.filter(file => file !== null);

                if (validFiles.length + files.length > maxFiles) {
                    errors.push(`Maximum ${maxFiles} attachments allowed.`);
                } else {
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        if (!allowedTypes.includes(file.type)) {
                            errors.push(
                                `Invalid file type for "${file.name}". Allowed types: JPEG, PNG, JPG.`);
                            continue;
                        }
                        if (file.size > maxSize) {
                            errors.push(`File "${file.name}" is too large. Maximum size: 5MB.`);
                            continue;
                        }
                        var fileIndex = uploadedFiles.length;
                        uploadedFiles.push({
                            id: fileIndex + 1,
                            name: file.name,
                            type: file.type,
                            size: file.size,
                            file: file
                        });
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var imgContainer = $(
                                '<div class="attachment-container relative w-24 h-24 bg-gray-300 flex items-center justify-center rounded-lg overflow-hidden mr-2 mb-2" data-index="' +
                                fileIndex + '">' +
                                '<img src="' + e.target.result +
                                '" class="w-full h-full object-cover">' +
                                '<button type="button" class="remove-image absolute top-1 right-1 text-red-500 bg-white rounded-full w-6 h-6 flex items-center justify-center" data-permission="requester">' +
                                '<i class="fas fa-times"></i></button></div>'
                            );
                            $('#attachments-preview').append(imgContainer);
                            controlElementAccess(imgContainer.find('.remove-image'), 'requester');
                        };
                        reader.readAsDataURL(file);
                    }
                }

                $('#attachment-errors').html(errors.join('<br>'));
                if (errors.length > 0) {
                    setTimeout(() => $('#attachment-errors').html(''), 5000);
                }
                $(this).val('');
            }
        });

        $(document).on('click', '.remove-image', function() {
            if (!$(this).prop('disabled')) {
                var container = $(this).closest('.attachment-container');
                var index = parseInt(container.data('index'));
                uploadedFiles[index] = null;
                container.remove();
                uploadedFiles = uploadedFiles.filter(file => file !== null);
                $('#attachments-preview .attachment-container').each(function(i) {
                    $(this).data('index', i);
                });
            }
        });

        // Add/Remove Team Members
        let teamIndex = <?php echo count($team_members ?? []) - 1; ?>;
        $('#add-team').click(function() {
            if (!$(this).prop('disabled')) {
                teamIndex++;
                var newRow = $('.team-row:first').clone();
                newRow.find('input').attr('name', `team_members[${teamIndex}][name]`).val('').attr(
                    'placeholder', `Team Member ${teamIndex + 1}`);
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
                    $(this).find('input').attr('name', `team_members[${index}][name]`).attr(
                        'placeholder', `Team Member ${index + 1}`);
                    controlElementAccess($(this).find('input'), 'requester');
                    controlElementAccess($(this).find('.remove-team'), 'requester');
                });
                teamIndex = $('#team-rows .team-row').length - 1;
            }
        });

        // Form Submission
        $('#work-order-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData();

            // Collect form data
            var formDataSerialized = form.serializeArray();
            formDataSerialized.forEach(function(item) {
                formData.append(item.name, item.value);
            });

            // Collect supplies
            var supplies = [];
            $('#supplies-rows .supply-row').each(function(index) {
                var supply = {
                    id: index + 1,
                    item_number: $(this).find('input[name="supplies[' + index +
                        '][item_number]"]').val() || '',
                    part_number: $(this).find('input[name="supplies[' + index +
                        '][part_number]"]').val() || '',
                    item_name: $(this).find('input[name="supplies[' + index + '][item_name]"]')
                        .val() || '',
                    quantity: $(this).find('input[name="supplies[' + index + '][quantity]"]')
                        .val() || '',
                    description: $(this).find('input[name="supplies[' + index +
                        '][description]"]').val() || ''
                };
                supplies.push(supply);
            });
            formData.append('supplies', JSON.stringify(supplies));

            // Collect team members
            var teamMembers = [];
            $('#team-rows .team-row').each(function(index) {
                var name = $(this).find('input[name="team_members[' + index + '][name]"]').val();
                if (name) {
                    teamMembers.push({
                        id: index + 1,
                        name: name
                    });
                }
            });
            formData.append('team_members', JSON.stringify(teamMembers));

            // Append uploaded files
            uploadedFiles.filter(file => file !== null).forEach(function(fileObj) {
                formData.append('attachments[]', fileObj.file, fileObj.name);
            });

            // Show loading state
            $('#submit-form').prop('disabled', true);
            $('#submit-loading').removeClass('hidden');

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
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
                            '</div>'
                        );
                    } else {
                        if (response.messages instanceof Object) {
                            $.each(response.messages, function(index, value) {
                                var id = $("#" + index);
                                id.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' :
                                        'has-success');
                                id.after('<div class="text-red-500 text-sm mt-1">' +
                                    value + '</div>');
                            });
                        } else {
                            $("#messages").html(
                                '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                                '<div class="flex items-center">' +
                                '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                                '<span class="font-medium">' + response.messages +
                                '</span>' +
                                '</div>' +
                                '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                                '<i class="fas fa-times"></i>' +
                                '</button>' +
                                '</div>'
                            );
                        }
                    }
                },
                error: function() {
                    $("#messages").html(
                        '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                        '<div class="flex items-center">' +
                        '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                        '<span class="font-medium">An error occurred while updating the form.</span>' +
                        '</div>' +
                        '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                        '<i class="fas fa-times"></i>' +
                        '</button>' +
                        '</div>'
                    );
                },
                complete: function() {
                    // Reset loading state
                    $('#submit-form').prop('disabled', false);
                    $('#submit-loading').addClass('hidden');
                }
            });
        });
    });
</script>