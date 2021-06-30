<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Admin_Controller
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
		$this->load->model("admin/reports_model");
		$this->load->model("admin/invoice_model");
		$this->load->model("admin/test_type_model");


		$this->load->model("admin/patient_model");
		// $this->load->model("admin/patient_model");
		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------



	public function daily_reception_report()
	{

		$this->data = $this->reports_model->daily_reception_report();
		$this->load->view(ADMIN_DIR . "reports/daily_reception_report", $this->data);
	}

	public function monthly_report()
	{

		$this->data['day_wise_monthly_report'] = $this->reports_model->day_wise_monthly_report();
		$this->load->view(ADMIN_DIR . "reports/monthly_report", $this->data);
	}
}
