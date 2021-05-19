<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');


class MY_Controller extends CI_Controller{
    
    public $data = array();
    
    public function __construct(){
		
		
        
        parent::__construct();
        $this->data['site_name'] = config_item("site_name");
        $this->data['errors'] = array();
       // date_default_timezone_set("Asia/karachi");
        
    }
    //-----------------------------------------------------------------------

function sms_jazz($to,$message){
	
	$mobile_number =$to;
	$message = $message;
	$masking='DareWro';
	if(substr($mobile_number,0,1)=='+'){ $mobile_number = str_replace('+','', $mobile_number); }
	if(substr($mobile_number,0,1)==0){   $mobile_number='92'.substr($mobile_number,1); }
	
	//API User name and password..
	$user_name = '03043883037';
	$password = '123.123';
	
	$url ="http://119.160.92.2:7700/sendsms_url.html?Username=".$user_name."&Password=" .$password.
	"&From=".urlencode($masking)."&To=".$to."&Message=".urlencode($message);
	
	//Curl Start
	$ch = curl_init();
	$timeout = 60;
	
	curl_setopt ($ch,CURLOPT_URL, $url) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	var_dump($response);
	$success = false;
	curl_close($ch);

	if($response=='Message Sent Successfully!'){
		$success = true;
	$query="INSERT INTO `sms`( `mobile_number`, `message`,  `sms_status`, `comment`, `date`,`newtwork`) 
				value ( '".$to."', ".$this->db->escape($message).", '1', ".$this->db->escape($response).", '".date("Y-m-d G:i:s", time())."', 'Jazz')";
		$this->db->query($query);
	}else{
		$success = false;
		$query="INSERT INTO `sms`( `mobile_number`, `message`,  `sms_status`, `comment`, `date`, `newtwork`) 
				value ( '".$to."', ".$this->db->escape($message).", '0', ".$this->db->escape($response).", '".date("Y-m-d G:i:s", time())."', 'Jazz')";
		$this->db->query($query);
		}
	 
	 
	 
	 return $success;
	
	exit();

	}
	
	function rider_push_notification($rider_id){
		
		define( 'API_ACCESS_KEY', 'AAAAWItKfJU:APA91bFWm4TI0_1PEuukd5Ypp58MiPSjU0VWsVEkREtcU0dxArPHZ8amCMRww1OaInhEgZ2M2cGTnyomETkDlq-WTSa_Z10RPmnuFWphZKDG3qb8z_QqAwurjttS7MGlFXEZ0Mhkursh');
		$query="SELECT
					`riders`.`mobile_token`
				FROM
				`riders` 
				WHERE `riders`.`rider_id`='".$rider_id."'";
		$query_result = $this->db->query($query);
		$rider_order_detail = $query_result->result()[0];
		
		//notification 1 means order notifications	
		$msg = array('notification_type' => 1,
					 'title' 	=> 'Dear, Rider You Have A New Order',
					 'message'		=> 'Tap here to see the detail of your order');
		$fields = array('registration_ids' 	=> array($rider_order_detail->mobile_token),
						'data'			=> $msg);
		$headers = array('Authorization: key=' . API_ACCESS_KEY,
						 'Content-Type: application/json');
						 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );	
		
