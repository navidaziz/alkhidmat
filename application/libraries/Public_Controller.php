<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Public_Controller extends MY_Controller{
    
    public $controller_name = "";
    public $method_name = "";
	
    public function __construct(){
		
		 parent::__construct();
		$this->load->helper("my_functions");
	/*	$this->load->model("admin/system_global_setting_model");
		$this->load->model("admin/menu_sub_page_model");
		$this->lang->load("system", 'english');
		$this->lang->load("home_page", 'english');
		$this->lang->load("slider_banners", 'english');
		$this->load->model("admin/service_model");
		$this->lang->load("services", 'english');
		$this->load->model("admin/testimonial_model");
		$this->lang->load("testimonials", 'english');
		$this->load->model("admin/why_choose_us_model");
		$this->lang->load("why_choose_us", 'english');
		$this->load->model("admin/home_page_model");
		$this->load->model("admin/slider_banner_model");
		$this->load->model("admin/gallery_model");
		$this->lang->load("gallery", 'english');
		$this->lang->load("contact_us_page", 'english');
		  
		 
		  $this->load->model("admin/menu_page_model");
		 $system_global_setting_id = 1;
		 $fields = "";
		 $join_table = array();
		 $where = "system_global_setting_id = $system_global_setting_id";
		 $this->data["system_global_settings"] = $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where, false, true)[0];
		 //get menu pages
		 
		$where = "`menu_pages`.`status` IN (0, 1) ORDER BY `menu_pages`.`order`";
		$this->data["menu_pages"] = $this->menu_page_model->get_menu_page_list($where, FALSE);
		
		foreach($this->data["menu_pages"] as $menu_page){
			$where = "`menu_sub_pages`.`status` IN (0, 1) AND `menu_sub_pages`.`menu_page_id` =".$menu_page->menu_page_id." ORDER BY `menu_sub_pages`.`order`";
			$menu_page->menu_sub_pages = $this->menu_sub_page_model->get_menu_sub_page_list($where, FALSE);
			
			}
		//social media icons 
		$this->load->model("admin/social_media_icon_model");
			$where = "`status` IN (1) ORDER BY `order`";
		$this->data["social_media_icons"] = $this->social_media_icon_model->get_social_media_icon_list($where,FALSE);
		 		
		$this->data['page_description'] = "Page Description"; 
		$this->data['page_title'] = "Page Name";	
		//var_dump($this->data["menu_pages"]);	
		
		
		
				$query ="SELECT DISTINCT  `gener_title` , COUNT(  `gener_title` ) AS total 
		FROM  `movie_genre` 
		GROUP BY gener_title
		ORDER BY gener_title ASC";
		$query_result = $this->db->query($query);
		
		$this->data['movies_geners'] = $query_result->result(); 
		
		
		
		
		$query ="SELECT DISTINCT FORMAT( FLOOR(  `rating` ) , 0 ) AS rating
		FROM  `movies` 
		ORDER BY  `rating` DESC ";
		$query_result = $this->db->query($query);
		
		$this->data['movies_rating'] = $query_result->result(); 
		
		
		
		$query ="SELECT DISTINCT  `year` , COUNT(  `year` ) AS total
		FROM  `movies` 
		GROUP BY  `year` 
		ORDER BY  `year` DESC";
		$query_result = $this->db->query($query);
		
		$this->data['movies_years'] = $query_result->result(); 
		
		*/

		
		
       
    }
	
    
    
}