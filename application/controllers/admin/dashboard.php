<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller
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
		$this->load->model("admin/patient_test_model");
		$this->load->model("admin/patient_model");
		$this->load->model('admin/reports_model');
		// $this->load->model("admin/patient_model");
		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */
	public function index()
	{
		error_reporting(14);

		//get today data......
		$this->data['today_report'] = $this->reports_model->today_report();
		$this->data['this_month_report'] = $this->reports_model->this_month_report();
		//var_dump($this->data['this_month_report']);
		$this->data["today_OPD_reports"] = $this->reports_model->today_opd_report();
		$this->data["today_total_OPD_reports"] = $this->reports_model->today_total_opd_report();
		$this->data["this_month_OPD_reports"] = $this->reports_model->this_month_opd_report();
		$this->data["this_month_total_OPD_reports"] = $this->reports_model->this_month_total_opd_report();
		//end today data

		//Yearly report 
		$query = "SELECT YEAR(`invoices`.`created_date`) as `year` 
		          FROM `invoices`  GROUP BY YEAR(`invoices`.`created_date`)";
		$result = $this->db->query($query);
		$years_report = $result->result();
		foreach ($years_report as $year_report) {
			$query = "SELECT sum(`total_price`) as `total_income`,
			sum(`discount`) as `discount`,
			sum(`price`) as `price`,
			COUNT(`invoice_id`) as `total_test`
			          FROM `invoices` 
					  WHERE  `status` = 3
					  AND YEAR(`invoices`.`created_date`)= '$year_report->year'";
			$result = $this->db->query($query);
			$year_report->income_per_year = $result->result()[0]->total_income;
			$year_report->discount = $result->result()[0]->discount;
			$year_report->price = $result->result()[0]->price;
			$year_report->total_test = $result->result()[0]->total_test;
			//get expense 
			$query = "SELECT sum(`expense_amount`) as `expenses` 
					  FROM `expenses` 
					 WHERE `expenses`.`status` IN (0, 1) 
					 AND YEAR(`expenses`.`created_date`)= '$year_report->year'";

			$result = $this->db->query($query);
			$year_report->expense_per_year = $result->result()[0]->expenses;
		}
		$this->data['years_report'] = $years_report;

		//Today report
		$today = date("Y-m-d", time());
		$query = "SELECT sum(`total_price`) as `total_income`,
						 sum(`discount`) as `discount`,
						 sum(`price`) as `price`,
						 COUNT(`invoice_id`) as `total_test` 
							   FROM `invoices`
						WHERE  `status` = 3
						AND DATE(`invoices`.`created_date`) = '" . $today . "'";
		$result = $this->db->query($query);
		$total_income = $result->result()[0]->total_income;

		if ($total_income) {
			$this->data['total_income'] = $total_income;
			$this->data['discount'] = $result->result()[0]->discount;
			$this->data['price'] = $result->result()[0]->price;
			$this->data['total_test'] = $result->result()[0]->total_test;
		} else {
			$this->data['total_income'] = 0;
			$this->data['discount'] = 0;
			$this->data['price'] = 0;
			$this->data['total_test'] = 0;
		}

		//today expense 
		$query = "SELECT sum(`expense_amount`) as total_expenses 
					FROM `expenses` WHERE `expenses`.`status` IN (0, 1) 
					AND DATE(`expenses`.`created_date`) = DATE(NOW())";
		$result = $this->db->query($query);
		$total_expenses = $result->result()[0]->total_expenses;
		if ($total_expenses) {
			$this->data['total_expenses'] = $total_expenses;
		} else {
			$this->data['total_expenses'] = 0;
		}

		// today expense types
		$query = "SELECT 
				 `expense_types`.`expense_type`,
				 SUM(`expenses`.`expense_amount`) as expense_total 
				 FROM
				 `expense_types`,
				 `expenses` 
				 WHERE `expense_types`.`expense_type_id` = `expenses`.`expense_type_id`
				 AND DATE(`expenses`.`created_date`) = DATE(NOW())
				 GROUP BY `expense_types`.`expense_type` ";
		$query_result = $this->db->query($query);
		$this->data['today_expenses'] = $query_result->result();

		//this expense 
		$query = "SELECT sum(`expense_amount`) as total_expenses 
					FROM `expenses` WHERE `expenses`.`status` IN (0, 1) 
					AND YEAR(`expenses`.`created_date`) = YEAR(NOW())
					AND MONTH(`expenses`.`created_date`) = MONTH(NOW())";
		$result = $this->db->query($query);
		$total_expenses = $result->result()[0]->total_expenses;
		if ($total_expenses) {
			$this->data['this_month_total_expenses'] = $total_expenses;
		} else {
			$this->data['this_month_total_expenses'] = 0;
		}

		// today expense types
		$query = "SELECT 
				 `expense_types`.`expense_type`,
				 SUM(`expenses`.`expense_amount`) as expense_total 
				 FROM
				 `expense_types`,
				 `expenses` 
				 WHERE `expense_types`.`expense_type_id` = `expenses`.`expense_type_id`
				 AND YEAR(`expenses`.`created_date`) = YEAR(NOW())
				AND MONTH(`expenses`.`created_date`) = MONTH(NOW())
				 GROUP BY `expense_types`.`expense_type` ";
		$query_result = $this->db->query($query);
		$this->data['this_month_expenses'] = $query_result->result();

		//Monthly report

		$month = date("m", time());
		$year = date("Y", time());
		$today = date("d", time());


		// get current month expense types
		$query = "SELECT 
		`expense_types`.`expense_type`,
		SUM(`expenses`.`expense_amount`) as expense_total 
		FROM
		`expense_types`,
		`expenses` 
		WHERE `expense_types`.`expense_type_id` = `expenses`.`expense_type_id`
		AND YEAR(`expenses`.`created_date`) = '" . $year . "' 
		AND  MONTH(`expenses`.`created_date`) = '" . $month . "' 
		GROUP BY `expense_types`.`expense_type` ";
		$query_result = $this->db->query($query);
		$this->data['expense_types'] = $query_result->result();


		$month_income_expence_report = array();

		for ($month = 1; $month <= 12; $month++) {
			$date_query = $year . "-" . $month . "-1";

			//Get income 
			$query = "SELECT sum(`total_price`) as `total_income`,
			sum(`discount`) as `discount`,
			sum(`price`) as `price`,
			COUNT(`invoice_id`) as `total_test` FROM `invoices`
						  WHERE  YEAR(`invoices`.`created_date`) = '" . $year . "' 
						  AND  MONTH(`invoices`.`created_date`) = '" . $month . "'
						  AND `status` = 3";

			$query_result = $this->db->query($query);
			$DateQuery = date("F, Y", strtotime($date_query));
			if ($query_result->result()[0]->total_income) {
				$month_income_expence_report[$DateQuery]['income'] = $query_result->result()[0]->total_income;
				$month_income_expence_report[$DateQuery]['discount'] = $query_result->result()[0]->discount;
				$month_income_expence_report[$DateQuery]['price'] = $query_result->result()[0]->price;
				$month_income_expence_report[$DateQuery]['total_test'] = $query_result->result()[0]->total_test;
			} else {
				$month_income_expence_report[$DateQuery]['income'] = 0;
				$month_income_expence_report[$DateQuery]['discount'] = 0;
				$month_income_expence_report[$DateQuery]['price'] = 0;
				$month_income_expence_report[$DateQuery]['total_test'] = 0;
			}

			//get Expences 	
			$query = "SELECT SUM(`expense_amount`) as total_expense 
			          FROM `expenses` 
					  WHERE `expenses`.`status` IN (0, 1) 
					  AND YEAR(`expenses`.`created_date`) = '" . $year . "' 
					  AND  MONTH(`expenses`.`created_date`) = '" . $month . "'";
			$query_result = $this->db->query($query);

			if ($query_result->result()[0]->total_expense) {
				$month_income_expence_report[$DateQuery]['expense'] = $query_result->result()[0]->total_expense;
			} else {
				$month_income_expence_report[$DateQuery]['expense'] = 0;
			}

			$month_income_expence_report[$DateQuery]['net_income'] = ($month_income_expence_report[$DateQuery]['income'] - $month_income_expence_report[$DateQuery]['expense']);
		}
		$this->data['month_income_expence_report'] = $month_income_expence_report;

		//day wise monthly Report

		$month = date("m", time());
		$year = date("Y", time());
		error_reporting(14);

		for ($day = 1; $day <= $today; $day++) {
			$date_query = $year . "-" . $month . "-" . $day;


			$query = "SELECT *, (`i`.`lab` + `i`.`ecg` + `i`.`ultrasound` + `i`.`x_ray` + `i`.`dr_naila` + `i`.`dr_shabana` + `i`.`dr_shabana_us_doppler`) as total, 
			        `i`.`discount` FROM `invoices_data` as i WHERE   DATE(`i`.`created_date`) = '" . $date_query . "'";
			$query_result = $this->db->query($query);
			$DateQuery = date("d M, Y", strtotime($date_query));
			$result = $query_result->result();
			if ($result) {
				$income_expence_report[$DateQuery] = $result[0];
			}

			//get Expences 	
			$query = "SELECT SUM(`expense_amount`) as total_expense FROM `expenses` 
					  WHERE `expenses`.`status` IN (0, 1) 
					  AND DATE(`expenses`.`created_date`) = '" . $date_query . "'";
			$query_result = $this->db->query($query);
			$result = $query_result->result();

			if ($result) {
				@$income_expence_report[$DateQuery]->expense = $result[0]->total_expense;
			} else {
				$income_expence_report[$DateQuery]->expense = 0;
			}
			//$this->data['income_expence_report'] = $income_expence_report;
		}


		$this->data['income_expence_report'] = $income_expence_report;

		$query = "SELECT COUNT(`invoices`.`test_report_by`) AS total_refered, 
				(SELECT COUNT(`i`.`test_report_by`) 
				FROM `invoices` AS `i` 
				WHERE `i`.`patient_refer_by` = `invoices`.`patient_refer_by`
				AND DATE(`i`.created_date) = DATE(CURRENT_DATE())
				AND MONTH(`i`.created_date) = MONTH(CURRENT_DATE())
				AND YEAR(`i`.created_date) = YEAR(CURRENT_DATE())
				AND `i`.`status` = 3
				GROUP BY `i`.`patient_refer_by`) AS total_refered_today, 
				(SELECT COUNT(`i`.`test_report_by`) 
				FROM `invoices` AS `i` 
				WHERE `i`.`patient_refer_by` = `invoices`.`patient_refer_by`
				AND MONTH(`i`.created_date) = MONTH(CURRENT_DATE())
				AND YEAR(`i`.created_date) = YEAR(CURRENT_DATE())
				AND `i`.`status` = 3
				GROUP BY `i`.`patient_refer_by`) AS total_refered_current_month,
				(SELECT COUNT(`i`.`test_report_by`) 
				FROM `invoices` AS `i` 
				WHERE `i`.`patient_refer_by` = `invoices`.`patient_refer_by`
				AND MONTH(`i`.created_date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
				AND YEAR(`i`.created_date) = YEAR(CURRENT_DATE())
				AND `i`.`status` = 3
				GROUP BY `i`.`patient_refer_by`) AS total_refered_previous_month, 
					`doctors`.`doctor_name`
					, `doctors`.`doctor_designation`
				FROM `doctors`,
				`invoices` 
				WHERE `doctors`.`doctor_id` = `invoices`.`patient_refer_by`
				AND `invoices`.`status` = 3
				GROUP BY `invoices`.`patient_refer_by`
				ORDER BY total_refered DESC";
		$doctors_refereds = $this->db->query($query)->result();
		$this->data['doctors_refereds'] = $doctors_refereds;

		$this->data["view"] = ADMIN_DIR . "dashboard/dashboard";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
}
