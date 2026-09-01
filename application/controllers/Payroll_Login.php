<?php

	class Payroll_Login extends CI_Controller{

		public function __construct(){
			parent::__construct();

			$this->load->model('Login_Process');
		}
		
		public function index(){

			if($_SERVER['REQUEST_METHOD']=="POST"){

				$user_id 	= $_POST['user_id'];

				$user_pw 	= $_POST['user_pwd'];

				$result  		= $this->Login_Process->f_select_password($user_id);

				if($result){

					$match	   = password_verify($user_pw,$result->password);

					if($match){

						$user_data = $this->Login_Process->f_get_particulars("md_users",Null,array("user_id"=>$user_id),1);
					//	$branch_data = $this->Login_Process->f_get_particulars("md_branch",Null,array("id"=>$this->input->post('branch_id')),1);
						$bank = $this->Login_Process->f_get_particulars("md_bank",Null,array("sl_no"=>$user_data->bank_id),1);
						if($user_data->user_status == 'A'){

							$loggedin['user_id']            = $user_data->user_id;
							$loggedin['password']           = $user_data->password;
							$loggedin['user_type']      	= $user_data->user_type;
							$loggedin['user_name']      	= $user_data->user_name;
							$loggedin['user_status']   		= $user_data->user_status;
							//$loggedin['branch_id']   		= $user_data->branch_id;
							$loggedin['bank_id']   		    = $user_data->bank_id;
							$loggedin['bank_name']   		= $bank->bank_name;
							$loggedin['logo_path']   		= $bank->logo_path;
							///$loggedin['branch_id']   		= $this->input->post('branch_id');
						//	$loggedin['branch_name']   		= $branch_data->branch_name;
							$loggedin['ho_flag']            = 'Y';
							$loggedin['fin_id']  			= 1;
							$loggedin['fin_yr']   			= '2020-21';
							$loggedin['integrated_salary']  = $bank->integrated_salary;

							$this->session->set_userdata('loggedin',$loggedin);
			                //  Setting Id OF logged Person in System
							$id = $this->Login_Process->f_insert_audit_trail($user_id);
							$this->session->set_userdata('sl_no',$id);
							//  End
					
							redirect('Payroll_Login/main');
						}
						else{

							$this->session->set_flashdata('login_error', 'User is inactive!');
							redirect('Payroll_Login/login');
						}

					}
					else{

						$this->session->set_flashdata('login_error', 'Invalid password!');
						redirect('Payroll_Login/login');
					}

				}
				else{

					$this->session->set_flashdata('login_error', 'Invalid user id!');
					redirect('Payroll_Login/login');
				}

			}else{
			
			 redirect('Payroll_Login/login');

			}

		}			

		public function login(){

			if($this->session->userdata('loggedin')){

				redirect('Payroll_Login/main');

			}else{

				$this->load->view('login/login');
			}
		}

		public function main(){

			if($this->session->userdata('loggedin')){
                $bank_id = $this->session->userdata['loggedin']['bank_id'];
				$_SESSION['sys_date']= date('Y-m-d');

				$_SESSION['module']  = 'P';

				$fin_id = 1;  

				$fin_yr = '2020-21';

				$branch_id = 342;
				//$data['sal_upto'] = $this->Login_Process->f_get_particulars("td_salary",array('MAX(trans_date)as trans_date'),array('catg_cd'=> 1,'approval_status'=>'A','bank_id'=>$bank_id),1);
				$data['sal_upto'] = $this->Login_Process->get_last_salary($bank_id);
				$data['tot_emp'] = $this->Login_Process->f_get_particulars("md_employee",array('count(*) as cnt'),array('emp_status'=>'A','bank_id'=>$bank_id),1);
				$data['tot_ed'] = $this->Login_Process->f_get_particulars("td_pay_slip",array('SUM(CASE WHEN pay_head_type = "E" THEN amount ELSE 0 END) AS tot_earn,SUM(CASE WHEN pay_head_type = "D" THEN amount ELSE 0 END) AS tot_dedu'),array('bank_id'=>$bank_id),1);
				$data['tot_edp'] = $this->Login_Process->f_get_particulars("td_pay_slip",array('SUM(CASE WHEN pay_head_type = "E" THEN amount ELSE 0 END) AS tot_earn,SUM(CASE WHEN pay_head_type = "D" THEN amount ELSE 0 END) AS tot_dedu'),array('catg_id'=>'1','bank_id'=>$bank_id),1);
				$data['tot_edt'] = $this->Login_Process->f_get_particulars("td_pay_slip",array('SUM(CASE WHEN pay_head_type = "E" THEN amount ELSE 0 END) AS tot_earn,SUM(CASE WHEN pay_head_type = "D" THEN amount ELSE 0 END) AS tot_dedu'),array('catg_id'=>'2','bank_id'=>$bank_id),1);
				$this->load->view('post_login/payroll_main');

				$this->load->view('post_login/home',$data);

				$this->load->view('post_login/footer');

			}
			else{

				redirect('User_Login/login');

			}
			
		}	

        public function check_user(){
			$user_id=$this->input->post("user_id");
			$user_data = $this->Login_Process->f_get_user_inf($user_id);
			if($user_data){
				$branch_list_html = '<select class="form-control" name="branch_id" required ><option value="">Select Branch </option>';
               $brnch_list =  $this->Login_Process->f_get_particulars("md_branch",Null,array("bank_id"=>$user_data->bank_id),0);
			  // print_r($brnch_list);
			   foreach($brnch_list as $key){
				$branch_list_html .='<option value="'.$key->id.'">'.$key->branch_name.'</option>';
			   }
			   $branch_list_html .='</select>';
			  // $data['html'] = $branch_list_html;
			   $data['status']= 1;
			   echo json_encode($data);
			}else{
				$data['status']= 0;
				echo json_encode($data);
			}
		}

		public function logout(){

			if($this->session->userdata('loggedin')){

				$user_id    =   $this->session->userdata['loggedin']['user_id'];
				
				$this->Login_Process->f_update_audit_trail($user_id);

				$this->session->unset_userdata('loggedin');
				
				redirect('Payroll_Login/login');

			}else{

				redirect('Payroll_Login/login');

			}
		}
	}
?>
