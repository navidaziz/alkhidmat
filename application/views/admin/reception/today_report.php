<div class="row">
  <div><a target="new" class="btn btn-primary" href="<?php echo site_url(ADMIN_DIR . "reports/daily_reception_report") ?>">Print Daily Report</a></div>
  <br />
  <!-- MESSENGER -->
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bar-chart"></i>Today Catagories Wise Report</h4>
      </div>
      <div class="box-body">
        <table class="table table-bordered" id="today_categories_wise_report">
          <thead>

            <tr>
              <th>#</th>
              <th>Catagories</th>
              <th>Total</th>
              <th>Cancelled</th>
              <th>Confirmed</th>
              <th>Total Rs</th>
            </tr>

          </thead>
          <tbody>

            <?php
            $count = 1;
            foreach ($today_cat_wise_progress_reports as $report) { ?>
              <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $report->test_category; ?></td>
                <td><?php echo $report->total_count + $report->total_receipt_cancelled; ?></td>
                <td><?php echo $report->total_receipt_cancelled; ?></td>
                <td><?php echo $report->total_count; ?></td>
                <td><?php echo $report->total_sum; ?></td>
              </tr>
            <?php } ?>
            <tr>
              <th colspan="2" style="text-align: right;">Total</th>
              <th style="text-align: center;"><?php echo $today_total_cat_wise_progress_reports[0]->total_count + $today_total_cat_wise_progress_reports[0]->total_receipt_cancelled ?></th>
              <th style="text-align: center;"><?php echo $today_total_cat_wise_progress_reports[0]->total_receipt_cancelled; ?></th>
              <th style="text-align: center;"><?php echo $today_total_cat_wise_progress_reports[0]->total_count ?></th>
              <th style="text-align: center;"><?php echo $today_total_cat_wise_progress_reports[0]->total_sum ?></th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user-md"></i>Today OPD Wise Report</h4>
      </div>
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <th>#</th>
            <th>Doctor Name</th>
            <th>Total Appoinments</th>
            <th>Cancelled</th>
            <th>Confirmed</th>
            <th>Total RS</th>
          </tr>
          <?php
          $count = 1;
          foreach ($today_OPD_reports as $report) { ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $report->test_group_name; ?></td>
              <td><?php echo $report->total_count + $report->total_receipt_cancelled; ?></td>
              <td><?php echo $report->total_receipt_cancelled; ?></td>
              <td><?php echo $report->total_count; ?></td>
              <td><?php echo $report->total_sum; ?></td>
            </tr>
          <?php } ?>
          <tr>
            <th colspan="2" style="text-align: right;">OPD Total</th>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_count + $today_total_OPD_reports[0]->total_receipt_cancelled ?></th>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_receipt_cancelled; ?></th>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_count ?></th>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_sum ?></th>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>