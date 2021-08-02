<div class="row">
    <div class="col-sm-4">
        <h3>Total Items Sale Amount: <?php echo round($today_sale_summary->items_price, 2); ?></h3>
        <h3>Total Taxes: <?php echo round($today_sale_summary->total_tax, 2); ?></h3>
        <h3>Total Discounts: <?php echo round($today_sale_summary->discount, 2); ?></h3>
        <h3>Total Sale: <?php echo round($today_sale_summary->total_sale, 2); ?></h3>
    </div>
    <div class="col-sm-4">
        <a target="_new" href="<?php echo  site_url(ADMIN_DIR . "sale_point/today_items_sale_report"); ?>">
            Print Today Items Sale Report</a>
    </div>
</div>