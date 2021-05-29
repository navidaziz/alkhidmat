<div class="row">
  <!-- MESSENGER -->
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bar-chart"></i>Today Catagories Wise Report</h4>
      </div>
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <th>#</th>
            <th>Catagories</th>
            <th>Total</th>
            <th>Cancelled</th>
            <th>Total Rs</th>
          </tr>
          <?php
          $count = 1;
          foreach ($today_cat_wise_progress_reports as $report) { ?>
            <tr>
              <th><?php echo $count++; ?></th>
              <th><?php echo $report->test_category; ?></th>
              <th><?php echo $report->total_count; ?></th>
              <th><?php echo $report->total_receipt_cancelled; ?></th>
              <th><?php echo $report->total_sum; ?></th>
            </tr>
          <?php } ?>
          <tr>
            <th colspan="2" style="text-align: right;">Total</th>
            <th><?php echo $today_total_cat_wise_progress_reports[0]->total_count ?></th>
            <th><?php echo $today_total_cat_wise_progress_reports[0]->total_receipt_cancelled; ?></th>
            <th><?php echo $today_total_cat_wise_progress_reports[0]->total_sum ?></th>
          </tr>
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
            <th>Catagories</th>
            <th>Total</th>
            <th>Cancelled</th>
            <th>Total RS</th>
          </tr>
          <?php
          $count = 1;
          foreach ($today_OPD_reports as $report) { ?>
            <tr>
              <th><?php echo $count++; ?></th>
              <th><?php echo $report->test_group_name; ?></th>
              <th><?php echo $report->total_count; ?></th>
              <th><?php echo $report->total_receipt_cancelled; ?></th>
              <th><?php echo $report->total_sum; ?></th>
            </tr>
          <?php } ?>
          <tr>
            <th colspan="2" style="text-align: right;">Total</th>
            <th><?php echo $today_total_OPD_reports[0]->total_count ?></th>
            <th><?php echo $today_total_OPD_reports[0]->total_receipt_cancelled; ?></th>
            <th><?php echo $today_total_OPD_reports[0]->total_sum ?></th>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>