		//end here..
		}
	
	
	
	
	function restaurant_push_notification($restaurant_id){
		
		define( 'API_ACCESS_KEY', 'AAAAWItKfJU:APA91bFWm4TI0_1PEuukd5Ypp58MiPSjU0VWsVEkREtcU0dxArPHZ8amCMRww1OaInhEgZ2M2cGTnyomETkDlq-WTSa_Z10RPmnuFWphZKDG3qb8z_QqAwurjttS7MGlFXEZ0Mhkursh');
		$query="SELECT
					`users`.`mobile_token`
				FROM
				`users` 
				WHERE `users`.`restaurant_id`='".$restaurant_id."'";
		$query_result = $this->db->query($query);
		$user_order_detail = $query_result->result()[0];
		
		//notification 1 means order notifications	
		$msg = array('notification_type' => 1,
					 'title' 	=> 'You  have a new order',
					 'message'		=> 'Tap here to see the detail of your order');
		$fields = array('registration_ids' 	=> array($user_order_detail->mobile_token),
						'data'			=> $msg);
		$headers = array('Authorization: key=' . API_ACCESS_KEY,
						 'Content-Type: application/json');
						 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );	
		
		//end here..
		}
	
	
    function push_notification($order_id, $status=0){
		
		define( 'API_ACCESS_KEY', 'AAAAWItKfJU:APA91bFWm4TI0_1PEuukd5Ypp58MiPSjU0VWsVEkREtcU0dxArPHZ8amCMRww1OaInhEgZ2M2cGTnyomETkDlq-WTSa_Z10RPmnuFWphZKDG3qb8z_QqAwurjttS7MGlFXEZ0Mhkursh');
		$query="SELECT
					`users`.`mobile_token`,
					IF(`orders`.`order_status`=1,'Unplaced Order',IF(`orders`.`order_status`=2,'Restaurant Confirmed',IF(`orders`.`order_status`=3,'Rider Assigned',IF(`orders`.`order_status`=4,'Order Delivered',IF(`orders`.`order_status`=5,'Order Cancelled',IF(`orders`.`order_status`=6,'Awating',IF(`orders`.`order_status`=7,'Order Scheduled', 'NULL'))))))) AS `OrderStatus`
				FROM
				`users`,
				`orders` 
				WHERE `users`.`user_id` = `orders`.`created_by`
				AND `orders`.`order_id`='".$order_id."'";
		$query_result = $this->db->query($query);
		$user_order_detail = $query_result->result()[0];
		//notification 1 means order notifications	
		$msg = array('notification_type' => 1,
					 'title' 	=> $user_order_detail->OrderStatus,
					 'message'		=> 'Tap here to see the detail of your order');
		$fields = array('registration_ids' 	=> array($user_order_detail->mobile_token),
						'data'			=> $msg);
		$headers = array('Authorization: key=' . API_ACCESS_KEY,
						 'Content-Type: application/json');
						 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );	
		
		//end here..
		}
	
    function send_sms($to, $from, $message){
	
	$mobile_number =$to;
	$message = $message;
	$masking='DAR E WRO';
	if(substr($mobile_number,0,1)=='+'){ $mobile_number = str_replace('+','', $mobile_number); }
	if(substr($mobile_number,0,1)==0){   $mobile_number='92'.substr($mobile_number,1); }
	
	//API User name and password..
	$user_name = '923123957969';
	$password = '123';
	$wsdl = 'http://cbs.zong.com.pk/reachcwsv2/corporatesms.svc?wsdl';
	$trace = true;
	$exceptions = false;
	$client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
	
	$result = $client->QuickSMS(array('obj_QuickSMS' =>array( 'loginId' => $user_name, 
															  'loginPassword' =>$password,
															  'Destination' => $mobile_number,
															  'Mask' => $masking,
															  'Message' => $message,
															  'UniCode' =>'0',
															  'ShortCodePrefered' => 'n' )));
	$success = false;
	if(substr($result->QuickSMSResult,0,22)=='Submitted Successfully'){
		$success = true;
		$query="INSERT INTO `sms`( `mobile_number`, `message`,  `sms_status`, `comment`, `date`,`newtwork`) 
				value ( '".$to."', ".$this->db->escape($message).", '1', ".$this->db->escape($result->QuickSMSResult).", '".date("Y-m-d G:i:s", time())."', 'Zong')";
		$this->db->query($query);
		}else{
			$success = false;
			$query="INSERT INTO `sms`( `mobile_number`, `message`,  `sms_status`, `comment`, `date`,`newtwork`) 
				value ( '".$to."', ".$this->db->escape($message).", '0', ".$this->db->escape($result->QuickSMSResul).", '".date("Y-m-d G:i:s", time())."', 'Zong')";
		$this->db->query($query);
			}
	
	return $success;
	
	exit();
/*$username = 'darewro';
	$password = 'GulZaR135';
	$url = "http://Lifetimesms.com/plain?username=".$username."&password=" .$password.
	"&to=" .$to. "&from=" .urlencode($from)."&message=" .urlencode($message)."";
	
	//Curl Start
	$ch = curl_init();
	$timeout = 30;
	
	curl_setopt ($ch,CURLOPT_URL, $url) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	$response = explode(":", $response);
	$array["response"] = trim($response[0]);
	$array["message"] = trim($response[1]);
	$success = false;
	if($array["response"]=='OK'){
		$success = true;
	$query="INSERT INTO `sms`( `mobile_number`, `message`,  `sms_status`, `date`) value ( '".$to."', '".$message."', '1', '".date("Y-m-d G:i:s", time())."')";
	$this->db->query($query);
	}else{
		$success = false;
		$query="INSERT INTO `sms`( `mobile_number`, `message`,  `sms_status`, `date`) value ( '".$to."', '".$message."', '0', '".date("Y-m-d G:i:s", time())."')";
		}
	 
	 curl_close($ch);*/
	 
	 //return $success;
	//exit();
	return true;
	}
	
	
