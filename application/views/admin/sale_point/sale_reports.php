<div class="row">


    <div class="col-md-3">
        <div class="box border primary">
            <div class="box-title">
                <h4><i class="fa fa-money"></i>Today Sales Summary</h4>

            </div>
            <div class="box-body">
                <div class="sparkline-row">
                    <span class="title">Items Sales Amount</span>
                    <span class="value">Rs: <?php echo round($today_sale_summary->items_price, 2); ?></span>
                </div>
                <div class="sparkline-row">
                    <span class="title">Taxes</span>
                    <span class="value">Rs: <?php echo round($today_sale_summary->total_tax, 2); ?></span>
                    <span class="title">Discounts</span>
                    <span class="value">Rs: <?php echo round($today_sale_summary->discount, 2); ?></span>
                </div>
                <div class="sparkline-row">
                    <span class="title">Total Today Sale Amount</span>
                    <span class="value">Rs: <?php echo round($today_sale_summary->total_sale, 2); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4 font-900">
        <h4>Reports</h4>
        <ol>
            <li class="text-primary"> <a class="text-primary" target="_new" href="<?php echo  site_url(ADMIN_DIR . "sale_point/today_items_sale_report"); ?>">
                    Print Today Sale Report</a></li>
            <li class="text-primary"> <a class="text-primary" target="_new" href="<?php echo  site_url(ADMIN_DIR . "sale_point/print_stock_report"); ?>">
                    Print Stock Report</a></li>

        </ol>
    </div>

</div>