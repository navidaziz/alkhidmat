<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Reports_model extends MY_Model
{

	public function __construct()
	{

		parent::__construct();
		$this->table = "test_groups";
		$this->pk = "test_group_id";
		$this->status = "status";
		$this->order = "order";
	}
	public function daily_reception_report()
	{
		$query = "SELECT
					`test_categories`.`test_category`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
					, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = DATE(NOW())
					AND `invoices`.`category_id` !=5
					GROUP BY `test_categories`.`test_category`;";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$data["today_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		, COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
					FROM
					`test_categories`
					LEFT JOIN `invoices` 
					ON (`test_categories`.`test_category_id` = `invoices`.`category_id`)
					WHERE DATE(`invoices`.`created_date`) = DATE(NOW())
					AND `invoices`.`category_id` !=5";
		$today_cat_wise_progress_report = $this->db->query($query)->result();
		$data["today_total_cat_wise_progress_reports"] = $today_cat_wise_progress_report;

		$query = "SELECT
					`test_groups`.`test_group_name`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = DATE(NOW())
				GROUP BY `test_groups`.`test_group_name`";
		$today_OPD_report = $this->db->query($query)->result();
		$data["today_OPD_reports"] = $today_OPD_report;

		$query = "SELECT SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
		, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
		, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
		, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND DATE(`invoices`.`created_date`) = DATE(NOW())";
		$today_OPD_report = $this->db->query($query)->result();
		$data["today_total_OPD_reports"] = $today_OPD_report;


		$query = "SELECT
					`test_groups`.`test_group_name`
					, `test_groups`.`test_group_id`
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`total_price`,NULL)) AS total_sum
					, COUNT(IF(`invoices`.`is_deleted`=0,1,NULL)) AS total_count
					, COUNT(IF(`invoices`.`is_deleted`=1,1,NULL)) AS total_receipt_cancelled
					, SUM(IF(`invoices`.`is_deleted`=0,`invoices`.`discount`,NULL)) AS total_discount
		            , COUNT(IF((`invoices`.`is_deleted`=0 AND `invoices`.`discount` > 0) ,1,NULL)) AS total_dis_count
				FROM
				`test_groups`,
				`invoices` 
				WHERE `test_groups`.`test_group_id` = `invoices`.`opd_doctor`
				AND `invoices`.`category_id`=5
				AND `test_groups`.`test_group_id` IN (77,86,104)
				AND DATE(`invoices`.`created_date`) = DATE(NOW())
				GROUP BY `test_groups`.`test_group_name`";
		$income_from_drs = $this->db->query($query)->result();
		$data["income_from_drs"] = $income_from_drs;


		return $data;
	}
}
