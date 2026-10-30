<!-- Replaced AdminLTE content wrapper with modern Tailwind layout -->
<div class="bg-gray-50">
  <div class="p-6">
    <!-- Content Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Reports</h1>
          <p class="text-gray-600 mt-1">Sales and revenue analytics</p>
        </div>
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
          <a href="#" class="flex items-center hover:text-blue-600 transition-colors">
            <i class="fas fa-home mr-1"></i>
            Home
          </a>
          <i class="fas fa-chevron-right text-xs"></i>
          <span class="text-gray-900">Reports</span>
        </nav>
      </div>
    </div>

    <!-- Year Filter -->
    <div class="mb-8">
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form class="flex items-end space-x-4" action="<?php echo base_url('reports/') ?>" method="POST">
          <div class="flex-1 max-w-xs">
            <label for="select_year" class="block text-sm font-medium text-gray-700 mb-2">Filter by
              Year</label>
            <select
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
              name="select_year" id="select_year">
              <?php foreach ($report_years as $key => $value): ?>
                <option value="<?php echo $value ?>" <?php if ($value == $selected_year) {
                                                        echo "selected";
                                                      } ?>><?php echo $value; ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
          <button type="submit"
            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
            <i class="fas fa-filter mr-2"></i>
            Apply Filter
          </button>
        </form>
      </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
      <div
        class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
        <span><?php echo $this->session->flashdata('success'); ?></span>
        <button type="button" class="text-green-500 hover:text-green-700"
          onclick="this.parentElement.style.display='none'">
          <i class="fas fa-times"></i>
        </button>
      </div>
    <?php elseif ($this->session->flashdata('error')): ?>
      <div
        class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
        <span><?php echo $this->session->flashdata('error'); ?></span>
        <button type="button" class="text-red-500 hover:text-red-700"
          onclick="this.parentElement.style.display='none'">
          <i class="fas fa-times"></i>
        </button>
      </div>
    <?php endif; ?>

    <!-- Chart Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
          <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
          Monthly Sales Report - <?php echo $selected_year; ?>
        </h3>
      </div>
      <div class="p-6">
        <div class="bg-gray-50 rounded-lg p-4">
          <canvas id="barChart" class="w-full" style="height:300px"></canvas>
        </div>
      </div>
    </div>

    <!-- Data Table Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
      <div
        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
          <i class="fas fa-table text-green-600 mr-2"></i>
          Total Paid Orders - Report Data
        </h3>

      </div>

      <div class="overflow-x-auto">
        <table id="datatables" class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Month - Year
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Amount
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($results as $k => $v): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <?php echo $k; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <?php echo $company_currency . ' ' . number_format($v, 2); ?>
                  </span>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
          <tfoot class="bg-blue-50">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-bold text-blue-900">Total Amount</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-blue-900">
                <span
                  class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                  <?php echo $company_currency . ' ' . number_format(array_sum($results), 2); ?>
                </span>
              </th>
            </tr>
          </tfoot>
        </table>
      </div>


    </div>

  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#reportNav").addClass('active');

      // Initialize DataTable with modern styling
      $('#datatables').DataTable({
        pageLength: 10,
        responsive: true,
        lengthMenu: [5, 10, 25, 50, 100],
        dom: '<"flex md:flex-row md:items-center justify-between p-4"<"mb-4 md:mb-0"l><"flex items-center"f>>rt<"flex flex-row md:items-center justify-between p-4"<"mb-4 md:mb-0"i><"flex items-center"p>>',
        language: {
          paginate: {
            first: '<i class="fas fa-angle-double-left"></i>',
            previous: '<i class="fas fa-angle-left"></i>',
            next: '<i class="fas fa-angle-right"></i>',
            last: '<i class="fas fa-angle-double-right"></i>'
          }
        },
        initComplete: function() {
          // Style the search input
          $('.dataTables_filter input').addClass(
            'border border-slate-200 rounded-md px-3 ml-1 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
          );

          // Style the length menu
          $('.dataTables_length select').addClass(
            'border border-slate-200 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'
          );

          stylePagination()
        },
        drawCallback: function() {
          // Style pagination buttons
          stylePagination()
        }
      });

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


      var report_data = <?php echo '[' . implode(',', $results) . ']'; ?>;

      $(function() {
        /* ChartJS Configuration */
        var areaChartData = {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August',
            'September', 'October', 'November', 'December'
          ],
          datasets: [{
            label: 'Monthly Sales',
            fillColor: 'rgba(59, 130, 246, 0.8)',
            strokeColor: 'rgba(59, 130, 246, 1)',
            pointColor: 'rgba(59, 130, 246, 1)',
            pointStrokeColor: '#ffffff',
            pointHighlightFill: '#ffffff',
            pointHighlightStroke: 'rgba(59, 130, 246, 1)',
            data: report_data
          }]
        }

        // Bar Chart
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChart = new Chart(barChartCanvas)
        var barChartData = areaChartData
        var barChartOptions = {
          scaleBeginAtZero: true,
          scaleShowGridLines: true,
          scaleGridLineColor: 'rgba(0,0,0,.05)',
          scaleGridLineWidth: 1,
          scaleShowHorizontalLines: true,
          scaleShowVerticalLines: true,
          barShowStroke: true,
          barStrokeWidth: 2,
          barValueSpacing: 5,
          barDatasetSpacing: 1,
          responsive: true,
          maintainAspectRatio: false
        }

        barChartOptions.datasetFill = false
        barChart.Bar(barChartData, barChartOptions)
      });

    });
  </script>
