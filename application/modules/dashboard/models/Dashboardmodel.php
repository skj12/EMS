<?php 
	class Dashboardmodel extends CI_Model {

		public function get_companyid( $adminid ){

			$q = $this->db->where(['UserId'=>$adminid])
							->get('AdminTbl');

			if( $q->num_rows()==1){
				return $q->row()->companyId;
			}
			else{
				return False;
			}
		}

		public function get_companyname($companyid){
			$q = $this->db->where(['id'=>$companyid])
							->get('CompTbl');			
			if( $q->num_rows()==1){
				return $q->row()->name;
			}
			else{
				return False;
			}
		}

		public function send_invite($emailid,$companyid,$hash){

			if($this->db->insert('Invites',array('emailid' =>$emailid,'hash' =>$hash,'companyId' =>$companyid,'invitetime'=> date('Y-m-d H:i:s',time()) )) ){
			
				return True;
			}
		}

	}
?> 