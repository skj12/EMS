<?php

class Dashboard extends CI_Controller
{
	function __construct() {
			parent::__construct();
			$this->load->helper(array('form','url'));
			$this->load->library(array('session','form_validation','uri'));
			$this->load->database();
			$this->load->model('dashboardmodel');
		}

	public function index() {
			if(null!=($this->session->userdata('adminid'))){
				$admin_id = $this->session->userdata('adminid');
				$company_id = $this->dashboardmodel->get_companyid($admin_id);	
				$data['active_employees'] = $this->dashboardmodel->count_employees($company_id);
				$week['0']['date'] = date('Y-m-d');
				$week['0']['day'] = date('l',strtotime($week['0']['date']));
				$week['0']['display_date'] = date('(d M)',strtotime($week['0']['date']));
				$week['0']['employees_present'] = $this->dashboardmodel->count_present_employees($company_id,$week['0']['date']);
				for($i=1;$i<=6;$i++){
						$week[$i]['date'] = date('Y-m-d',strtotime("-$i days"));
						$week[$i]['day'] = date('l',strtotime($week[$i]['date']));
						$week[$i]['display_date'] = date('(d M)',strtotime($week[$i]['date']));
						$week[$i]['employees_present'] = $this->dashboardmodel->count_present_employees($company_id,$week[$i]['date']);
					}
				$data['attendance_record'] = $week;
				$this->load->view('admindashboard',$data);
			}else{
				redirect('user/login');
			}
	}

