<!-- Completely modernized company management page -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-6">
  <div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Company Settings</h1>
          <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="/dashboard" class="hover:text-blue-600 transition-colors">
              <i class="fas fa-home mr-1"></i>Home
            </a>
            <i class="fas fa-chevron-right text-gray-400"></i>
            <span class="text-gray-900 font-medium">Company</span>
          </nav>
        </div>
      </div>
    </div>

    <!-- Messages Container -->
    <div id="messages" class="mb-6"></div>

    <!-- Company Information Form -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <!-- Form Header -->
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
        <h2 class="text-xl font-bold text-white flex items-center">
          <i class="fas fa-building mr-3"></i>
          Company Information
        </h2>
        <p class="text-blue-100 mt-1">Manage your company details and settings</p>
      </div>

      <!-- Form Content -->
      <form id="companyForm" action="<?php base_url('company/update') ?>" method="post" class="p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Basic Information -->
          <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
              <i class="fas fa-info-circle mr-2 text-blue-600"></i>
              Basic Information
            </h3>

            <div class="space-y-6">
              <div class="form-group">
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                  <i class="fas fa-building mr-1 text-gray-400"></i>
                  Company Name
                </label>
                <input type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  id="company_name" name="company_name" placeholder="Enter company name"
                  value="<?php echo $company_data['company_name'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                  <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                  Address
                </label>
                <input type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  id="address" name="address" placeholder="Enter company address"
                  value="<?php echo $company_data['address'] ?>" autocomplete="off">
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                  <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-phone mr-1 text-gray-400"></i>
                    Phone
                  </label>
                  <input type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    id="phone" name="phone" placeholder="Phone number"
                    value="<?php echo $company_data['phone'] ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-globe mr-1 text-gray-400"></i>
                    Country
                  </label>
                  <input type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    id="country" name="country" placeholder="Country"
                    value="<?php echo $company_data['country'] ?>" autocomplete="off">
                </div>
              </div>

              <div class="form-group">
                <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">
                  <i class="fas fa-dollar-sign mr-1 text-gray-400"></i>
                  Currency
                </label>
                <select
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  id="currency" name="currency">
                  <option value="">Select Currency</option>
                  <?php foreach ($currency_symbols as $k => $v): ?>
                    <option value="<?php echo trim($k); ?>"
                      <?php if ($company_data['currency'] == $k) echo "selected"; ?>>
                      <?php echo $k ?>
                    </option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div>

          <!-- Financial Settings -->
          <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
              <i class="fas fa-calculator mr-2 text-blue-600"></i>
              Financial Settings
            </h3>

            <div class="space-y-6">
              <div class="form-group">
                <label for="service_charge_value" class="block text-sm font-medium text-gray-700 mb-2">
                  <i class="fas fa-percentage mr-1 text-gray-400"></i>
                  Service Charge (%)
                </label>
                <input type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  id="service_charge_value" name="service_charge_value"
                  placeholder="Enter service charge percentage"
                  value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="vat_charge_value" class="block text-sm font-medium text-gray-700 mb-2">
                  <i class="fas fa-receipt mr-1 text-gray-400"></i>
                  VAT Charge (%)
                </label>
                <input type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  id="vat_charge_value" name="vat_charge_value"
                  placeholder="Enter VAT charge percentage"
                  value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                  <i class="fas fa-comment mr-1 text-gray-400"></i>
                  Company Message
                </label>
                <textarea
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  id="message" name="message" rows="6"
                  placeholder="Enter company message or description"><?php echo $company_data['message'] ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-4">
          <button type="submit" id="saveCompanyBtn"
            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
            <span class="btn-text"><i class="fas fa-save mr-2"></i>Save Changes</span>
            <span class="btn-loading hidden"><i class="fas fa-spinner fa-spin mr-2"></i>Loading...</span>
          </button>
          <a href="<?php echo base_url('dashboard') ?>"
            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Dashboard
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    // Initialize Summernote
    $("#message").summernote({
      height: 150,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });

    // Handle form submission with AJAX
    $("#companyForm").unbind('submit').on('submit', function(e) {
      e.preventDefault();

      var form = $(this);
      $(".text-danger").remove();
      $(".form-group").removeClass('has-error').removeClass('has-success');

      const saveBtn = $('#saveCompanyBtn');
      const btnText = saveBtn.find('.btn-text');
      const btnLoading = saveBtn.find('.btn-loading');

      btnText.addClass('hidden');
      btnLoading.removeClass('hidden');
      saveBtn.prop('disabled', true);

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          saveBtn.prop('disabled', false);

          if (response.success === true) {
            $("#messages").html(
              '<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
              '<div class="flex items-center">' +
              '<i class="fas fa-check-circle text-emerald-500 mr-3"></i>' +
              '<span class="font-medium">' + (response.messages ||
                'Company information updated successfully!') + '</span>' +
              '</div>' +
              '<button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
              '<i class="fas fa-times"></i>' +
              '</button>' +
              '</div>'
            );
            $("#companyForm")[0].reset();
            $("#message").summernote('reset');
            $(".form-group").removeClass('has-error').removeClass('has-success');
          } else {
            if (response.messages instanceof Object) {
              $.each(response.messages, function(index, value) {
                var id = $("#" + index);
                id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' :
                    'has-success');
                id.after('<span class="text-danger text-sm">' + value +
                  '</span>');
              });
            } else {
              $("#messages").html(
                '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                '<div class="flex items-center">' +
                '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                '<span class="font-medium">' + (response.messages ||
                  'An error occurred while updating company information.'
                ) + '</span>' +
                '</div>' +
                '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                '<i class="fas fa-times"></i>' +
                '</button>' +
                '</div>'
              );
            }
          }
        },
        error: function(xhr) {
          btnText.removeClass('hidden');
          btnLoading.addClass('hidden');
          saveBtn.prop('disabled', false);

          $("#messages").html(
            '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
            '<div class="flex items-center">' +
            '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
            '<span class="font-medium">' + (xhr.responseJSON?.message ||
              'An error occurred while updating company information.') +
            '</span>' +
            '</div>' +
            '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
            '<i class="fas fa-times"></i>' +
            '</button>' +
            '</div>'
          );
        }
      });
      return false;
    });
  });
</script>