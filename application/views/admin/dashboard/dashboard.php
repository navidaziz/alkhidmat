<div class="container" style="margin-top:5px !important; font-size:10px;">
  <div class="row">
    <div class="col-md-12">
      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4 class="pull-left">Today Report</h4>
        </div>
        <div class="box-body">
          <div class="row">

            <div class="col-md-6">
              <h5>
                <table class="table table-bordered">
                  <tr>
                    <th>LAB</th>
                    <td><?php echo $today_report->lab_count ?></td>
                    <td><?php echo $today_report->lab ?></td>
                  </tr>
                  <tr>
                    <th>ECG</th>
                    <td><?php echo $today_report->ecg_count ?></td>
                    <td><?php echo $today_report->ecg ?></td>
                  </tr>
                  <tr>
                    <th>ULTRASOUND</th>
                    <td><?php echo $today_report->ultrasound_count ?></td>
                    <td><?php echo $today_report->ultrasound ?></td>
                  </tr>
                  <tr>
                    <th>X-RAY</th>
                    <td><?php echo $today_report->x_ray_count ?></td>
                    <td><?php echo $today_report->x_ray ?></td>
                  </tr>
                  <tr>

                    <th>Dr. Naila</th>
                    <td><?php echo $today_report->dr_naila_count ?></td>
                    <td><?php echo $today_report->dr_naila ?></td>
                  </tr>
                  <tr>
                    <th>Dr. Shabana</th>
                    <td><?php echo $today_report->dr_shabana_count ?></td>
                    <td><?php echo $today_report->dr_shabana ?></td>
                  </tr>
                  <tr>
                    <th>US-Doppler (Dr.Shabana)</th>
                    <td><?php echo $today_report->dr_shabana_us_doppler_count ?></td>
                    <td><?php echo $today_report->dr_shabana_us_doppler ?></td>
                  </tr>
                  <tr>
                    <th>Discounts</th>
                    <td><?php echo $today_report->discount_count ?></td>
                    <td><?php echo $today_report->discount ?></td>
                  </tr>
                  <tr>
                    <th>Cancelled</th>
                    <td><?php echo $today_report->other_deleted ?></td>
                    <td></td>
                  </tr>
                  <tr>

                    <th>Total</th>
                    <td></td>
                    <td><?php echo $today_report->alkhidmat_total ?></td>
                  </tr>

                </table>
              </h5>
            </div>
            <div class="col-md-6">
              <h5>
                <table class="table table-bordered">
                  <th>OPDs</th>
                  <td><?php echo $today_report->opd ?></td>
                  <th>OPD Cancelled</th>
                  <td><?php echo $today_report->opd_deleted ?></td>

                  </tr>
                </table>
              </h5>
            </div>
            <div class="col-md-3">

              <h4>Today</h4>
              <table class="table table-bordered">
                <th>
                  Total Test
                </th>
                <th>
                  <strong><?php echo $total_test; ?></strong>
                </th>
                </tr>
                <tr>
                  <th>
                    Price
                  </th>
                  <th>
                    <strong><?php echo $price; ?></strong>
                  </th>
                </tr>
                <tr>
                  <th>
                    Discount
                  </th>
                  <th>
                    <strong><?php echo $discount; ?></strong>
                  </th>
                </tr>
                <tr>
                  <th>
                    Income
                  </th>
                  <th>
                    <strong><?php echo $total_income; ?></strong>
                  </th>
                </tr>
                <tr>
                  <th>
                    Expense
                  </th>
                  <th>
                    <strong><?php echo $total_expenses; ?></strong>
                  </th>
                </tr>
                <tr>
                  <th>
                    Net Income
                  </th>
                  <th>
                    <strong><?php echo ($total_income - $total_expenses); ?></strong>
                  </th>
                </tr>
              </table>
            </div>
            <div class="col-md-3">
              <h4>Today Expenses</h4>
              <div>
                <table class="table table-bordered">
                  <tr>
                    <td>Expense Type</td>
                    <td>Total Expense</td>
                  </tr>
                  <?php
                  $total_expense = 0;
                  foreach ($today_expenses as $expense_type) {
                    $total_expense += $expense_type->expense_total;
                  ?>
                    <tr>
                      <td><?php echo ucwords(strtolower($expense_type->expense_type)); ?></td>
                      <td><?php echo $expense_type->expense_total ?></td>
                    </tr>
                  <?php } ?>
                </table>
              </div>
              <table class="table table-bordered">
                <tr>
                  <td>
                    <h5>Total Expense</h5>
                  </td>
                  <td>
                    <h5><strong><?php echo "Rs " . $total_expense; ?></h5></strong>
                  </td>
                </tr>
              </table>
            </div>

            <div class="col-md-6">
              <table class="table table-bordered">
                <h4>Referred By Doctors</h4>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Total Referred</th>
                  <th>Previous Month</th>
                  <th>Current Month</th>
                  <th>Referred Today</th>
                </tr>
                <?php
                $count = 1;
                foreach ($doctors_refereds as $key => $doctors_refered) { ?>
                  <tr>
                    <td><?php echo $count++ ?></td>
                    <td><?php echo $doctors_refered->doctor_name;   ?> - <?php echo $doctors_refered->doctor_designation;   ?></td>
                    <td><?php echo $doctors_refered->total_refered;   ?></td>
                    <td><?php echo $doctors_refered->total_refered_previous_month;   ?></td>
                    <td><?php echo $doctors_refered->total_refered_current_month;   ?></td>
                    <td><?php echo $doctors_refered->total_refered_today;   ?></td>
                  </tr>

                <?php } ?>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4 class="pull-left">Current Month Day Wise Report</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="hidden-xs col-md-6">
              <div id="current_month_report"></div>
            </div>
            <div class="col-md-6">
              <h2>Current Month Day Wise Report</h2>
              <div style=" width:100%; height:350px !important; overflow:scroll; overflow-x: hidden;">
                <table class="table table-bordered">
                  <tr>
                    <th>Date</th>
                    <th>Total Tests</th>
                    <th>Test Price</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Expense</th>
                    <th>Income</th>
                  </tr>
                  <?php
                  $count = 0;
                  $total_income = 0;
                  $income_expence_reportarray = $income_expence_report;
                  krsort($income_expence_reportarray);
                  foreach ($income_expence_reportarray as $date => $report) {
                    $total_income += $report['income']; ?>
                    <tr <?php if ($count == 0) { ?> style="background-color:#9F9 !important; " <?php $count++;
                                                                                              } ?>>
                      <td><?php echo $date; ?></td>
                      <td><?php echo $report['total_test']; ?></td>
                      <td><?php echo $report['price']; ?></td>
                      <td><?php echo $report['discount']; ?></td>
                      <td><?php echo $report['income']; ?></td>
                      <td><?php echo $report['expense']; ?></td>
                      <td><?php echo ($report['income'] - $report['expense']); ?></td>
                    </tr>
                  <?php } ?>
                </table>
              </div>
              <table class="table">
                <tr>
                  <td>
                    <h5>Total Income</h5>
                  </td>
                  <td>
                    <h5><strong><?php echo "Rs " . $total_income; ?></strong></h5>
                  </td>

                </tr>
              </table>
            </div>





          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4 class="pull-left">Monthly Report</h4>
        </div>


        <div class="box-body">
          <div class="row">
            <div class="hidden-xs col-md-6">
              <div id="year_monthly_report"></div>
            </div>
            <div class="col-md-6">
              <h2>Monthly Report</h2>
              <div style=" width:100%; height:350px !important; overflow:scroll; overflow-x: hidden;">
                <table class="table table-bordered">
                  <tr>
                    <th>Date</th>
                    <th>Total Tests</th>
                    <th>Test Price</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Expense</th>
                    <th>Income</th>
                  </tr>
                  <?php

                  foreach ($month_income_expence_report as $date => $report) {  ?>
                    <tr <?php if ($date == date("F, Y", time())) { ?> style="background-color:#9F9 !important; font-size:16px;" <?php $count++;
                                                                                                                              } ?>>
                      <td><?php echo $date; ?></td>
                      <td><?php echo $report['total_test']; ?></td>
                      <td><?php echo $report['price']; ?></td>
                      <td><?php echo $report['discount']; ?></td>
                      <td><?php echo $report['income']; ?></td>
                      <td><?php echo $report['expense']; ?></td>
                      <td><?php echo ($report['income'] - $report['expense']); ?></td>
                    </tr>
                  <?php } ?>
                </table>
              </div>
            </div>





          </div>

          <hr />

          <div class="row" style="margin-top:10px;">
            <div class="col-md-6">
              <div id="year_report"></div>
            </div>
            <div class="col-md-6">
              <h2>Yearly Report</h2>
              <table class="table table-bordered">
                <tr>
                  <th>Year</th>
                  <th>Total Tests</th>
                  <th>Test Price</th>
                  <th>Discount</th>
                  <th>Total</th>
                  <th>Expense</th>
                  <th>Income</th>
                </tr>
                <tr>
                  <td>2019</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                </tr>
                <tr>
                  <td>2020</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                </tr>
                <?php

                foreach ($years_report as $report) {  ?>
                  <tr <?php if ($report->year == date("Y", time())) { ?> style="background-color:#9F9 !important; font-size:16px;" <?php $count++;
                                                                                                                                  } ?>>
                    <td><?php echo $report->year; ?></td>
                    <td><?php echo $report->total_test; ?></td>
                    <td><?php echo $report->price; ?></td>
                    <td><?php echo $report->discount; ?></td>
                    <td><?php echo $report->income_per_year; ?></td>
                    <td><?php echo $report->expense_per_year; ?></td>
                    <td><?php echo ($report->income_per_year - $report->expense_per_year); ?></td>
                  </tr>
                <?php } ?>
              </table>


            </div>
          </div>



        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#year_monthly_report').highcharts({
      title: {
        text: 'Monthly Report',
        x: -20 //center
      },
      subtitle: {
        text: 'Monthly Report',
        x: -20
      },
      xAxis: {
        categories: [
          <?php
          $income = "";
          foreach ($month_income_expence_report as $date => $report) {
            $income .= $report['income'] . ", ";
          ?> '<?php echo $date; ?>',
          <?php } ?>
        ]
      },
      yAxis: {
        title: {
          text: 'Income / Expenses'
        },
        plotLines: [{
          value: 0,
          width: 1,
          color: '#808080'
        }]
      },
      tooltip: {
        valueSuffix: ' Total'
      },
      // legend: {
      //   layout: 'vertical',
      //   align: 'right',
      //   verticalAlign: 'middle',
      //   borderWidth: 0
      // },
      series: [{
          name: 'Incomes',
          data: [<?php echo $income; ?>]
        }

      ]
    });
  });



  $(function() {
    $('#current_month_report').highcharts({
      title: {
        text: 'Current Month ',
        x: -20 //center
      },
      subtitle: {
        text: 'Current Month Days Wise Report',
        x: -20
      },
      xAxis: {
        categories: [
          <?php
          $income = "";
          foreach ($income_expence_report as $date => $report) {
            $income .= $report['income'] . ", ";
          ?> '<?php echo $date; ?>',
          <?php } ?>
        ]
      },
      yAxis: {
        title: {
          text: 'Income'
        },
        plotLines: [{
          value: 0,
          width: 1,
          color: '#808080'
        }]
      },
      tooltip: {
        valueSuffix: ' Total'
      },
      // legend: {
      //   layout: 'vertical',
      //   align: 'right',
      //   verticalAlign: 'middle',
      //   borderWidth: 0
      // },
      series: [{
          name: 'Incomes',
          data: [<?php echo $income; ?>]
        }

      ]
    });
  });



  $(function() {
    $('#year_report').highcharts({
      title: {
        text: 'Yearly Report',
        x: -20 //center
      },
      subtitle: {
        text: 'Yearly Report',
        x: -20
      },
      xAxis: {
        categories: ['2019', '2020',
          <?php
          $income = "";
          foreach ($years_report as $report) {
            $income .= $report->income_per_year . ", ";
          ?> '<?php echo $report->year; ?>',
          <?php } ?>
        ]
      },
      yAxis: {
        title: {
          text: 'Income'
        },
        plotLines: [{
          value: 0,
          width: 1,
          color: '#808080'
        }]
      },
      tooltip: {
        valueSuffix: ' Total'
      },
      // legend: {
      //   layout: 'vertical',
      //   align: 'right',
      //   verticalAlign: 'middle',
      //   borderWidth: 0
      // },
      series: [{
          name: 'Incomes',
          data: [0, 0, <?php echo $income; ?>]
        }

      ]
    });
  });
</script>
<script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/Highcharts/js/highcharts.js"></script>
<script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/Highcharts/js/highcharts-more.js"></script>
<script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/Highcharts/js/modules/exporting.js"></script>
<script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/Highcharts/js/modules/drilldown.js"></script>