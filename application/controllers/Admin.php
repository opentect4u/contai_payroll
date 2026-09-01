<?php

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if(!isset($this->session->userdata['loggedin']['user_id'])){
            redirect(base_url());
        }
		$this->load->model('Login_Process');
		$this->load->library('form_validation');
		$this->load->model('Admin_Process');		
	}

	public function parameter()
	{

		$this->load->view('post_login/payroll_main');

		$param_dtls['parameter'] = $this->Admin_Process->f_get_particulars("md_parameters", NULL, NULL, 0);

		$this->load->view('parameter/dashboard', $param_dtls);

		$this->load->view('post_login/footer');
	}

	public function parameter_edit()
	{

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$sl_no  			=   $this->input->post('sl_no');

			$param_desc       	=   $this->input->post('param_desc');

			$param_value   		=   $this->input->post('param_value');

			$data_array = array(

				"param_value"     	=>  $param_value,

				"modified_by"		=>  $this->session->userdata['loggedin']['user_id'],

				"modified_dt"    =>  date('Y-m-d h:i:s')

			);

			$where = array(

				"sl_no"       =>  $sl_no

			);

			$this->session->set_flashdata('msg', 'Successfully updated!');

			$this->Admin_Process->f_edit('md_parameters', $data_array, $where);

			redirect('vls');
		} else {

			$where = array(

				"sl_no"     =>  $this->input->get('sl_no')

			);

			//Bonus list of latest month
			$parameter['param_dtls']    =   $this->Admin_Process->f_get_particulars("md_parameters", NULL, $where, 1);
			$this->load->view('post_login/payroll_main');
			$this->load->view("parameter/edit", $parameter);
			$this->load->view('post_login/footer');
		}
	}
	public function ptax()
	{

		$data['ptax'] = $this->Admin_Process->f_get_particulars("md_ptax", NULL, NULL, 0);
		$this->load->view('post_login/payroll_main');
		$this->load->view('ptax/dashboard', $data);
		$this->load->view('post_login/footer');
	}
	public function ptax_edit()
	{		//Edit Employee

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$data_array = array(

				"ptax"        =>  $this->input->post('ptax'),
				"updated_by"  =>  $this->session->userdata['loggedin']['user_id'],
				"updated_at"  =>  date('Y-m-d h:i:s')
			);

			$where  =   array(
				"id"         =>  $this->input->post('id')
			);

			$this->session->set_flashdata('msg', 'Successfully updated!');
			$this->Admin_Process->f_edit('md_ptax', $data_array, $where);
			$this->ptax();
		} else {

			$where = array(
				"id"       =>  base64_decode($this->input->get('sl_no'))
			);

			$data['ptax_dtls']  =  $this->Admin_Process->f_get_particulars("md_ptax", NULL, $where, 1);
			$this->load->view('post_login/payroll_main');
			$this->load->view("ptax/edit", $data);
			$this->load->view('post_login/footer');
		}
	}
	public function desig()
	{	//designation Dashboard

		$select = array("sl_no", "designation");
		$where  = array('bank_id' => $this->session->userdata['loggedin']['bank_id'] );
		$dept['dept_dtls']    =   $this->Admin_Process->f_get_particulars("md_designation", $select, $where, 0);
		$this->load->view('post_login/payroll_main');
		$this->load->view("dept/dashboard", $dept);
		$this->load->view('post_login/footer');
	}
	public function dept_add()
	{	//Add Employee		

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$cnt = $this->Admin_Process->match_name($this->input->post('name'));
			// echo $this->db->last_query();
			// exit;
			if ($cnt == 0) {
				$data_array = array(
					'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
					"designation"   =>  $this->input->post('name'),
					"created_by"    =>  $this->session->userdata['loggedin']['user_id'],
					"created_at"    =>  date('Y-m-d h:i:s')
				);

				$this->Admin_Process->f_insert('md_designation', $data_array);
				$this->session->set_flashdata('msg', 'Successfully added!');
				redirect('desig');
				
			} else {
				$this->session->set_flashdata('msg', 'Name Exist');
			
				redirect('desig');
			}
		} else {
			$this->load->view('post_login/payroll_main');
			$this->load->view("dept/add");
			$this->load->view('post_login/footer');
		}
	}
	public function desig_edit()
	{		//Edit Employee

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$data_array = array(

				"designation"     =>  $this->input->post('name'),
				"modified_by"  => $this->session->userdata['loggedin']['user_id'],
				"modified_at"  =>  date('Y-m-d h:i:s')
			);

			$where  =   array(
				"sl_no"         =>  $this->input->post('id')
			);

			$this->session->set_flashdata('msg', 'Successfully updated!');

			$this->Admin_Process->f_edit('md_designation', $data_array, $where);
			
			$this->desig();
		} else {

			$where = array(
				"sl_no"       =>  $this->input->get('id')
			);

			$data['dept_dtls']  =  $this->Admin_Process->f_get_particulars("md_designation", NULL, $where, 1);
			$this->load->view('post_login/payroll_main');
			$this->load->view("dept/edit", $data);

			$this->load->view('post_login/footer');
		}
	}

	public function employee()
	{		//Employee Dashboard
		$select = 'a.prefix_emp_cd,a.emp_code, a.emp_name, b.designation, c.category, d.branch_name, a.aadhar_no, 
		a.basic_pay, a.phn_no, a.pan_no, a.UAN, a.dob, a.join_dt, a.ret_dt, a.qualification, a.emp_addr, a.email, 
		a.bank_ac_no, a.ifsc, a.bank_name';
		$where = array(
			'a.designation =b.sl_no' => null,
			'a.emp_catg=c.id' => null,
			'a.branch_id=d.id' => null,
			'a.emp_status' => 'A',
			'a.bank_id'    => $this->session->userdata['loggedin']['bank_id']
		);
		$table_name = 'md_employee a,md_designation b,md_category c, md_branch d';

		$employee['employee_dtls']    =   $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
		$this->load->view('post_login/payroll_main');
		$this->load->view("employee/dashboard", $employee);
		$this->load->view('post_login/footer');
	}

	public function employee_add()
	{	//Add Employee		
           
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$validation_error = '';

			//$maxCode     =   $this->Payroll->f_get_particulars("md_employee", array("MAX(emp_code) + 1 emp_code"), null, 1);
			$this->form_validation->set_rules('emp_code', 'Employee code', 'required');
			$this->form_validation->set_rules('emp_name', 'Employee Name', 'required');
			$this->form_validation->set_rules('emp_catg', 'Employee Category', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			$this->form_validation->set_rules('join_dt', 'Joining Date', 'required');
			$this->form_validation->set_rules('phn_no', 'Phone Number', 'required');
			$this->form_validation->set_rules('basic_pay', 'Basic Pay', 'required');

			if ($this->form_validation->run() == TRUE) {
				$query = null; //emptying in case
				$_where = array('emp_code' => trim($this->input->post('emp_code')),'bank_id' => $this->session->userdata['loggedin']['bank_id']);
				$query = $this->db->get_where('md_employee',$_where);
				$count = $query->num_rows(); //counting result from query

				if ($count === 0) {
					// $this->Admin_Process->f_get_particulars('md_employee', $data_array);
					$data_array = array(
						"bank_id"          =>  $this->session->userdata['loggedin']['bank_id'],
						"prefix_emp_cd"    =>  $this->input->post('prefix_emp_cd'),
						"emp_code"         =>  $this->input->post('emp_code'),
						"emp_name"         =>  $this->input->post('emp_name'),
						"emp_catg"         =>  $this->input->post('emp_catg'),
						"branch_id"        =>  $this->input->post('branch_id'),
						"father_name"      =>  $this->input->post('father_name'),
						"emp_sex"          =>  $this->input->post('emp_sex'),
						'caste'            =>  $this->input->post('caste'),
						'pi_no'            =>  $this->input->post('pi_no'),
						'qualification'    =>  $this->input->post('qualification'),
						"dob"          	   =>  $this->input->post('dob'),
						"join_dt"          =>  $this->input->post('join_dt'),
						"ret_dt"           =>  $this->input->post('ret_dt'),
						"phn_no"           =>  $this->input->post('phn_no'),
						"email"            =>  $this->input->post('email'),
						"designation"      =>  $this->input->post('designation'),
						"department"       =>  0,
						"emp_addr"         =>  $this->input->post('emp_addr'),
						"pan_no"           =>  $this->input->post('pan_no'),
						"aadhar_no"        =>  $this->input->post('aadhar'),
						"bank_name"        =>  $this->input->post('bank_name'),
						"ifsc"        	   =>  $this->input->post('ifsc'),
						"bank_ac_no"       =>  $this->input->post('bank_ac_no'),
						"pf_ac_no"         =>  $this->input->post('pf_ac_no'),
						"uan"              =>  $this->input->post('uan'),
						"basic_pay"        =>  $this->input->post('basic_pay'),
						"hra_flag"        =>  $this->input->post('hra_flag'),
						"pf_flag"         =>  $this->input->post('pf_flag'),
						"cash_flag"       =>  $this->input->post('cash_flag'),
						"food_flag"       =>  $this->input->post('food_flag'),
						"created_by"      =>  $this->session->userdata['loggedin']['user_id'],
						"created_dt"      =>  date('Y-m-d h:i:s')
					);

					$this->Admin_Process->f_insert('md_employee', $data_array);
					
					$this->session->set_flashdata('msg', 'Successfully added!');
					redirect('stfemp');
				} else {
					$this->session->set_flashdata('msg', 'Employee Code Already Exist');
					redirect('stfemp');
				}
			} else {

				$validation_error  = validation_errors();
				$this->session->set_flashdata('msg', $validation_error);
				redirect("emadst");
			}
		} else {

			$where = array(
				'bank_id' => $this->session->userdata['loggedin']['bank_id'],
			);
			$employee['category_dtls'] =   $this->Admin_Process->f_get_particulars("md_category", NULL, NULL, 0);
			$employee['branch_dtls']   =   $this->Admin_Process->f_get_particulars("md_branch", NULL, $where, 0);
			$employee['dept']          =   $this->Admin_Process->f_get_particulars("md_designation", NULL, $where, 0);
			$employee['caste']         =   $this->Admin_Process->f_get_particulars("md_caste", NULL, NULL, 0);
			$this->load->view('post_login/payroll_main');
			$this->load->view("employee/add", $employee);

			$this->load->view('post_login/footer');
		}
	}

	public function employee_delete()
	{		//Delete Employee

		$where = array(
            'bank_id' => $this->session->userdata['loggedin']['bank_id'],
			"emp_code"    =>  $this->input->get('empcd'),
		);
   
		$this->Admin_Process->f_delete('md_employee', $where);
		$this->session->set_flashdata('msg', 'Successfully Deleted!');

		redirect("stfemp");
	}

	public function employee_edit()
	{		//Edit Employee

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$this->form_validation->set_rules('emp_code', 'Employee Code', 'required');
			$this->form_validation->set_rules('emp_name', 'Employee Name', 'required');
			$this->form_validation->set_rules('basic_pay', 'Basic Pay', 'required');
			if ($this->form_validation->run() == TRUE) {

				$data_array = array(
						"emp_name"         =>  $this->input->post('emp_name'),
						"emp_catg"         =>  $this->input->post('emp_catg'),
						"branch_id"        =>  $this->input->post('branch_id'),
						"father_name"      =>  $this->input->post('father_name'),
						"emp_sex"          =>  $this->input->post('emp_sex'),
						'caste'            =>  $this->input->post('caste'),
						'pi_no'            =>  $this->input->post('pi_no'),
						'qualification'    =>  $this->input->post('qualification'),
						"dob"          	   =>  $this->input->post('dob'),
						"join_dt"          =>  $this->input->post('join_dt'),
						"ret_dt"           =>  $this->input->post('ret_dt'),
						"phn_no"           =>  $this->input->post('phn_no'),
						"email"            =>  $this->input->post('email'),
						"designation"      =>  $this->input->post('designation'),
						"emp_addr"         =>  $this->input->post('emp_addr'),
						"pan_no"           =>  $this->input->post('pan_no'),
						"aadhar_no"        =>  $this->input->post('aadhar'),
						"bank_name"        =>  $this->input->post('bank_name'),
						"bank_ac_no"       =>  $this->input->post('bank_ac_no'),
						"ifsc"        	   =>  $this->input->post('ifsc'),
						"pf_ac_no"         =>  $this->input->post('pf_ac_no'),
						"uan"              =>  $this->input->post('uan'),
						"basic_pay"        =>  $this->input->post('basic_pay'),
						"hra_flag"        =>  $this->input->post('hra_flag'),
						"pf_flag"         =>  $this->input->post('pf_flag'),
						"cash_flag"       =>  $this->input->post('cash_flag'),
						"food_flag"       =>  $this->input->post('food_flag'),
					"emp_status"       => $this->input->post('emp_status'),
					"remarks"           => $this->input->post('remarks'),
					"modified_by"       => $this->session->userdata['loggedin']['user_id'],
					"modified_dt"       =>  date('Y-m-d h:i:s')

				);

				$where  =   array(
					"bank_id"   => $this->session->userdata['loggedin']['bank_id'],
					"emp_code"   =>  $this->input->post('emp_code')
				);
				//update payhead in earning and deduction table based on designation
				$query = $this->db->query("select designation from md_employee where emp_code = " . $this->input->post('emp_code'));
				$result = $query->result();
				$designation_id = $result[0]->designation;
				$this->db->query('UPDATE td_earning_deduction ed, md_payhead_earning pe, md_employee e SET ed.amount = 0 WHERE ed.emp_no = e.emp_code AND e.designation = pe.designation_id AND ed.pay_head_id = pe.payhead_id AND ed.emp_no = ' . $this->input->post('emp_code') . ' AND ed.pay_head_type = "E" AND pe.designation_id = ' . $designation_id);
				$this->session->set_flashdata('msg', 'Successfully updated!');
				$this->Admin_Process->f_edit('md_employee', $data_array, $where);
				$this->db->query('UPDATE td_earning_deduction ed, md_payhead_earning pe, md_employee e SET ed.amount = pe.amount WHERE ed.emp_no = e.emp_code AND e.designation = pe.designation_id AND ed.pay_head_id = pe.payhead_id AND ed.emp_no = ' . $this->input->post('emp_code') . ' AND ed.pay_head_type = "E" AND pe.designation_id = ' . $this->input->post('designation'));
				redirect('stfemp');
			} else {

				$this->session->set_flashdata('msg', validation_errors());

				redirect('stfemp');
			}
		} else {

			//For Employee Details
			unset($select);
			$select = array(
				"emp_code", "emp_name",'prefix_emp_cd',"emp_catg", "dob", "email", "phn_no","emp_sex","pi_no",
				"designation", "department", "emp_addr",'father_name','qualification','hra_flag','pf_flag','cash_flag','ifsc',
				"pan_no", "bank_name", "bank_ac_no", "join_dt", "ret_dt",'caste',"branch_id",'food_flag',
				"pf_ac_no", "uan", "basic_pay", "aadhar_no", "emp_status",'remarks'
			);


			$where = array(
                "bank_id"   => $this->session->userdata['loggedin']['bank_id'],
				"emp_code"  =>  $this->input->get('emp_code')
			);

			//Category List 
			$employee['category_dtls']    =   $this->Admin_Process->f_get_particulars("md_category", NULL, NULL, 0);
			$employee['employee_dtls']    =   $this->Admin_Process->f_get_particulars("md_employee", $select, $where, 1);
		
			$employee['caste']         =   $this->Admin_Process->f_get_particulars("md_caste", NULL, NULL, 0);
			$employee['branch_dtls']   =   $this->Admin_Process->f_get_particulars("md_branch", NULL,array('bank_id' => $this->session->userdata['loggedin']['bank_id']),0);
			$employee['dept']          =   $this->Admin_Process->f_get_particulars("md_designation", NULL,array('bank_id' => $this->session->userdata['loggedin']['bank_id']), 0);
			$this->load->view('post_login/payroll_main');

			$this->load->view("employee/edit", $employee);

			$this->load->view('post_login/footer');
		}
	}

	public function emp_dtls()
	{

		$emp_code 	= 	 $this->input->get('emp_code');

		$count   =   $this->Admin_Process->f_count_emp($emp_code);

		echo $count->count_emp;
	}

	public function ajaxemplist()
	{
		$status = $this->input->post('active_status');
		$select = 'a.prefix_emp_cd,a.emp_code, a.emp_name, b.designation, c.category, d.branch_name, a.aadhar_no, 
		a.basic_pay, a.phn_no, a.pan_no, a.UAN, a.dob, a.join_dt, a.ret_dt, a.qualification, a.emp_addr, a.email, 
		a.bank_ac_no, a.ifsc, a.bank_name';
		$where = array(
			'a.designation =b.sl_no' => null,
			'a.emp_catg=c.id' => null,
			'a.branch_id=d.id' => null,
			'a.emp_status' => $status,
			'a.bank_id'    => $this->session->userdata['loggedin']['bank_id']
		);
		$table_name = 'md_employee a,md_designation b,md_category c, md_branch d';

		$employee['employee_dtls']    =   $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
		
		$data = $this->load->view('employee/ajaxemplist', $employee);
		return $data;
	}

	function category()
	{
		$select = 'id, category';
		$catg_list = $this->Admin_Process->f_get_particulars("md_category", $select, NULL, 0);
		$data['catg_list'] = $catg_list;
		$this->load->view('post_login/payroll_main');
		$this->load->view("catg/view", $data);
		$this->load->view('post_login/footer');
	}

	function category_entry()
	{
		$id = $this->input->get('id');
		$selected = array(
			'id' => $id,
			'category' => '',
			'da' => '',
			'sa' => '',
			'hra' => '',
			'hra_max' => '',
			'pf' => '',
			'pf_max' => '',
			'pf_min' => '',
			'ta' => '',
			'ma' => ''
		);
		if ($id > 0) {
			$select = 'id, category, da, sa, hra, hra_max, pf, pf_max, pf_min, ta, ma';
			$where = array(
				'id' => $id
			);
			$catg_dtls = $this->Admin_Process->f_get_particulars("md_category", $select, $where, 1);
			$selected = array(
				'id' => $id,
				'category' => $catg_dtls->category
				// 'da' => $catg_dtls->da,
				// 'sa' => $catg_dtls->sa,
				// 'hra' => $catg_dtls->hra,
				// 'hra_max' => $catg_dtls->hra_max,
				// 'pf' => $catg_dtls->pf,
				// 'pf_max' => $catg_dtls->pf_max,
				// 'pf_min' => $catg_dtls->pf_min,
				// 'ta' => $catg_dtls->ta,
				// 'ma' => $catg_dtls->ma
			);
		}
		$data['selected'] = $selected;
		$this->load->view('post_login/payroll_main');
		$this->load->view("catg/entry", $data);
		$this->load->view('post_login/footer');
	}

	function category_seve()
	{
		// echo '<pre>';
		// var_dump($this->input->post());
		$id = $this->input->post('id');
		$msg = '';
		$res_dt = false;
		$data_array = array(
			'category' => $this->input->post('category')
			// 'da' => $this->input->post('da') > 0 ? $this->input->post('da') : 0,
			// 'sa' => $this->input->post('sa') > 0 ? $this->input->post('sa') : 0,
			// 'hra' => $this->input->post('hra') > 0 ? $this->input->post('hra') : 0,
			// 'hra_max' => $this->input->post('hra_max') > 0 ? $this->input->post('hra_max') : 0,
			// 'pf' => $this->input->post('pf') > 0 ? $this->input->post('pf') : 0,
			// 'pf_max' => $this->input->post('pf_max') > 0 ? $this->input->post('pf_max') : 0,
			// 'pf_min' => $this->input->post('pf_min') > 0 ? $this->input->post('pf_min') : 0,
			// 'ta' => $this->input->post('ta') > 0 ? $this->input->post('ta') : 0,
			// 'ma' => $this->input->post('ma') > 0 ? $this->input->post('ma') : 0
		);
		if ($id > 0) {
			$data_array['modified_by'] = $this->session->userdata['loggedin']['user_id'];
			$data_array['modified_at'] = date('Y-m-d h:i:s');
			$where = array(
				'id' => $id
			);
			$res_dt = $this->Admin_Process->f_edit('md_category', $data_array, $where);
			$msg = 'Successfully Updated!';
		} else {
			$data_array['created_by'] = $this->session->userdata['loggedin']['user_id'];
			$data_array['created_at'] = date('Y-m-d h:i:s');
			// var_dump($data_array);
			// exit;
			$res_dt = $this->Admin_Process->f_insert('md_category', $data_array);
			$msg = 'Successfully Inserted!';
		}
		if ($res_dt) {
			$this->session->set_flashdata('msg', $msg);
			redirect('catg');
		} else {
			$this->session->set_flashdata('msg', 'Successfully updated!');
			redirect('catged');
		}
	}

	public function payhead()
	{	
		$where  = array('bank_id' => $this->session->userdata['loggedin']['bank_id'] );
		$dept['payhead']    =   $this->Admin_Process->f_get_particulars("md_pay_head", NULL, $where, 0);
		$this->load->view('post_login/payroll_main');
		$this->load->view("payhead/dashboard", $dept);
		$this->load->view('post_login/footer');
	}
	public function payhead_add()
	{	//Add Employee		

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$this->form_validation->set_rules('pay_head', 'Pay Head', 'required');
			if($this->session->userdata['loggedin']['integrated_salary']==1){
			    $this->form_validation->set_rules('acc_cd', 'Account Code', 'required');
		    }

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('payhead');
			}else{
				$results = $this->db->get_where('md_pay_head', array('pay_head =' => $this->input->post('pay_head'),'bank_id' => $this->session->userdata['loggedin']['bank_id']))->result();
				if (count($results) == 0) {
					$data_array = array(
									'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
									"input_flag"    =>  $this->input->post('input_flag'),
									"pay_flag"      =>  $this->input->post('pay_flag'),
									"pay_head"      =>  $this->input->post('pay_head'),
									"acc_cd"        =>  $this->input->post('acc_cd'),
									"percentage"    =>  $this->input->post('percentage'),
									"created_by"    =>  $this->session->userdata['loggedin']['user_id'],
									"created_at"    =>  date('Y-m-d h:i:s')
									);

					$this->Admin_Process->f_insert('md_pay_head', $data_array);
					$this->session->set_flashdata('msg', 'Successfully added!');
					redirect('payhead');
			
				} else {
					$this->session->set_flashdata('msg', 'Name Exist');
					redirect('payhead');
				}
			}
		} else {
			$data['accocde_required'] = $this->session->userdata['loggedin']['integrated_salary']==1 ? 'required' : '';
			$this->load->view('post_login/payroll_main');
			$this->load->view("payhead/add",$data);
			$this->load->view('post_login/footer');
		}
	}
	public function payhead_edit()
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$this->form_validation->set_rules('pay_head', 'Pay Head', 'required');
			if($this->session->userdata['loggedin']['integrated_salary']==1){
			    $this->form_validation->set_rules('acc_cd', 'Account Code', 'required');
		    }
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('payhead');
			}else{
			  $data_array = array(
				"input_flag"    =>  $this->input->post('input_flag'),
				"pay_flag"      =>  $this->input->post('pay_flag'),
				"pay_head"      =>  $this->input->post('pay_head'),
				"acc_cd"        =>  $this->input->post('acc_cd'),
				"percentage"    =>  $this->input->post('percentage'),
				"modified_by"  => $this->session->userdata['loggedin']['user_id'],
				"modified_at"  =>  date('Y-m-d h:i:s') );

			   $where  =   array("sl_no" =>  $this->input->post('id'));
			   if($this->input->post('id')==PAYHEAD_DA){
				   $this->Admin_Process->update_da($this->input->post('percentage'));
			   }
			   $this->session->set_flashdata('msg', 'Successfully updated!');
			   $this->Admin_Process->f_edit('md_pay_head', $data_array, $where);
			   $this->payhead();
		    }
		}else {

			$where = array("sl_no"       =>  $this->input->get('id'));
			$data['payhead_dtls']  =  $this->Admin_Process->f_get_particulars("md_pay_head", NULL, $where, 1);
			$data['accocde_required'] = $this->session->userdata['loggedin']['integrated_salary']==1 ? 'required' : '';
			
			$this->load->view('post_login/payroll_main');
			$this->load->view("payhead/edit", $data);
			$this->load->view('post_login/footer');
		}
	}

	public function change_password(){

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $oldpassword = $this->input->post('oldpass');
            $password = $this->input->post('password');
            // $this->session->userdata['loggedin']['user_id']
            $returnData = $this->Admin_Process->checkOldPassword($oldpassword);
            if ($returnData == 1) {
                $dataArray = array(
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                    'modified_by' => $this->session->userdata['loggedin']['user_name'],
                    'modified_dt' => date('Y-m-d h:i:s')
                );
                $where = array('user_id' => $this->session->userdata['loggedin']['user_id']);
                $this->Admin_Process->f_edit('md_users', $dataArray, $where);
               // $this->Admin_Process->update_fin_user($dataArray, $this->session->userdata['loggedin']['user_id']);
                $this->session->set_flashdata('success', 'Successfully Change Password!');
              //  echo "<script>alert('Successfully Change Password!');</script>";
				redirect('admin/change_password');
            } else {
                $this->session->set_flashdata('error', 'Incorrect old password!');
                echo "<script>alert('Wrong Password!');</script>";
				redirect('admin/change_password');
            }

            
        } else {

            $this->load->view('post_login/payroll_main');

            $this->load->view("user/change_password");

            $this->load->view('post_login/footer');
        }
    }

	public function payheadearning()
	{	
		//$this->session->set_flashdata('msg', '');
		$select = 'a.id, b.pay_head, c.designation, a.amount';
		$where = array(
			'a.payhead_id=b.sl_no' => null,
			'a.designation_id=c.sl_no' => null,
			'b.bank_id=c.bank_id' => null,
			'a.isactive' => 1,
			'b.bank_id' => $this->session->userdata['loggedin']['bank_id']
		);
		$table_name = 'md_payhead_earning a, md_pay_head b, md_designation c';

		$data['list'] = $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
		$this->load->view('post_login/payroll_main');
		$this->load->view("phearning/view", $data);
		$this->load->view('post_login/footer');
	}

	function phearning_update() {
		$data = $this->input->post();
		if ($this->Admin_Process->f_edit('md_payhead_earning', array('amount' => $data['amount']), array('id' => $data['id']))) {
			$this->session->set_flashdata('msg', 'Successfully updated!');
			echo true;
		} else {
			$this->session->set_flashdata('msg', 'Something went wrong!');
			echo false;
		}
	}

	public function payheadearning_edit()
	{	
		$data['payhead'] = $this->Admin_Process->f_get_particulars("md_pay_head", NULL, array('pay_flag'=>'E','bank_id'=>$this->session->userdata['loggedin']['bank_id']), 0);
		$data['designation'] = $this->Admin_Process->f_get_particulars("md_designation", NULL, array('bank_id'=>$this->session->userdata['loggedin']['bank_id']), 0);
		$this->load->view('post_login/payroll_main');
		$this->load->view("phearning/entry", $data);
		$this->load->view('post_login/footer');
	}

	function payheadearning_save()
	{
		$payhead_id = $this->input->post('payhead_id');
		$designation_id = $this->input->post('designation_id');
		$amount = $this->input->post('amount');

		if ($payhead_id && $designation_id && $amount) {
			$where = array(
				'payhead_id' => $payhead_id,
				'designation_id' => $designation_id
			);
			$row = $this->Admin_Process->f_get_particulars('md_payhead_earning', NULL, $where, 0);
			if ($row) {
				$data = array(
					'amount' => $amount,
					'isactive' => 1
				);
				if ($this->Admin_Process->f_edit('md_payhead_earning', $data, $where)) {
					$this->session->set_flashdata('msg', 'Successfully updated!');
				} else {
					$this->session->set_flashdata('msg', 'Something went wrong!');
				}
			} else {
				$data = array(
					'created' => date('Y-m-d'),
					'payhead_id' => $payhead_id,
					'designation_id' => $designation_id,
					'amount' => $amount,
					'isactive' => 1
				);
				if ($this->Admin_Process->f_insert('md_payhead_earning', $data)) {
					$this->session->set_flashdata('msg', 'Successfully saved!');
				} else {
					$this->session->set_flashdata('msg', 'Something went wrong!');
				}
			}
		} else {
			$this->session->set_flashdata('msg', 'Something went wrong!');
		}
		redirect('phearning');
	}

	function phearning_apply()
	{
		$id = $this->input->post('id');
		$cnt = $this->Admin_Process->phearning_apply($id);
		$this->session->set_flashdata('msg', 'Successfully ' . $cnt . ' employee(s) updated!');
		echo true;
	}

	public function increment()
	{	
		$month = $this->input->post('month') ? $this->input->post('month') : date('m');
		$year = $this->input->post('year') ? $this->input->post('year') : date('Y');
		$data['month_list'] = $this->Admin_Process->f_get_particulars('md_month');
		$data['month'] = $month;
		$data['year'] = $year;
		$data['list'] = $this->Admin_Process->increment($month, $year);
		$this->load->view('post_login/payroll_main');
		$this->load->view("increment/view", $data);
		$this->load->view('post_login/footer');
	}

	function increment_update() {
		$data = $this->input->post();
		if ($this->Admin_Process->increment_update($data)) {
			$this->session->set_flashdata('msg', 'Successfully updated!');
			echo true;
		} else {
			$this->session->set_flashdata('msg', 'Something went wrong!');
			echo false;
		}
	}

	function increment_apply() {
		$id = $this->input->post('id');
		$this->Admin_Process->increment_apply($id);
		$this->session->set_flashdata('msg', 'Successfully updated!');
		echo true;
	}

	public function other_deduction()
	{	
		$data['header'] = $this->Admin_Process->get_deduction_header();
		$data['list'] = $this->Admin_Process->other_deduction();
		$this->load->view('post_login/payroll_main');
		$this->load->view("other_deduction/view", $data);
		$this->load->view('post_login/footer');
	}

	function other_deduction_update() {
		$data = $this->input->post();
		if ($this->Admin_Process->other_deduction_update($data)) {
			$this->session->set_flashdata('msg', 'Successfully updated!');
			echo true;
		} else {
			$this->session->set_flashdata('msg', 'Something went wrong!');
			echo false;
		}
	}

	function transfer()
	{
		$data['branch_list'] = $this->Admin_Process->f_get_particulars('md_branch', null, array('bank_id'=>$this->session->userdata['loggedin']['bank_id']), 0);
		$data['list'] = $this->Admin_Process->transfer();
		$this->load->view('post_login/payroll_main');
		$this->load->view("transfer/view", $data);
		$this->load->view('post_login/footer');
	}

	function transfer_update() {
		$data = $this->input->post();
		if ($this->Admin_Process->transfer_update($data)) {
			$this->session->set_flashdata('msg', 'Successfully updated!');
			echo true;
		} else {
			$this->session->set_flashdata('msg', 'Something went wrong!');
			echo false;
		}
	}

	function upload() {
        $config = array(
            'upload_path' => 'uploads/',
            'allowed_types' => 'xlsx'
        );
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
            exit;
        } else {
            $file_info = $this->upload->data();
            $old_path = $config['upload_path'] . $file_info['raw_name'] . $file_info['file_ext'];
            $input = array(
                'created' => date('Y-m-d'),
                'tag' => 'OTHER_DEDUCTION',
                'name' => $file_info['orig_name'],
                'path' => $old_path
            );
            $this->db->insert('td_upload_log', $input);
            $id = $this->db->insert_id();
            $new_path = $config['upload_path'] . $id . $file_info['file_ext'];
            rename($file_info['full_path'], str_replace($file_info['raw_name'], $id, $file_info['full_path']));
            $input = array(
                'path' => $new_path
            );
            $this->db->where('id', $id);
            $this->db->update('td_upload_log', $input);
            echo json_encode($this->Admin_Process->process($new_path));
        }
    }
}
