<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reception extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		$this->lang->load("patients", 'english');
		$this->lang->load("system", 'english');
		$this->load->model("admin/test_group_model");
		$this->load->model("admin/invoice_model");
		$this->load->model("admin/test_type_model");


		$this->load->model("admin/patient_model");
		// $this->load->model("admin/patient_model");
		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------



	public function today_progress_report()
	{

		$query = "SELECT
					`test_categories`.`test_category`
					, IF(SUM(`invoices`.`total_price`), SUM(`invoices`.`total_price`), 0) AS total_sum
					, COUNT(`invoices`.`invoice_id`) AS total_count
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = DATE(NOW())
					GROUP BY `test_categories`.`test_category`;";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$this->data["today_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT SUM(`invoices`.`total_price`) AS total_sum
					, COUNT(`invoices`.`invoice_id`) AS total_count
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = DATE(NOW())";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$this->data["today_total_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT
					`test_groups`.`test_group_name`
					, IF(SUM(`invoices`.`total_price`), SUM(`invoices`.`total_price`), 0) AS total_sum
					, COUNT(`invoices`.`invoice_id`) AS total_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = DATE(NOW())
				GROUP BY `test_groups`.`test_group_name`";
		$today_OPD_report = $this->db->query($query)->result();
		$this->data["today_OPD_reports"] = $today_OPD_report;
		$query = "SELECT SUM(`invoices`.`total_price`) AS total_sum
					, COUNT(`invoices`.`invoice_id`) AS total_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = DATE(NOW())";
		$today_OPD_report = $this->db->query($query)->result();
		$this->data["today_total_OPD_reports"] = $today_OPD_report;


		$this->load->view(ADMIN_DIR . "reception/today_report", $this->data);
	}



	/**
	 * Default action to be called
	 */
	public function index()
	{

		$where = "`test_groups`.`status` IN (1) ORDER BY  test_group_name ASC";
		$this->data["test_groups"] = $this->test_group_model->get_test_group_list($where, false);
		$this->data["test_categories"] = $this->test_type_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");


		$where = "`invoices`.`status` IN (1,2,3) AND DATE(`invoices`.`created_date`) = DATE(NOW())  ORDER BY `invoices`.`invoice_id` DESC";
		$this->data["all_tests"] = $this->invoice_model->get_invoice_list($where, false);
		$this->load->view(ADMIN_DIR . "reception/home", $this->data);
	}

	public function save_data()
	{

		//save patient data and get pacient id ....
		$patient_id = $this->patient_model->save_data();
		$test_group_ids = rtrim($this->input->post('testGroupIDs'), ',');
		//$test_group_ids =  implode(',', $this->input->post('test_group_id'));
		//exit();


		$query = "SELECT category_id FROM `test_groups` 
				WHERE `test_groups`.`test_group_id` IN (" . $test_group_ids . ")
				GROUP BY `category_id`";
		$category_id = $this->db->query($query)->result();
		if (count($category_id) > 1) {
			echo 'You select different group category. please select same group. click here <a href="' . site_url(ADMIN_DIR . "reception") . '" > Home </a>';
			exit();
		}


		$discount = $this->input->post("discount");

		$tax = $this->input->post("tax");
		$refered_by = $this->input->post("refered_by");

		$query = "SELECT SUM(`test_price`) as `total_test_price` 
				FROM `test_groups` 
				WHERE `test_groups`.`test_group_id` IN (" . $test_group_ids . ")";
		$query_result = $this->db->query($query);
		$total_test_price = $query_result->result()[0]->total_test_price;


		$inputs = array();

		$inputs["patient_id"]  =  $patient_id;
		$inputs["discount"]  =  $discount;
		$inputs["price"]  =  $total_test_price;
		$inputs["sale_tax"]  =  $tax;
		$inputs["total_price"]  =  ($total_test_price + $tax) - $discount;
		$inputs["patient_refer_by"]  =  $refered_by;
		$inputs["created_by"]  =  $this->session->userdata('user_id');
		$inputs["category_id"]  =  $category_id[0]->category_id;

		if ($category_id[0]->category_id == 5) {
			$today_count = $this->db->query("SELECT count(*) as total FROM `invoices` 
			WHERE category_id = '" . $category_id[0]->category_id . "'
			AND opd_doctor = '" . $test_group_ids . "'
			AND DATE(created_date) = DATE(NOW())")->result()[0]->total;
			$inputs["opd_doctor"] = $test_group_ids;
			$inputs["patient_refer_by"]  =  1;
		} else {
			$today_count = $this->db->query("SELECT count(*) as total FROM `invoices` 
		               WHERE category_id = '" . $category_id[0]->category_id . "'
					   AND DATE(created_date) = DATE(NOW())")->result()[0]->total;
		}
		$inputs["today_count"]  =  $today_count + 1;

		$invoice_id  = $this->invoice_model->save($inputs);


		$where = "`test_groups`.`test_group_id` IN (" . $test_group_ids . ") ORDER BY `test_groups`.`order`";
		$patient_test_groups = $this->test_group_model->get_test_group_list($where, false);
		foreach ($patient_test_groups as $patient_test_group) {
			$query = "INSERT INTO `invoice_test_groups`(`invoice_id`, `patient_id`, `test_group_id`, `price`) 
				    VALUES ('" . $invoice_id . "', '" . $patient_id . "', '" . $patient_test_group->test_group_id . "', '" . $patient_test_group->test_price . "')";
			$this->db->query($query);
		}


		$test_token_id = time();
		$group_ids = $test_group_ids;

		if ($category_id[0]->category_id == 1) {
			$status = 1;
		} else {
			$status = 3;
		}


		$query = "UPDATE `invoices` 
					SET `test_token_id`='" . $test_token_id . "',
						`test_report_by`='" . $this->session->userdata("user_id") . "',
						`status`='" . $status . "'
					WHERE `invoice_id` = '" . $invoice_id . "'";
		$this->db->query($query);

		// $query = "SELECT 
		// 			  `test_group_tests`.`test_group_id`,
		// 			  `tests`.`test_id`,
		// 			  `tests`.`test_category_id`,
		// 			  `tests`.`test_type_id`,
		// 			  `tests`.`test_name`,
		// 			  `tests`.`test_description`,
		// 			  `tests`.`normal_values` 
		// 			FROM
		// 			  `tests`,
		// 			  `test_group_tests`
		// 			WHERE  `tests`.`test_id` = `test_group_tests`.`test_id` 
		// 			AND `test_group_tests`.`test_group_id` IN (" . $group_ids . ") 
		// 			ORDER BY `test_group_tests`.`test_group_id` ASC, `test_group_tests`.`order` ASC";
		// $query_result = $this->db->query($query);
		// $all_tests = $query_result->result();
		// $order = 1;
		// foreach ($all_tests as $test) {
		// 	$query = "INSERT INTO `patient_tests`(`invoice_id`, 
		// 											  `test_group_id`, 
		// 											  `test_category_id`, 
		// 											  `test_type_id`, 
		// 											  `test_id`, 
		// 											  `test_name`, 
		// 											  `test_normal_value`, 
		// 											  `test_result`, 
		// 											  `remarks`,
		// 											  `created_by`,
		// 											  `order`) 
		// 									VALUES('" . $invoice_id . "',
		// 										   '" . $test->test_group_id . "',
		// 										   '" . $test->test_category_id . "',
		// 											'" . $test->test_type_id . "',
		// 											'" . $test->test_id . "',
		// 											'" . $test->test_name . "',
		// 											'" . $test->normal_values . "',
		// 											'',
		// 											'',
		// 											'" . $this->session->userdata("user_id") . "',
		// 											'" . $order++ . "')";
		// 	$this->db->query($query);
		// }

		$this->session->set_flashdata("msg_success", "Data Save Successfully.");
		redirect(ADMIN_DIR . "reception");
	}


	public function save_and_process()
	{

		$invoice_id = (int) $this->input->post("invoice_id");
		$test_token_id = (int) $this->input->post("test_token_id");
		$group_ids = trim(trim($this->input->post("patient_group_test_ids")), ",");

		$query = "UPDATE `invoices` 
					SET `test_token_id`='" . $test_token_id . "',
						`test_report_by`='" . $this->session->userdata("user_id") . "',
						`status`='2'
					WHERE `invoice_id` = '" . $invoice_id . "'";
		$this->db->query($query);

		$query = "SELECT 
					  `test_group_tests`.`test_group_id`,
					  `tests`.`test_id`,
					  `tests`.`test_category_id`,
					  `tests`.`test_type_id`,
					  `tests`.`test_name`,
					  `tests`.`test_description`,
					  `tests`.`normal_values` 
					FROM
					  `tests`,
					  `test_group_tests`
					WHERE  `tests`.`test_id` = `test_group_tests`.`test_id` 
					AND `test_group_tests`.`test_group_id` IN (" . $group_ids . ") 
					ORDER BY `test_group_tests`.`test_group_id` ASC, `test_group_tests`.`order` ASC";
		$query_result = $this->db->query($query);
		$all_tests = $query_result->result();
		$order = 1;
		foreach ($all_tests as $test) {
			$query = "INSERT INTO `patient_tests`(`invoice_id`, 
													  `test_group_id`, 
													  `test_category_id`, 
													  `test_type_id`, 
													  `test_id`, 
													  `test_name`, 
													  `test_normal_value`, 
													  `test_result`, 
													  `remarks`,
													  `created_by`,
													  `order`) 
											VALUES('" . $invoice_id . "',
												   '" . $test->test_group_id . "',
												   '" . $test->test_category_id . "',
													'" . $test->test_type_id . "',
													'" . $test->test_id . "',
													'" . $test->test_name . "',
													'" . $test->normal_values . "',
													'',
													'',
													'" . $this->session->userdata("user_id") . "',
													'" . $order++ . "')";
			$this->db->query($query);
		}



		redirect(ADMIN_DIR . "reception/");
	}


	public function complete_test()
	{
		$invoice_id = (int) $this->input->post("invoice_id");
		$query = "UPDATE `invoices` 
						SET `status`='3'
						WHERE `invoice_id` = '" . $invoice_id . "'";
		$this->db->query($query);
		redirect(ADMIN_DIR . "reception/");
	}
}