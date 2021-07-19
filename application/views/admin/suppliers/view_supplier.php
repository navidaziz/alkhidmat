<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<!-- STYLER -->

			<!-- /STYLER -->
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
				</li>
				<li>
					<i class="fa fa-table"></i>
					<a href="<?php echo site_url(ADMIN_DIR . "suppliers/view/"); ?>"><?php echo $this->lang->line('Suppliers'); ?></a>
				</li>
				<li><?php echo $title; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
			<div class="row">

				<div class="col-md-6">
					<div class="clearfix">
						<h3 class="content-title pull-left"><?php echo $title; ?></h3>
					</div>
					<div class="description"><?php echo $detail; ?></div>
				</div>

				<div class="col-md-6">
					<div class="pull-right">
						<form method="post" action="<?php echo site_url(ADMIN_DIR . "suppliers/add_supplier_invoce") ?>">
							<table>
								<td>Invoice Number: <input type="text" name="supplier_invoice_number" />
									<input type="hidden" name="supplier_id" value="<?php echo $suppliers[0]->supplier_id; ?>" />
									<?php echo form_error("supplier_invoice_number", "<p class=\"text-danger\">", "</p>"); ?>
								</td>
								<td>Invoice Date: <input type="date" name="invoice_date" />
									<?php echo form_error("invoice_date", "<p class=\"text-danger\">", "</p>"); ?>

								</td>
								<td><input type="submit" name="Save" value="Add Invoice" /></td>
							</table>
						</form>
					</div>
				</div>

			</div>


		</div>
	</div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
	<!-- MESSENGER -->
	<div class="col-md-12">
		<div class="box border blue" id="messenger">
			<div class="box-title">
				<h4><i class="fa fa-bell"></i> <?php echo $title; ?> Invoices</h4>
			</div>
			<div class="box-body">

				<div class="table-responsive">

					<h4><?php echo $title; ?> Invoices List</h4>
					</h4>
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Supplier Invoice Number</th>
								<th>Supplier Invoice Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							foreach ($suppliers_invoices as $suppliers_invoice) : ?>


								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $suppliers_invoice->supplier_invoice_number; ?> </td>
									<td><?php echo $suppliers_invoice->invoice_date; ?> </td>
									<td><a href="<?php echo site_url(ADMIN_DIR . "suppliers/supplier_invoice_view/" . $suppliers_invoice->supplier_id . "/" . $suppliers_invoice->supplier_invoice_id);  ?>">View Invoice Detail</a></td>
								</tr>


							<?php endforeach; ?>
						</tbody>
					</table>




				</div>


			</div>

		</div>
	</div>
	<!-- /MESSENGER -->
</div>