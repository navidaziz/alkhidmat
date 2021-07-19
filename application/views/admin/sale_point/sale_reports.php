<div class="row">
    <div class="col-sm-4">
        <h3>Total Items Sale Amount: <?php echo $today_sale_summary->items_price; ?></h3>
        <h3>Total Taxes: <?php echo $today_sale_summary->total_tax; ?></h3>
        <h3>Total Discounts: <?php echo $today_sale_summary->discount; ?></h3>
        <h3>Total Sale: <?php echo $today_sale_summary->total_sale; ?></h3>
    </div>
    <div class="col-sm-4">
        <a target="_new" href="<?php echo  site_url(ADMIN_DIR . "sale_point/today_items_sale_report"); ?>">
            Print Today Items Sale Report</a>
    </div>
</div>