function captcha(){
		
		$this->load->helper('captcha');
	$vals = array(
        'word'          => rand(10000, 99999),
        'img_path'      => './assets/captcha/',
        'img_url'       => base_url('/assets/captcha/').'/',
		'font_path' => base_url() . 'system/fonts/texb.ttf',
        'img_width'     => 100,
        'img_height'    => 30,
        'expiration'    => 7200,
        'word_length'   => 5,
        'font_size'     => 24,
        'img_id'        => 'Imageid',
        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

        // White background and border, black text and red grid
        'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(1, 20, 0),
                'grid' => array(255, 40, 40)
        )
);

$cap = create_captcha($vals);

return $cap['image'];
	}
	
	
    
    
    /**
     * upload a file
     * @param $field_name name of the form field
     * @param $config configuration array - this array will be set in
     * controller function where file upload is required
     * if file upload is failed, error will be saved in $data[upload_error]
     * and if upload is successfull, details of the file will be saved in 
     * $data[upload_data]
     * a thumbnail of the file is also created with same file name concatinated
     * with _thumbnail.
     * @return always return true
     */
     public function upload_file($field_name, $config=NULL){
		 if(is_null($config)){
		 $config = array(
                        "upload_path" => "./assets/uploads/".$this->router->fetch_class()."/",
                        "allowed_types" => "jpg|jpeg|bmp|png|gif|mp3",
                        "max_size" => 10000,
                        "max_width" => 0,
                        "max_height" => 0,
                        "remove_spaces" => true,
                        "encrypt_name" => true
                    );
		 }
        
        $dir = $config["upload_path"];
        if(!is_dir($dir)){
            mkdir($dir, 0777);
        }
        
        $this->load->library("upload", $config);
        
        if(!$this->upload->do_upload($field_name)){
            
			 $this->data['upload_error'] = $this->upload->display_errors();
			 return false;         
        }else{
            
            $this->data['upload_data'] = $this->upload->data();
        
            
            //now create image thumbnail
            //if($this->data['upload_data']['is_image'] == true){
                
                $config['image_library'] = 'gd2';
                $config['source_image']	= $dir.$this->data['upload_data']['file_name'];
                $config['create_thumb'] = TRUE;
               //$config['maintain_ratio'] = TRUE;
                $config['width']	= 100;
                $config['height']	= 100;
                
                //$this->load->library('image_lib', $config); 
                $this->image_lib->initialize($config);
                
                $this->image_lib->resize();
            //}
            return true;
        }
        
    }
    //------------------------------------------------------------------------------------
    
    
	
	
	
    
    
    
    /**
     * check allowed file type - custom validation function
     * @param $filename name of the file
     * @return boolean if extension is not allowed
     */
    public function _filetype_validation($str, $filename){
        
        //if the file field is empty
        if(strlen($filename) < 1){
            return true;
        }
        
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = array('jpg', 'png', 'jpeg', 'bmp', 'gif');
        
        if(!in_array($ext, $allowed)){
            $this->form_validation->set_message("_filetype_validation", "$ext file type is not allowed");
            return false;
        }
        return true;
    }
    //---------------------------------------------------------------------------------
    
    
    
    
    /**
     * function for required file type validation
     */
     public function _file_required($str, $filename){
        
        if(strlen($filename) < 1){
            $this->form_validation->set_message("_file_required", "%s is a required field");
            return false;
        }
        return true;
     }
     //-------------------------------------------------------------------------------
   
	

    
}