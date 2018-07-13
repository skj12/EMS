<?php 
	class Dashboardmodel extends CI_Model {

		public function get_companyid( $adminid ){

			$q = $this->db->where(['user_id'=>$adminid])
							->get(ADMIN);

			if( $q->num_rows()==1){
				return $q->row()->company_id;
			}
			else{
				return False;
			}
		}

		public function get_companyname($companyid){
			$q = $this->db->where(['id'=>$companyid])
							->get(COMPANY);			
			if( $q->num_rows()==1){
				return $q->row()->name;
			}
			else{
				return False;
			}
		}
		public function get_adminemail($adminid){
		$q = $this->db->where(['id' => $adminid])
					->get(USER);
		if( $q->num_rows()==1){
				return $q->row()->email;
			}
			else{
				return False;
			}

		}
		public function select($q) {

		return  $this->db->where(['user_id' =>$q] )
					->get(USER_DETAILS)->row();
					

		}
		public function send_invite($emailid,$companyid,$hash){

			if($this->db->insert(INVITES,array('email_id' =>$emailid,'hash' =>$hash,'company_id' =>$companyid,'invite_time'=> date('Y-m-d H:i:s',time()) )) ){
			
				return True;
			}
		}
		public function get_userid($compid) {

			return $this->db->select('id')
							->where(['company_id' => $compid])
							->get(USER)->result();					
		}
		public function empdetails($uid) {

				  $q = $this->db->select(['first_name','last_name','img'])
				   				->where(['user_id'=> $uid])
				   				->get(USER_DETAILS)->result(); 
				  $x = $this->db->select('designation')
				 	   			->where(['user_id' =>$uid])
				 	   			->get(EMPLOYMENT_DETAILS)->result();
				 	   		if($x) {	
				 	   			$designationid = $x['0']->designation; 	   			
				 				$designationname = $this->db->select('name')
				 	   										->where(['id' =>$designationid])
				 	   										->get(DESIGNATIONS)->result();
				 	   		 	$data = array('fname' =>$q['0']->first_name,'lname'=>$q['0']->last_name,'img'=>$q['0']->img ,'designationname'=>$designationname['0']->name ,'user_id'=>$uid);
				 	   		 }
				 		else {

				 			$data = array('fname' =>$q['0']->first_name,'lname'=>$q['0']->last_name,'img'=>$q['0']->img ,'designationname'=>' ','user_id'=>$uid );
				 	}
				 	return $data;
		}
		

		public function get_designations_list($companyid){
			if($q = $this->db->select(['name','id'])
							->where(['company_id'=>$companyid])
							->get(DESIGNATIONS)->result()){
				return $q;
				}else{
					return false;
				}
		}

		public function add_designation($designation,$companyid,$team){
			if($this->db->insert(DESIGNATIONS,array('name' =>$designation,'company_id' =>$companyid,'team_id'=>$team))){
			
				return True;
			}
		}

		public function get_team_list($companyid){
			if($q = $this->db->where(['company_id'=>$companyid])
							->get(TEAM)->result()){
				return $q;
				}else{
					return false;
				}
		}

		public function add_team($team,$companyid){
			if($this->db->insert(TEAM,array('name' =>$team,'company_id' =>$companyid))){
			
				return True;
			}
		}
	    public function fetchdata($uid) {
		 	return $this->db->select()
		 				->where(['user_id' => $uid])
		 				->get(EMPLOYMENT_DETAILS)->result();
		 }
		public function updatedata($data) {
		 		
		 	 $q  = $this->db->select('user_id')
		 	  			->where(['user_id' => $data['user_id']])
		 	  			->get(EMPLOYMENT_DETAILS)->row();
		 	  			
		 	  if($q) {
		 	  		$this->db->where(['user_id' =>$q->user_id])
								->update(EMPLOYMENT_DETAILS,$data);
					return true;
		 	  }
		 	  else {

		 	  	$this->db->insert(EMPLOYMENT_DETAILS,$data);
		 	  	 return true;

		 	  }
		}
		public function get_designationname($x) {
		 	return $this->db->select('name')
		 			 ->where(['id' => $x])
		 			 ->get(DESIGNATIONS)->row()->name;

		}
		public function update_personal_info($data,$email) {
			$this->db->set('email', $email)
							->where(['id' => $data['user_id']])
							->update(USER);
			$this->db->where(['user_id' =>$data['user_id']])
						->update(USER_DETAILS,$data);
						return true;
		}
		 public function img_update($user_id,$img) {
		 	return $this->db->set('img',$img)
		 				->where(['user_id' => $user_id])
		 				->update(USER_DETAILS);
		 }


	}
?> 