	public function init_mail(){
		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'subham3996@gmail.com',
		    'smtp_pass' => 'subham@@3996',
		    'charset'   => 'utf-8',
		    'mailtype'  => 'html',
		    'starttls'  => true,
		    'newline'   => "\r\n"
		);
		$this->load->library('email', $config);
	}


	public function sendmail($subject , $msgbody , $emailto){
		
			        $message = '<!DOCTYPE html>
			        <html>
			        <head>
			        	<title>Email</title>
			        </head>
			        <body>
			        '.$msgbody.'
			        </body>
			        </html>';
			    
			      $this->email->from('EMS'); 
			      $this->email->to($emailto);
			      $this->email->subject($subject);
			      $this->email->message($message);
			      if($this->email->send())
			     {
			      $datareturn = 'Sent';
			     }
			     else
			    {
			    $datareturn = show_error($this->email->print_debugger());
			    }
			    return $datareturn;

	}

	public function verify_mail(){
		if($this->session->userdata('emailunverified')==1){

				$this->load->view('verify_mail');
			}else{
				redirect('user/login');
			}

		
	}

	public function invite(){
		
		$this->load->view('email_invite');
	}

	public function do_upload(){
		$config['upload_path']          = './assets/csv/';
		$config['allowed_types']        = 'csv';
		$config['max_size']             = 10000;

		$this->load->library('upload', $config);
		$adminid = $this->session->userdata('adminid');
		$companyid = $this->dashboardmodel->get_companyid($adminid);	
		if ( $this->upload->do_upload('csvfile')){
			$uploaddata = $this->upload->data();
			$filename = $uploaddata['file_name'];
			$link = base_url('assets/csv/'.$filename);
			$data = fopen($link,"r");
			
			$subject = "EMS Account Invitation";
			$name = '';	
			$companyname = $this->dashboardmodel->get_companyname($companyid);
			$weblink = base_url('');
			$invitelin=  base_url('user/reg');

			$part1 = "<div> Hello ";
			$part2 = " ,<br><br>
			 You have been invited by ".$companyname." to create your account on EMS .<br>
			Please create your account on EMS by clicking on the following link : <br>
			<a href='";
			$part3 = "'> Accept Invitation </a>.<br>
			If you have any questions , please contact us on ".$weblink."
			<br> Regards ,<br>EMS Team
			</div>";
			while($dataa = fgetcsv($data,"1000",",")){

			$name = $dataa['0'];
			$emailto = $dataa['1'];
			$tobehashed = $companyid.$emailto;
			$hash = md5($tobehashed);
			$invitelink = $invitelin."/".$hash;
			
			$msgbody = $part1.$name.$part2.$invitelink.$part3;
			

			$this->init_mail();
			$this->sendmail($subject , $msgbody , $emailto);

			if($this->dashboardmodel->send_invite($emailto,$companyid,$hash)){
				echo $name." is invited"."<br>";
			}


			}
			unlink('assets/csv/'.$filename);
						
		}else{
			$error = array('error' => $this->upload->display_errors());
			
			print_r($error);	
		}

	}
	public function single_invite() {
			$full_name = $this->input->post('name');
			$email = $this->input->post('email');
			$admin_id = $this->session->userdata('adminid');
			$company_id = $this->dashboardmodel->get_companyid($admin_id);
			$subject = "EMS Account Invitation";
			$name = '';	
			$company_name = $this->dashboardmodel->get_companyname($company_id);
			$web_link = base_url('');
			$invite_link=  base_url('user/reg');

			$part1 = "<div> Hello ";
			$part2 = " ,<br><br>
			 You have been invited by ".$company_name." to create your account on EMS .<br>
			Please create your account on EMS by clicking on the following link : <br>
			<a href='";
			$part3 = "'> Accept Invitation </a>.<br>
			If you have any questions , please contact us on ".$web_link."
			<br> Regards ,<br>EMS Team
			</div>";
			$name = $full_name;
			$email_to = $email;
			$tobehashed = $company_id.$email_to;
			$hash = md5($tobehashed);
			$invite_link = $invite_link."/".$hash;
			
			$msg_body = $part1.$name.$part2.$invite_link.$part3;
			

			$this->init_mail();
			$this->sendmail($subject , $msg_body , $email_to);	
			if($this->dashboardmodel->send_invite($email_to,$company_id,$hash)){
				echo $name." is invited"."<br>";
			}
			else {
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			}
	}
	
	public function attendance() {
			$admin_id   = $this->session->userdata('adminid');
			$company_id = $this->dashboardmodel->get_companyid($admin_id);
			$user_id    = $this->dashboardmodel->get_userid($company_id);
			$i = 0;
			foreach ($user_id as $row) {
				$uid = $row->id;
				$temp_data = $this->dashboardmodel->get_user_name($uid);
				$employee_id = $this->dashboardmodel->get_employee_id($uid);
				if($attendance = $this->dashboardmodel->get_employee_attendance($employee_id)){
					$single_row['employee_id'] = $attendance['0']->employee_id;
				}
				$single_row['first_name'] = $temp_data['0']->first_name;
				$single_row['last_name'] = $temp_data['0']->last_name;
				$data['x'][$i] = $single_row;
				$i++;
			}
			
			$this->load->view('attendance',$data);
			
	}
	public function upload_attendance() {
			$this->load->view('upload_attendance');

	}
	public function xls_upload() {
			$config['upload_path'] = './assets/xls/';
			$config['allowed_types'] = 'xls';
			$config['max_size']  = 2500000;
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			if($this->upload->do_upload('file')) {
				$data = $this->upload->data();
				@chmod($data['full_path'], 0777);
				$this->load->library('Spreadsheet_Excel_Reader');
				$this->spreadsheet_excel_reader->read($data['full_path']);
				$sheets = $this->spreadsheet_excel_reader->sheets[0];
				error_reporting(0);
				//error_reporting(E_ALL ^ E_NOTICE);
				$data_excel = array();
				$array_data = $sheets['cells'];
				$column_field = $array_data['1']['1'];
				unset($array_data['1']);
				$admin_id = $this->session->userdata('adminid');
				$company_id = $this->dashboardmodel->get_companyid($admin_id);
				foreach ($array_data as $row) {
						$in_datetime = $row['3'];
						$in_time = explode(" ", $in_datetime);
						$out_datetime = $row['4'];
						$out_time = explode(" ", $out_datetime);
						$temp_id =  $column_field.$row['1'];
						if( $user_id = $this->dashboardmodel->validate_employee($temp_id)){
						$dataa = array(

							'date' => $in_time['0'],
							'check_in' => $in_time['1'],
							'check_out' => $out_time['1'],
							'employee_id' => $$column_field.$row['1'],
							'status' => 'P',
							'user_id'=>$user_id,
							'company_id' => $company_id
						);
					$this->dashboardmodel->attendance($dataa);
					}
				}
				redirect('dashboard');
			}
			else {
				redirect('dashboard/upload_attendance');
		}
	}
	public function add_announcement() {
		$this->load->view('add_announcement');
	}
	public function announcement_data() {
		$post  = $this->input->post();
		$this->form_validation->set_rules('announcement','Announcement','required');
		$this->form_validation->set_rules('display','date_till_display','required');
		if ($this->form_validation->run()) {
			$admin_id = $this->session->userdata('adminid');
			$company_id = $this->dashboardmodel->get_companyid($admin_id);
			$data = array(
				'announcement' => $post['announcement'],
				'creation_date' => date('Y-m-d H:i:s',time()),
				'date_till_display' => $post['display'],
				'company_id' =>	$company_id
			);
			if($this->dashboardmodel->add_announcement($data)) {
				redirect('dashboard/announcement');
			}
			else {
				redirect('dashboard/add_announcement');
			}
		}
		else {
			redirect('dashboard/add_announcement');
		}

	}
	public function announcement() {
		$admin_id = $this->session->userdata('adminid');
		$company_id = $this->dashboardmodel->get_companyid($admin_id);
		$data['x'] = $this->dashboardmodel->announcement($company_id);
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('announcement',$data);
	}
	
	public function edit_announcement() {
		if ($this->uri->segment(1) === FALSE){
        	$id = 0;
		}
		else{
        	$id = $this->uri->segment(3);
		}
		if($id!=NULL) {
			$admin_id = $this->session->userdata('adminid');
			$company_id = $this->dashboardmodel->get_companyid($admin_id);
			$data['x'] = $this->dashboardmodel->get_announcement($id);
			$data['id'] = $id;
			$this->load->view('edit_announcement',$data);
		}
	}
	public function update_announcement() {
		if ($this->uri->segment(1) === FALSE){
        	$id = 0;
		}
		else{
        	$id = $this->uri->segment(3);
		}
		if($id!=NULL) {
			$post  = $this->input->post();
			$this->form_validation->set_rules('announcement','Announcement','required');
			$this->form_validation->set_rules('display','date_till_display','required');
			if ($this->form_validation->run()) {
				$data = array(
					'announcement' => $post['announcement'],
					'creation_date' => date('Y-m-d H:i:s',time()),
					'date_till_display' => $post['display']	
				);
				if($this->dashboardmodel->update_announcement($data,$id)){
					redirect('dashboard/announcement');
				}
				else {
					redirect('dashboard/edit_announcement/'.$id);
				}
			}
		}
		else {
			redirect('dashboard/add_announcement');
		}
	}
	public function delete_announcement() {
		if ($this->uri->segment(1) === FALSE){
        	$id = 0;
		}
		else{
        	$id = $this->uri->segment(3);
		}
		if($id!=NULL) {
			if($this->dashboardmodel->delete_announcement($id)) {
				redirect('dashboard/announcement');
			}
		}
	}
	public function organization() {
		$this->load->view('organization');
	}
	public function EmpDetails() {
		$userid = $this->session->userdata('adminid');
		$compid = $this->dashboardmodel->get_companyid($userid);
		$q		=  $this->dashboardmodel->get_userid($compid);
		foreach ($q as $row) {
			 $uid  = $row->id;
			if($z = $this->dashboardmodel->empdetails($uid)){
			 $data[]= $z;
			}
		}
		$view['data'] = $data;
		$this->load->view('EmpDetails',$view);
	}

	public function designations(){
		$adminid = $this->session->userdata('adminid');
		$companyid = $this->dashboardmodel->get_companyid($adminid);
		if($q = $this->dashboardmodel->get_designations_list($companyid)){
			$data['q'] = $q;
			
		}else{
			$data['data'] = "No designations are registered till now . Kindly add a new designation for your organization";
		}
		if($q = $this->dashboardmodel->get_team_list($companyid)){
			$x = array();
			$x['0" disabled="disabled'] = '--------Select Team -------';
			foreach ($q as $team) {
				$x[$team->id] = $team->name; 
			}
			$teams = $x;
		}
		$data['companyid'] =$companyid;
		if(isset($teams)){
			$data['teams'] = $teams;
		}else{
			$data['msg'] = "There are not teams registered till now .<br>To add new designations , you need to add a new team/s <br><a href='".base_url('dashboard/teams')."'> Add new team </a>";
		}
			$this->load->view('designations_form',$data);
		
	}

	public function add_designation(){
		$designation = $this->input->post('designation');
		$team = $this->input->post('team');
		if(isset($designation) and $team!=0){
			$companyid = $this->input->post('company_id');
			$this->dashboardmodel->add_designation($designation,$companyid,$team);
			
			redirect('dashboard/designations');
		}
		redirect('dashboard/designations');
	}

	public function displayempdetails() {
		if ($this->uri->segment(1) === FALSE){
        	$user_id = 0;
		}
		else{
        	$user_id = $this->uri->segment(3);
		}
		if($user_id!=NULL) {
				$admin_id  = $this->session->userdata('adminid');
				$company_id = $this->dashboardmodel->get_companyid($admin_id);
				$company_name = $this->dashboardmodel->get_companyname($company_id);
				$q  =  $this->dashboardmodel->fetchdata($user_id);
				if ($q) {
					$x['joining_date'] = $q[0]->joining_date;
					$x['employee_id'] = $q[0]->employee_id;
					$x['confirmation_date'] = $q[0]->confirmation_date;
					$x['effective_from'] = $q[0]->effective_from;
					$x['effective_to'] = $q[0]->effective_to;
					$x['designation'] = $q[0]->designation;
					$x['name']   = $this->dashboardmodel->get_designationname($x['designation']);
					$data['x']= $x;
					
				}
				else {
					
						 $q['employee_id'] = 'NULL';
						 $q['joining_date'] = 'NULL';
						 $q['confirmation_date'] = 'NULL';
						 $q['effective_from'] = 'NULL';
						 $q['effective_to'] = 'NULL';
						 $q['designation'] = 'NULL';
						$data['x'] = $q;
				}	
				
					$data['x']['user_id'] = $user_id;
					$data['company_name'] = $company_name;
					//$this->load->view('displayempdetails',$data);
			// DISPLAY PERSNOAL INFORMATION	
			$data['Email'] = $this->dashboardmodel->get_adminemail($user_id);
			$data['x']['p']  = $this->dashboardmodel->select($user_id);
			// echo "<pre>";
			// print_r($data);
			// die();
			$this->load->view('displayempdetails',$data);
		}


			
		    
		}
	public function editempdetails() {

		if ($this->uri->segment(1) === FALSE){
        	$user_id = 0;
		}
		else{
        	$user_id = $this->uri->segment(3);
		}
		if($user_id!=NULL) {

				$admin_id  = $this->session->userdata('adminid');
				$company_id = $this->dashboardmodel->get_companyid($admin_id);
				$company_name = $this->dashboardmodel->get_companyname($company_id);
				$q  =  $this->dashboardmodel->fetchdata($user_id);
				
				if ($q) {
					$x['joining_date'] = $q[0]->joining_date;
					$x['employee_id'] = $q[0]->employee_id;
					$x['confirmation_date'] = $q[0]->confirmation_date;
					$x['effective_from'] = $q[0]->effective_from;
					$x['effective_to'] = $q[0]->effective_to;
					$x['designation'] = $q[0]->designation;
					$data['x']= $x;
				}
				else {
					
						 $q['employee_id'] = 'NULL';
						 $q['joining_date'] = 'NULL';
						 $q['confirmation_date'] = 'NULL';
						 $q['effective_from'] = 'NULL';
						 $q['effective_to'] = 'NULL';
						 $q['designation'] = 'NULL';
						 $data['x'] = $q;
				}
				if($m = $this->dashboardmodel->get_designations_list($company_id)){
						$y = array();
						$y['0" disabled="disabled'] = '--------Select Designation -------';
						foreach ($m as $des) {
								$y[$des->id] = $des->name; 
							}
						$designation = $y;
				}
					$data['designations'] = $designation;
					$data['x']['user_id']=$user_id;
					$data['company_name'] = $company_name;
					$data['Email'] = $this->dashboardmodel->get_adminemail($user_id);
					$data['x']['p']  = $this->dashboardmodel->select($user_id);
					$this->load->view('editempdetails',$data);
		}	
	}
	public function editdata() {
		if ($this->uri->segment(1) === FALSE){
        	$user_id = 0;
		}
		else{
        	$user_id = $this->uri->segment(3);
		}
		if($user_id!=NULL) {
				$post = $this->input->post();

						$this->form_validation->set_rules('empid','employee_id','required');
						$this->form_validation->set_rules('jdate','joining_date','required');
						$this->form_validation->set_rules('cdate','confirmation_date','required');
						$this->form_validation->set_rules('efrom','effective_from','required');
						$this->form_validation->set_rules('eto','effective_to','required');
						$this->form_validation->set_rules('designations','designation','required');
						if($this->form_validation->run()) {
							$data = array(
								 'employee_id' => $post['empid'],
								 'joining_date' => $post['jdate'],
								 'confirmation_date' => $post['cdate'],
								 'effective_from' => $post['efrom'],
								 'effective_to' => $post['eto'],
								 'designation' => $post['designations']
							);
							
							$data['user_id'] = $user_id;
							if($this->dashboardmodel->updatedata($data)) {
								//print_r("update successfully");
								redirect('dashboard/displayempdetails/'.$user_id);
							}

						}
						else {
							redirect('dashboard/editempdetails/'.$user_id);
						}
		}
	}
	public function update_personal_info() {
		if ($this->uri->segment(1) === FALSE){
        	$user_id = 0;
		}
		else{
        	$user_id = $this->uri->segment(3);
		}
		if($user_id!=NULL) {
				$post = $this->input->post();

				$this->form_validation->set_rules('contact','Address','required');
				$this->form_validation->set_rules('email','Email','required');
				$this->form_validation->set_rules('fname','First Name','required');
				$this->form_validation->set_rules('lname','Last Name','required');
				$this->form_validation->set_rules('add1','Address','required');
				$this->form_validation->set_rules('add2','Address','required');
				$this->form_validation->set_rules('city','City','required');
				$this->form_validation->set_rules('state', 'State','required');
				$this->form_validation->set_rules('pin', 'PinCode', 'required');
				$this->form_validation->set_rules('blood', 'BloodGroup', 'required');
				$this->form_validation->set_rules('gender','Gender','required');
				$this->form_validation->set_rules('MartailStatus','MartailStatus','required');
				$this->form_validation->set_rules('dob','DOB','required');
				$this->form_validation->set_rules('dis','Disability','required');
				$this->form_validation->set_rules('pan','PanNumber','required');
				$this->form_validation->set_rules('aadhar','AadharNumber','required');
				$this->form_validation->set_rules('pname','FatherName','required');
				$this->form_validation->set_rules('ps','ParentsSeniority','required');
				$this->form_validation->set_rules('pd','ParentsDisability','required');
				$this->form_validation->set_rules('children','Children','required');
				$this->form_validation->set_rules('hc','HostelerChildren','required');
				$this->form_validation->set_rules('submit','Submit','required');
				if($this->form_validation->run()) {
				 			$data = array(
								'first_name' => $post['fname'],
								'last_name' => $post['lname'],
								'contact_no' => $post['contact'],
								'blood_group' => $post['blood'],
								'disability' => $post['dis'],
								'dob' => $post['dob'],
								'martail_status' => $post['MartailStatus'],
								'gender' => $post['gender'],
								'address_1' => $post['add1'],
								'address_2' => $post['add2'],
								'city' => $post['city'],
								'state' => $post['state'],
								'pin_code' => $post['pin'],
								'pan_no' => $post['pan'],
								'aadhaar_nO' => $post['aadhar'],
								'father_name' => $post['pname'],
								'parents_seniority' => $post['ps'],
								'parents_disability' => $post['pd'],
								'children' => $post['children'],
								'hosteler_children' => $post['hc']
			 					);
				 			$data['user_id'] = $user_id;
				 			$email = $post['email'];
				 			if($this->dashboardmodel->update_personal_info($data,$email)) {
				 				redirect('dashboard/displayempdetails/'.$user_id);
				 			}
				 			else {
				 				redirect('dashboard/editempdetails/'.$user_id);
				 			}
				}
		}
	}
				 			
				
		
	public function teams(){
		$adminid = $this->session->userdata('adminid');
		$companyid = $this->dashboardmodel->get_companyid($adminid);
		if($q = $this->dashboardmodel->get_team_list($companyid)){
			$data['q'] = $q;
			
		}else{
			$data['data'] = "No teams/departments are registered till now . Kindly add a new team/department for your organization";
		}
		$data['companyid'] =$companyid;
			$this->load->view('team_form',$data);
		
	}

	public function add_team(){
		$team = $this->input->post('team');
		if(isset($team)){
			$companyid = $this->input->post('company_id');
			$this->dashboardmodel->add_team($team,$companyid);
			
			redirect('dashboard/teams');
		}
		redirect('dashboard/teams');

	}
	public function img_upload(){
		//print_r($img);
		//die();
		$config['upload_path']          = './assets/img/user/';
		$config['allowed_types']        = 'jpg|png|gif|jpeg';
		$config['max_size']             = 10000;
		//print_r($config['upload_path']);
		//die();
		$this->load->library('upload', $config);
		if($this->upload->do_upload('img')){
			$uploaddata = $this->upload->data();
			$filename = $uploaddata['file_name'];
			return  $filename;
			}
			else{
			$error = array('error' => $this->upload->display_errors());
			
			print_r($error);	
		}
	}
	public function img_update(){
			$user_id = $this->input->post('user_id');
			$img = $this->img_upload();
			if($this->dashboardmodel->img_update($user_id,$img)) {
				redirect('dashboard/displayempdetails/'.$user_id);
			}
			else {
				redirect('dashboard/editempdetails/'.$user_id);
			}
		
	}
	public function switch_user() {
		if(null!=($this->session->userdata('adminid'))){
				$user_id = $this->session->userdata('adminid');
				$this->session->set_userdata('logid',$user_id);
				$this->session->set_userdata('switched','1');
				$this->session->unset_userdata('adminid');
				redirect('user_dashboard');
			}
			else {
				redirect('user/login');
			}
	}
	public function leave() {
		 $admin_id = $this->session->userdata('adminid');
		 $company_id = $this->dashboardmodel->get_companyid($admin_id);
		 if($q = $this->dashboardmodel->get_leave_category($company_id)){
		 	$data['q'] = $q;
		 	// echo "<pre>"
		 	// print_r($data);
		 	// die();
			
		 }else {
		 	$data['data'] = "No Leave Category are Entered till now . Kindly add Categories for Leave";
		 }

		$this->load->view('leave',$data);
	}
	public function add_category() {
		$category = $this->input->post('category');
		$company_id = $this->input->post('company_id');
		if($this->dashboardmodel->add_category($category,$company_id)) {
			redirect('dashboard/leave');
		}
		else {
			redirect('dashboard/leave');
		}
	}
}
?>
