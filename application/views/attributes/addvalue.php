<div class="w-full max-w-none p-4 sm:p-6 lg:p-8">
  <!-- Content Header -->
  <div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manage Attributes Value</h1>
        <p class="text-slate-600 mt-1">Manage values for product attributes</p>
      </div>
      <nav class="flex items-center space-x-2 text-sm text-slate-500">
        <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
          <i class="fas fa-home mr-1"></i>
          Home
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="<?php echo base_url('attributes/') ?>"
          class="flex items-center hover:text-blue-600 transition-colors duration-200">Attributes</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-slate-900 font-medium">Attributes Value</span>
      </nav>
    </div>
  </div>

  <!-- Attribute Info -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <h4 class="text-lg font-semibold text-slate-800">Attribute: <span
        class="text-blue-600"><?php echo $attribute_data['name']; ?></span></h4>
  </div>

  <!-- Flash Messages -->
  <div id="messages"></div>

  <!-- Action Bar -->
  <div class="flex justify-between items-center mb-6">
    <div></div>
    <button onclick="showModal('addValueModal')"
      class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow hover:shadow-md">
      <i class="fas fa-plus mr-2"></i>
      Add Value
    </button>
  </div>

  <!-- Attributes Value Table -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
      <table id="manageTable" class="w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
              Attribute Value
            </th>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200">
          <!-- DataTable will populate this -->
        </tbody>
      </table>
    </div>
  </div>

  <!-- Add Value Modal -->
  <div id="addValueModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div
      class="bg-white rounded-2xl shadow-2xl border border-slate-200/60 w-full max-w-lg transform scale-95 opacity-0 transition-all duration-150">
      <div
        class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h4 class="text-xl font-semibold text-slate-900">Add Attribute Value</h4>
        <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors"
          onclick="hideModal('addValueModal')">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form id="createForm" action="<?php echo base_url('attributes/createValue') ?>" method="post">
        <div class="p-6">
          <div class="form-group mb-4">
            <label for="attribute_value_name" class="text-sm font-medium text-slate-700">Attribute
              Value</label>
            <input type="text"
              class="form-control border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full"
              id="attribute_value_name" name="attribute_value_name" placeholder="Enter attribute value"
              autocomplete="off">
          </div>
          <input type="hidden" name="attribute_parent_id" value="<?php echo $attribute_data['id']; ?>">
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end space-x-2">
          <button type="button"
            class="px-4 py-2 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 transition-colors"
            onclick="hideModal('addValueModal')">Cancel</button>
          <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Save
            Value</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Value Modal -->
  <div id="editValueModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div
      class="bg-white rounded-2xl shadow-2xl border border-slate-200/60 w-full max-w-lg transform scale-95 opacity-0 transition-all duration-150">
      <div
        class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h4 class="text-xl font-semibold text-slate-900">Edit Attribute Value</h4>
        <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors"
          onclick="hideModal('editValueModal')">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form id="updateForm" action="<?php echo base_url('attributes/updateValue') ?>" method="post">
        <div class="p-6">
          <div id="editMessages"></div>
          <div class="form-group mb-4">
            <label for="edit_attribute_value_name" class="text-sm font-medium text-slate-700">Attribute
              Value</label>
            <input type="text"
              class="form-control border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full"
              id="edit_attribute_value_name" name="edit_attribute_value_name"
              placeholder="Enter attribute value" autocomplete="off">
          </div>
          <input type="hidden" name="attribute_parent_id" value="<?php echo $attribute_data['id']; ?>">
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end space-x-2">
          <button type="button"
            class="px-4 py-2 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 transition-colors"
            onclick="hideModal('editValueModal')">Cancel</button>
          <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Update
            Value</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Remove Value Modal -->
  <div id="removeValueModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div
      class="bg-white rounded-2xl shadow-2xl border border-slate-200/60 w-full max-w-lg transform scale-95 opacity-0 transition-all duration-150">
      <div
        class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h4 class="text-xl font-semibold text-slate-900">Remove Attribute Value</h4>
        <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors"
          onclick="hideModal('removeValueModal')">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form id="removeForm" action="<?php echo base_url('attributes/removeValue') ?>" method="post">
        <div class="p-6">
          <input type="hidden" name="attribute_value_id" id="attribute_value_id" value="">
          <p class="text-slate-700">Do you really want to remove this attribute value?</p>
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end space-x-2">
          <button type="button"
            class="px-4 py-2 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 transition-colors"
            onclick="hideModal('removeValueModal')">Cancel</button>
          <button type="submit"
            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">Remove</button>
        </div>
      </form>
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
    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      responsive: true,
      pageLength: 10,
      lengthMenu: [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      order: [
        [0, 'asc']
      ],
      columnDefs: [{
        orderable: false,
        targets: -1
      }],
      dom: '<"flex md:flex-row md:items-center justify-between p-4"<"mb-4 md:mb-0"l><"flex items-center"f>>rt<"flex flex-row md:items-center justify-between p-4"<"mb-4 md:mb-0"i><"flex items-center"p>>',
      language: {
        search: '',
        searchPlaceholder: 'Search...',
        lengthMenu: 'Show _MENU_ attributes',
        paginate: {
          first: '<i class="fas fa-angle-double-left"></i>',
          previous: '<i class="fas fa-angle-left"></i>',
          next: '<i class="fas fa-angle-right"></i>',
          last: '<i class="fas fa-angle-double-right"></i>'
        }
      },
      initComplete: function() {
        stylePagination();
        styleSearchInput();
        styleLengthMenu();
      },
      drawCallback: function() {
        // Reapply padding when table redraws
        $('th').addClass('px-4 py-3');
        $('td').addClass('px-4 py-3');
        stylePagination();
      },
      createdRow: function(row, data, dataIndex) {
        // Apply padding to new rows as they're created
        $(row).find('td').addClass('px-4 py-3');
      },
      'ajax': base_url + 'attributes/fetchAttributeValueData/' + <?php echo $attribute_data['id']; ?>
    });

    function styleSearchInput() {
      $('.dataTables_filter input').addClass(
        'border border-slate-200 rounded-md px-3 ml-1 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
      );
    }

    function stylePagination() {
      $('.dataTables_paginate').addClass('flex items-center space-x-2 mt-4');
      $('.dataTables_paginate .paginate_button').each(function() {
        $(this)
          .addClass(
            'px-3 py-1 mx-1 rounded-md border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-colors duration-200 inline-flex items-center justify-center'
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
        'border border-slate-200 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
      );
    }

    // submit the create form 
    $("#createForm").unbind('submit').on('submit', function() {
      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
          manageTable.ajax.reload(null, false);

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

            // hide the modal
            hideModal('addValueModal');

            // reset the form
            $("#createForm")[0].reset();
            $("#createForm .form-group").removeClass('has-error').removeClass(
              'has-success');

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
        }
      });

      return false;
    });
  })

  // edit function
  function editFunc(id) {
    $.ajax({
      url: base_url + 'attributes/fetchAttributeValueById/' + id,
      type: 'post',
      dataType: 'json',
      success: function(response) {
        $("#edit_attribute_value_name").val(response.value);
        showModal('editValueModal');

        // submit the edit form 
        $("#updateForm").unbind('submit').bind('submit', function() {
          var form = $(this);

          // remove the text-danger
          $(".text-danger").remove();

          $.ajax({
            url: form.attr('action') + '/' + id,
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
              manageTable.ajax.reload(null, false);

              if (response.success === true) {
                $("#messages").html(
                  '<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                  '<div class="flex items-center">' +
                  '<i class="fas fa-check-circle text-emerald-500 mr-3"></i>' +
                  '<span class="font-medium">' + response.messages +
                  '</span>' +
                  '</div>' +
                  '<button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                  '<i class="fas fa-times"></i>' +
                  '</button>' +
                  '</div>'
                );

                // hide the modal
                hideModal('editValueModal');
                // reset the form 
                $("#updateForm .form-group").removeClass('has-error')
                  .removeClass('has-success');

              } else {
                if (response.messages instanceof Object) {
                  $.each(response.messages, function(index, value) {
                    var id = $("#" + index);

                    id.closest('.form-group')
                      .removeClass('has-error')
                      .removeClass('has-success')
                      .addClass(value.length > 0 ?
                        'has-error' : 'has-success');

                    id.after(
                      '<div class="text-red-500 text-sm mt-1">' +
                      value + '</div>');
                  });
                } else {
                  $("#editMessages").html(
                    '<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">' +
                    '<div class="flex items-center">' +
                    '<i class="fas fa-exclamation-circle text-red-500 mr-3"></i>' +
                    '<span class="font-medium">' + response
                    .messages + '</span>' +
                    '</div>' +
                    '<button type="button" class="text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.style.display=\'none\'">' +
                    '<i class="fas fa-times"></i>' +
                    '</button>' +
                    '</div>'
                  );
                }
              }
            }
          });

          return false;
        });
      }
    });
  }

  // remove functions 
  function removeFunc(id) {
    if (id) {
      $("#attribute_value_id").val(id);
      showModal('removeValueModal');

      $("#removeForm").on('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: form.serialize(),
          dataType: 'json',
          success: function(response) {
            manageTable.ajax.reload(null, false);

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

              // hide the modal
              hideModal('removeValueModal');

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
                '</div>'
              );
            }
          }
        });

        return false;
      });
    }
  }
</script>
