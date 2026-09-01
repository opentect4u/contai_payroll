<?php

class Salary extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!isset($this->session->userdata['loggedin']['user_id'])){
            redirect(base_url());
        }
        $this->load->model('Login_Process');

        $this->load->model('Salary_Process');

        $this->load->model('Admin_Process');
    }
    public function eardedu()
	{	
        $select = array('a.effective_dt','a.emp_no','b.emp_name', 'c.designation');
        $where  = array('a.emp_no = b.emp_code' => NULL,'a.bank_id' => $this->session->userdata['loggedin']['bank_id'], 'b.designation = c.sl_no' => NULL,'b.bank_id' => $this->session->userdata['loggedin']['bank_id'],'1 group by a.effective_dt,a.emp_no,b.emp_name' => NULL);
		$dept['payhead']    =   $this->Admin_Process->f_get_particulars("td_earning_deduction a, md_employee b, md_designation c", $select, $where, 0);
     
		$this->load->view('post_login/payroll_main');
		$this->load->view("earning_deduction/dashboard", $dept);
		$this->load->view('post_login/footer');
	}
	public function eardeduadd()
	{	//Add Employee		
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$results = $this->db->get_where('td_earning_deduction', array('effective_dt =' => $this->input->post('effective_dt'),'emp_no'=>$this->input->post('emp_cd') ))->result();
			 if(count($results) == 0) {

              $epay_cd  = $this->input->post('epay_cd');
              $eamount  = $this->input->post('eamount');
              $emp_cd   = $this->input->post('emp_cd');
                for ($i = 0; $i < count($epay_cd); $i++) {

                    $data_array = array(
                        'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
                        "effective_dt"  =>  $this->input->post('effective_dt'),
                        "emp_no"        =>  $emp_cd,
                        "pay_head_id"   =>  $epay_cd[$i],
                        'pay_head_type' =>  'E',
                        "amount"        =>  $eamount[$i],
                        "created_by"    =>  $this->session->userdata('loggedin')['user_id'],
                        "created_dt"    =>  date('Y-m-d H:i:s'),
                        "created_ip"    =>  $_SERVER['REMOTE_ADDR']
                    );
        
                    $this->Admin_Process->f_insert('td_earning_deduction', $data_array);
                }
                $dpay_cd  = $this->input->post('dpay_cd');
                $damount  = $this->input->post('damount');
                for ($i = 0; $i < count($dpay_cd); $i++) {
                    $ddata_array = array(
                        'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
                        "effective_dt"  =>  $this->input->post('effective_dt'),
                        "emp_no"        =>  $emp_cd,
                        "pay_head_id"   =>  $dpay_cd[$i],
                        'pay_head_type' =>  'D',
                        "amount"        =>  $damount[$i],
                        "created_by"    =>  $this->session->userdata('loggedin')['user_id'],
                        "created_dt"    =>  date('Y-m-d H:i:s'),
                        "created_ip"    =>  $_SERVER['REMOTE_ADDR']
                    );
        
                    $this->Admin_Process->f_insert('td_earning_deduction', $ddata_array);
                }
				
				$this->session->set_flashdata('msg', 'Successfully added!');
				redirect('salary/eardedu');
			 } else {
			 	$this->session->set_flashdata('msg', ' Exist');
			 	redirect('salary/eardedu');
			 }
		} else {
            $where  = array('bank_id' => $this->session->userdata['loggedin']['bank_id'],'emp_status'=>'A');
            $data['emps'] = $this->Admin_Process->f_get_particulars("md_employee", NULL, $where, 0);
            $data['epayhead'] = $this->Admin_Process->f_get_particulars("md_pay_head", NULL, array('pay_flag'=>'E','bank_id'=>$this->session->userdata['loggedin']['bank_id']), 0);
           
            $data['dpayhead'] = $this->Admin_Process->f_get_particulars("md_pay_head", NULL, array('pay_flag'=>'D','bank_id'=>$this->session->userdata['loggedin']['bank_id']), 0);
          
			$this->load->view('post_login/payroll_main');
			$this->load->view("earning_deduction/add",$data);
			$this->load->view('post_login/footer');
		}
	}
    public function eardeduedit()
	{
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

              $epay_cd  = $this->input->post('epay_cd');
              $eamount  = $this->input->post('eamount');
              $emp_cd   = $this->input->post('emp_cd');
        
                for ($i = 0; $i < count($epay_cd); $i++) {

                    $data_array = array(
                        "amount"        =>  $eamount[$i],
                        "modified_by"    =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"    =>  date('Y-m-d H:i:s'),
                        "modified_ip"    =>  $_SERVER['REMOTE_ADDR']
                    );
                    //  *****  Data Set For Adding New Data    *****  //
                    $data_add = array(
                        'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
                        "effective_dt"  =>  $this->input->post('effective_dt'),
                        "emp_no"        =>  $emp_cd,
                        "pay_head_id"   =>  $epay_cd[$i],
                        'pay_head_type' =>  'E',
                        "amount"        =>  $eamount[$i],
                        "created_by"    =>  $this->session->userdata('loggedin')['user_id'],
                        "created_dt"    =>  date('Y-m-d H:i:s'),
                        "created_ip"    =>  $_SERVER['REMOTE_ADDR'],
                    );
                    //  *****  Data Set For Adding New Data    *****  //
                    $where   = array(
                        'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
                        "effective_dt"  =>  $this->input->post('effective_dt'),
                        "emp_no"        =>  $emp_cd,
                        "pay_head_id"   =>  $epay_cd[$i],
                        'pay_head_type' =>  'E',
                    );
                    $checke = $this->db->get_where('td_earning_deduction', $where   = array(
                        'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
                        "effective_dt"  =>  $this->input->post('effective_dt'),
                        "emp_no"        =>  $emp_cd,
                        "pay_head_id"   =>  $epay_cd[$i],
                        'pay_head_type' =>  'E',
                    ))->result();
                    if(count($checke) > 0){
                        $this->Admin_Process->f_edit('td_earning_deduction',$data_array,$where);
                    }else{
                        $this->Admin_Process->f_insert('td_earning_deduction', $data_add);
                    }
        
                    
                }
                $dpay_cd  = $this->input->post('dpay_cd');
                $damount  = $this->input->post('damount');
                $account_no  = $this->input->post('account_no');
                for ($i = 0; $i < count($dpay_cd); $i++) {
                    $ddata_array = array(
                        "amount"        =>  $damount[$i],
                        "account_no"    =>  $account_no[$i],
                        "modified_by"    =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"    =>  date('Y-m-d H:i:s'),
                        "modified_ip"    =>  $_SERVER['REMOTE_ADDR']
                    );
                    ///    ***  Code For Adding Data 
                    $ddata_add = array(
                        'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
                        "effective_dt"  =>  $this->input->post('effective_dt'),
                        "emp_no"        =>  $emp_cd,
                        "pay_head_id"   =>  $dpay_cd[$i],
                        'pay_head_type' =>  'D',
                        "amount"        =>  $damount[$i],
                        "created_by"    =>  $this->session->userdata('loggedin')['user_id'],
                        "created_dt"    =>  date('Y-m-d H:i:s'),
                        "created_ip"    =>  $_SERVER['REMOTE_ADDR']
                    );
                    ///    ***  Code For Adding Data 
                    $dwhere   = array(
                        'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
                        "effective_dt"  =>  $this->input->post('effective_dt'),
                        "emp_no"        =>  $emp_cd,
                        "pay_head_id"   =>  $dpay_cd[$i],
                        'pay_head_type' =>  'D',
                    );

                    $checke = $this->db->get_where('td_earning_deduction', $where   = array(
                        'bank_id'       =>  $this->session->userdata['loggedin']['bank_id'],
                        "effective_dt"  =>  $this->input->post('effective_dt'),
                        "emp_no"        =>  $emp_cd,
                        "pay_head_id"   =>  $dpay_cd[$i],
                        'pay_head_type' =>  'D',
                    ))->result();
                    if(count($checke) > 0){
                        $this->Admin_Process->f_edit('td_earning_deduction',$ddata_array,$dwhere);
                    }else{
                        $this->Admin_Process->f_insert('td_earning_deduction', $ddata_add);
                    }
                }
				
				$this->session->set_flashdata('msg', 'Successfully added!');
            redirect('salary/eardedu');
        }else{
        $select = array(
            "a.emp_name","a.emp_code","a.basic_pay","b.effective_dt","b.pay_head_id","b.pay_head_type","b.account_no","c.input_flag","c.percentage","b.amount","c.pay_head"
        );
        $id = $this->input->get('id'); 
        $qdata = explode('/',$id);
        $bank_id = $this->session->userdata['loggedin']['bank_id'];
        $where = array(
            'a.bank_id' => $this->session->userdata['loggedin']['bank_id'],
            "a.emp_code = b.emp_no" =>  NULL,
            "b.pay_head_id = c.sl_no" =>  NULL,
            "b.effective_dt"        =>  $qdata['1'],
            "a.emp_code"            =>  $qdata['0'],
            'b.bank_id' => $this->session->userdata['loggedin']['bank_id'],
            'c.bank_id' => $this->session->userdata['loggedin']['bank_id']
        );

        $data['earning_dtls']  = $this->Salary_Process->f_get_particulars("md_employee a,td_earning_deduction b , md_pay_head c", $select, $where, 0);
        $sql = 'select pay_head_id from td_earning_deduction where effective_dt = "'.$qdata['1'].'" AND emp_no ="'.$qdata['0'].'" AND bank_id ="'.$bank_id.'"';
        $data['epayhead'] = $this->Admin_Process->f_get_particulars("md_pay_head", NULL, array('pay_flag'=>'E','bank_id'=>$bank_id,'sl_no NOT IN('.$sql.')'=> NULL), 0);
    
        $data['dpayhead'] = $this->Admin_Process->f_get_particulars("md_pay_head", NULL, array('pay_flag'=>'D','bank_id'=>$bank_id,'sl_no NOT IN('.$sql.')'=> NULL), 0);
        $this->load->view('post_login/payroll_main');
        $this->load->view("earning_deduction/edit", $data);
        $this->load->view('post_login/footer');
       }
    }

    public function earning()
    {                     //Dashboard
        $sal_dtls = $this->Salary_Process->calculate_final_gross();
        $i = 0;
        $earning['sal_dtls'] = $sal_dtls;
        $this->load->view('post_login/payroll_main');
        $this->load->view("earning/dashboard", $earning);
        $this->load->view('post_login/footer');
    }

    public function earning_add()
    {                 //Add
        $catg_id = $this->input->get('catg_id');
        $sal_dt = $this->input->get('sys_dt');
        $sal_flag = $this->input->get('flag');
		
		
        $selected = array(
            'catg_id' => $catg_id > 0 ? $catg_id : '',
            'sal_date' => $sal_dt ? $sal_dt : date('Y-m-d'),
            'sal_flag' => $sal_flag ? $sal_flag : 0
        );

        $sal_list = array();
        $select = 'id, category';
        $catg_list = $this->Admin_Process->f_get_particulars("md_category", $select, NULL, 0);
    
        if (isset($_REQUEST['submit'])) {
            if ($catg_id > 0) {
                $sal_dt = $this->Salary_Process->earningDtls($catg_id, $sal_dt);
                $i = 0;
                foreach ($sal_dt as $dt) {
                    $sal_list[$i] = array(
                        'emp_name' => $dt->emp_name,
                        'emp_code' => $dt->emp_code,
                        'basic' => $dt->basic,
                        'sp' => $dt->sp,
                        'da' => $dt->da,
                        'hra' => $dt->hra,
                        'ma' => $dt->ma,
                        'sa' => $dt->sa,
                        'ta' => $dt->ta,
                        'arrear' => $dt->arrear,
                        'ot' => $dt->ot,
                        'gross' => $dt->gross,
                        'lwp' => $dt->lwp,
                        'final_gross' => $dt->final_gross
                    );
                    $i++;
                }
            } else {
			     
                $where = array('id' => $this->input->post('catg_id'));
                $sal_cal = $this->Admin_Process->f_get_particulars("md_category", null, $where, 1);
				// echo 'test';echo $sal_cal->hra; die();
                $emp_list = $this->Salary_Process->get_emp_dtls($this->input->post('catg_id'));
                $i = 0;
                foreach ($emp_list as $emp) {
                    $sa = round(($emp->basic_pay * $sal_cal->sa) / 100);    //  SA PERCENTAGE UTILIZE AS ARREAR
                    $da = round((($emp->basic_pay) * $sal_cal->da) / 100);
                  //  $hra = round((($emp->basic_pay + $sa) * $sal_cal->hra) / 100);
					  $hra = round((($emp->basic_pay) * $sal_cal->hra) / 100);
                    $ma = round($sal_cal->ma);

                    $gross = $emp->basic_pay + $sa + $da + $hra + $ma;
                    $sal_list[$i] = array(
                        'emp_name' => $emp->emp_name,
                        'emp_code' => $emp->emp_code,
                        'basic' => $emp->basic_pay,
                        'sp' => 0.00,
                        'da' => $da,
                        'hra' => $hra,
                        'ma' => $ma,
                        'sa' => 0.00,
                        'ta' => 0.00,
                        'arrear' => $sa,
                        'ot' => 0.00,
                        'gross' => $gross,
                        'lwp' => 0,
                        'final_gross' => $gross
                    );
                    $i++;
                }
                $selected = array(
                    'catg_id' => $this->input->post('catg_id'),
                    'sal_date' => $this->input->post('sal_date'),
                    'sal_flag' => $sal_flag ? $sal_flag : 0
                );
            }
        }
        $data = array(
            'selected' => $selected,
            'catg_list' => $catg_list,
            'sal_list' => $sal_list
        );
        $this->load->view('post_login/payroll_main');
        $this->load->view("earning/add", $data);
        $this->load->view('post_login/footer');
    }

    function chk_sal()
    {
        $date = $this->input->get('sal_date');
        $catg_id = $this->input->get('catg_id');
        $table_name = 'td_income';
        $select = 'emp_code, effective_date, catg_id';
        $where = array(
            'MONTH(effective_date)' => date('m', strtotime($date)),
            'YEAR(effective_date)' => date('Y', strtotime($date)),
            'catg_id' => $catg_id
        );
        $res_dt = $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
        if (count($res_dt) > 0) {
            echo true;
        } else {
            echo false;
        }
        // var_dump($res_dt);
    }

    function earning_save()
    {
        $data = $this->input->post();
        if ($data['flag'] == 0) {
            $table_name = 'td_income';
            $select = 'emp_code, effective_date, catg_id';
            $where = array(
                'MONTH(effective_date)' => date('m', strtotime($data['sal_date'])),
                'YEAR(effective_date)' => date('Y', strtotime($data['sal_date'])),
                'catg_id' => $data['catg_id']
            );
            $res_dt = $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
            if (count($res_dt) > 0) {
                $this->session->set_flashdata('msg', 'Earning is already exist for this month');
                redirect('slrydtl');
            } else {
                if ($this->Salary_Process->earning_save($data)) {
                    $this->session->set_flashdata('msg', 'Successfully Inserted!');
                    redirect('slrydtl');
                } else {
                    $this->session->set_flashdata('msg', 'Data Not Inserted!');
                    redirect('slryad');
                }
            }
        } else {
            if ($this->Salary_Process->earning_save($data)) {
                $this->session->set_flashdata('msg', 'Successfully Inserted!');
                redirect('slrydtl');
            } else {
                $this->session->set_flashdata('msg', 'Data Not Inserted!');
                redirect('slryad');
            }
        }
    }

    public function f_sal_dtls()
    {                      //Salary earning amounts

        $emp_code = $this->input->get('emp_code');

        $data     = $this->Salary_Process->f_sal_dtls($emp_code);

        echo json_encode($data);
    }

    public function f_emp_dtls()
    {                   //Employee Details 

        $emp_code = $this->input->get('emp_code');

        $select   = array(
            "a.emp_code", "a.emp_name", "a.emp_catg", "b.district_name", "c.category_type"
        );

        $where    = array(
            "a.emp_dist = b.district_code" => NULL,
            "a.emp_catg = c.category_code" => NULL,
            "a.emp_code" => $emp_code
        );

        $data = $this->Salary_Process->f_get_particulars("md_employee a,md_district b,md_category c", $select, $where, 1);

        echo json_encode($data);
    }

    public function earning_edit()
    {                                         //Edit

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $sal_date   =   $this->input->post('sal_date');

            $emp_cd     =   $this->input->post('emp_code');

            $da         =   $this->input->post('da');

            $hra        =   $this->input->post('hra');

            $ma         =   $this->input->post('ma');

            $oa         =   $this->input->post('oa');

            $data_array = array(

                "da_amt"         =>  $da,

                "hra_amt"        =>  $hra,

                "med_allow"      =>  $ma,

                "othr_allow"     =>  $oa,

                "modified_by"    => $this->session->userdata['loggedin']['user_id'],

                "modified_dt"    =>  date('Y-m-d h:i:s')

            );

            $where = array(

                "emp_code"           =>  $emp_cd,

                "effective_date"     =>  $sal_date

            );

            $this->session->set_flashdata('msg', 'Successfully Updated!');

            $this->Salary_Process->f_edit('td_income', $data_array, $where);

            redirect('slrydtl');
        } else {

            $select = array(
                "a.*", "b.*", "c.*", "d.*"
            );

            $where = array(
                "a.emp_code = b.emp_code"           =>  NULL,

                "a.emp_catg = c.category_code"      => NULL,

                "a.emp_dist = d.district_code"      => NULL,

                "b.effective_date"                  =>  $this->input->get('date'),

                "a.emp_code"                        =>  $this->input->get('emp_code')

            );

            $earning['earning_dtls']  = $this->Salary_Process->f_get_particulars("md_employee a,td_income b,md_category c,md_district d", NULL, $where, 1);

            $this->load->view('post_login/payroll_main');
            $this->load->view("earning/edit", $earning);
            $this->load->view('post_login/footer');
        }
    }

    public function earning_delete()
    {                      //Delete income

        $where = array(

            "emp_code"          =>  $this->input->get('emp_code'),

            "effective_date"    =>  $this->input->get('effective_date')

        );

        $this->session->set_flashdata('msg', 'Successfully Deleted!');

        $this->Salary_Process->f_delete('td_income', $where);

        redirect("slrydtl");
    }

    public function deduction()
    {                       //Deduction Dashboard

        $data['deduction_list'] = $this->Salary_Process->calculate_final_deduction();
        $this->load->view('post_login/payroll_main');
        $this->load->view("deduction/dashboard", $data);
        $this->load->view('post_login/footer');
    }

    public function deduction_add()
    {                       //Add Dedcutions
        $catg_id = $this->input->get('catg_id');
        $sal_dt = $this->input->get('sys_dt');
        $sal_flag = $this->input->get('flag');
        $selected = array(
            'catg_id' => $catg_id > 0 ? $catg_id : '',
            'sal_date' => $sal_dt ? $sal_dt : date('Y-m-d'),
            'sal_flag' => $sal_flag ? $sal_flag : 0
        );

        $sal_list = array();
        $select = 'id, category';
        $catg_list = $this->Admin_Process->f_get_particulars("md_category", $select, NULL, 0);

        if (isset($_REQUEST['submit'])) {
            if ($catg_id > 0) {
                $sal_dt = $this->Salary_Process->deductionDtls($catg_id, $sal_dt);
                $i = 0;
                foreach ($sal_dt as $dt) {
                    $sal_list[$i] = array(
                        'emp_name' => $dt->emp_name,
                        'emp_code' => $dt->emp_code,
                        'gross' => $dt->gross,
                        'it' => $dt->it,
                        'cpf' => $dt->cpf,
                        'gpf' => $dt->gpf,
                        'gigs' => $dt->gigs,
                        'lpf' => $dt->lpf,
                        'fa' => $dt->fa,
                        'gi' => $dt->gi,
                        'top' => $dt->top,
                        'eccs' => $dt->eccs,
                        'hblp' => $dt->hblp,
                        'hbli' => $dt->hbli,
                        's_adv' => $dt->s_adv,
                        'tot_diduction' => $dt->tot_diduction,
                        'net_sal' => $dt->net_sal
                    );
                    $i++;
                }
            } else {
                $where = array('id' => $this->input->post('catg_id'));
                $sal_cal = $this->Admin_Process->f_get_particulars("md_category", null, $where, 1);
                $emp_list = $this->Salary_Process->get_emp_dtls($this->input->post('catg_id'));
                // echo '<pre>';
                // var_dump($emp_list);
                // exit;
                $i = 0;
                foreach ($emp_list as $emp) {
                    $sal = $this->Salary_Process->get_last_gross($emp->emp_code);
					//echo $this->db->last_query();die();
                    $pf = $this->Salary_Process->get_ptx($sal->final_gross);
					//echo $sal->basic+$sal->sp+$sal->da+$sal->arrear;die();
                    // var_dump($pf);exit;
                    //$pf_val = $sal ? round((($sal->basic + $sal->da) * $sal_cal->da) / 100) : 'Fill Income First';
					$cpf = $sal ? round((($sal->basic+$sal->sp+$sal->da+$sal->arrear) * $sal_cal->pf) / 100) : 'Fill Income First';
                    // $pf = $pf_val > $sal_cal->pf_max ? $sal_cal->pf_max : ($pf_val < $sal_cal->pf_min ? $sal_cal->pf_min : $pf_val);
                    // var_dump($pf_val);
                    // exit;
            
                    // var_dump($ptax_val);
                    // exit;
                    // $ptax = $sal ? $ptax_val->ptax : 'Fill Income First';

                    $sal_list[$i] = array(
                        'emp_name' => $emp->emp_name,
                        'emp_code' => $emp->emp_code,
                        'gross' => $sal ? $sal->final_gross : 'Fill Income First',
                        'it' => 0,
                        'cpf' => $cpf,
                        'gpf' => 0,
                        'gigs' => 0,
                        'lpf' => 0,
                        'fa' => 0,
                        'gi' => 0,
                        'top' => $pf->ptax,
                        'eccs' => 0,
                        'hblp' => 0,
                        'hbli' => 0,
                        's_adv' => 0,
                        'tot_diduction' => $sal ? $cpf + $pf->ptax : 'Fill Income First',
                        'net_sal' => $sal ? $sal->final_gross - ($cpf + $pf->ptax) : 'Fill Income First'
                    );
                    $i++;
                }
                $selected = array(
                    'catg_id' => $this->input->post('catg_id'),
                    'sal_date' => $this->input->post('sal_date'),
                    'sal_flag' => $sal_flag ? $sal_flag : 0
                );
            }
        }
        $data = array(
            'selected' => $selected,
            'catg_list' => $catg_list,
            'sal_list' => $sal_list
        );
        $this->load->view('post_login/payroll_main');
        $this->load->view("deduction/add", $data);
        $this->load->view('post_login/footer');
    }

    function chk_deduction()
    {
        $date = $this->input->get('sal_date');
        $catg_id = $this->input->get('catg_id');
        $table_name = 'td_deductions';
        $select = 'emp_code, effective_date, catg_id';
        $where = array(
            'MONTH(effective_date)' => date('m', strtotime($date)),
            'YEAR(effective_date)' => date('Y', strtotime($date)),
            'catg_id' => $catg_id
        );
        $res_dt = $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
        if (count($res_dt) > 0) {
            echo true;
        } else {
            echo false;
        }
        // var_dump($res_dt);
    }

    function deduction_save()
    {
        $data = $this->input->post();
        if ($data['flag'] == 0) {
            $table_name = 'td_deductions';
            $select = 'emp_code, effective_date, catg_id';
            $where = array(
                'MONTH(effective_date)' => date('m', strtotime($data['sal_date'])),
                'YEAR(effective_date)' => date('Y', strtotime($data['sal_date'])),
                'catg_id' => $data['catg_id']
            );
            $res_dt = $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
            if (count($res_dt) > 0) {
                $this->session->set_flashdata('msg', 'Deduction is already exist for this month');
                redirect('slryded');
            } else {
                if ($this->Salary_Process->deduction_save($data)) {
                    $this->session->set_flashdata('msg', 'Successfully Inserted!');
                    redirect('slryded');
                } else {
                    $this->session->set_flashdata('msg', 'Data Not Inserted!');
                    redirect('slrydedad');
                }
            }
        } else {
            if ($this->Salary_Process->deduction_save($data)) {
                $this->session->set_flashdata('msg', 'Successfully Inserted!');
                redirect('slryded');
            } else {
                $this->session->set_flashdata('msg', 'Data Not Inserted!');
                redirect('slrydedad');
            }
        }
    }

    public function deduction_edit()
    {                                     //Edit Deductions

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $emp_cd     =   $this->input->post('emp_code');

            $data_array = array(

                // "ded_yr"           =>  $this->input->post('year'),

                // "ded_month"        =>  $this->input->post('month'),

                "insuarance"       =>  $this->input->post('sal_ins'),

                "ccs"              =>  $this->input->post('ccs'),

                "hbl"              =>  $this->input->post('hbl'),

                "telephone"        =>  $this->input->post('phone'),

                "med_adv"          =>  $this->input->post('med_adv'),

                "festival_adv"     =>  $this->input->post('fest_adv'),

                "tf"               =>  $this->input->post('tf'),

                "med_ins"          =>  $this->input->post('med_ins'),

                "comp_loan"        =>  $this->input->post('comp_loan'),

                "itax"             =>  $this->input->post('itax'),

                "gpf"              =>  $this->input->post('gpf'),

                "epf"              =>  $this->input->post('epf'),

                "other_deduction"  =>  $this->input->post('other_ded'),

                "ptax"             =>  $this->input->post('ptax'),

                "modified_by"      =>  $this->session->userdata['loggedin']['user_id'],

                "modified_dt"      =>  date('Y-m-d h:i:s')

            );


            $where = array(

                "emp_cd"       =>  $emp_cd

            );

            $this->session->set_flashdata('msg', 'Successfully Updated!');

            $this->Salary_Process->f_edit('td_deductions', $data_array, $where);

            redirect('slryded');
        } else {

            $emp_cd     =   $this->input->get('emp_cd');

            $select = array(

                "a.*", "b.*", "c.*", "d.*"

            );

            $where = array(

                "a.emp_code = b.emp_cd"         => NULL,

                "a.emp_dist = c.district_code"  => NULL,

                "a.emp_catg = d.category_code"  => NULL,

                "b.emp_cd"                      =>  $emp_cd

            );

            $deduction['month_list']        =   $this->Salary_Process->f_get_particulars("md_month", NULL, NULL, 0);

            $deduction['deduction_dtls']    =   $this->Salary_Process->f_get_particulars("md_employee a,td_deductions b,md_district c,md_category d", NULL, $where, 1);

            $this->load->view('post_login/payroll_main');

            $this->load->view("deduction/edit", $deduction);

            $this->load->view('post_login/footer');
        }
    }

    public function deduction_delete()
    {                   //Delete

        $where = array(

            "emp_cd"    =>  $this->input->get('empcd')

        );

        $this->session->set_flashdata('msg', 'Successfully Deleted!');

        $this->Salary_Process->f_delete('td_deductions', $where);

        redirect("slryded");
    }


    public function generation_delete()
    {      //unapprove salary slip delete       

        $where = array(
            "trans_date"  =>  $this->input->get('date'),
            "trans_no"    =>  $this->input->get('trans_no'),
            "sal_month"   => $this->input->get('month'),
            "sal_year"    =>  $this->input->get('year'),
            "catg_cd" => $this->input->get('catg_id'),
            "approval_status" => 'U'
        );

        $where1 = array(
            "trans_dt"  =>  $this->input->get('date'),
            "trans_no"    =>  $this->input->get('trans_no'),
            "sal_month"   => $this->input->get('month'),
            "sal_year"    =>  $this->input->get('year'),
            "catg_id" => $this->input->get('catg_id')
        );

        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->Salary_Process->f_delete('td_salary', $where);
        $this->Salary_Process->f_delete('td_pay_slip', $where1);
        redirect('genspl');
    }



    public function generate_slip()
    {                                //Payslip Generation

        //Generation Details           
     
       $generation['generation_dtls']  =   $this->Salary_Process->generate_slip($trans_dt = null, $month = null, $year = null, $catg_id = null, $trans_no = null, 0);
      
		//$generation['generation_dtls']  =   $this->Admin_Process->f_get_particulars('td_salary',NULL,array('approval_status'=>'U'), 0);

        $this->load->view('post_login/payroll_main');
        $this->load->view("generation/dashboard", $generation);
        $this->load->view('post_login/footer');
    }
    function generation_view()
    {
        $trans_dt = $this->input->get('trans_dt');
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $catg_id = $this->input->get('catg_id');
        $trans_no = $this->input->get('trans_no');
        $bank_id = $this->session->userdata['loggedin']['bank_id'];
        $generation['sal_dtls']  =   $this->Salary_Process->generate_slip($trans_dt, $month, $year, $catg_id, $trans_no, 1);
        //Category List
        $generation['category']   =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);
        $generation['sal_list']   =   $this->Salary_Process->sal_emp_amt($trans_dt, $month, $year, $catg_id, $trans_no,$bank_id);
   
        $this->load->view('post_login/payroll_main');
        $this->load->view("generation/edit_view", $generation);
        $this->load->view('post_login/footer');
    }
    public function get_required_yearmonth()
    {
        $bank_id = $this->session->userdata['loggedin']['bank_id'];
        $category = $this->input->post('category');
        $max_year =   $this->Salary_Process->f_get_particulars("td_salary", NULL, array("bank_id"=>$bank_id,"approval_status" => 'S', 'catg_cd' => $category, '1 ORDER BY sal_year DESC, sal_month DESC limit 1' => NULL), 1);
 
        // exit;
        if($max_year) {
            if ($max_year->sal_month == 12) {
                $data['year'] = ($max_year->sal_year) + 1;
                $data['month'] = 1;
                $data['monthn'] = 'January';
            } else {
                $data['year'] = $max_year->sal_year ? $max_year->sal_year : date('Y');
                $data['month'] = $max_year->sal_month ? ($max_year->sal_month) + 1 : date('m');
                $data['monthn'] = $this->Salary_Process->f_get_particulars("md_month", NULL, array('id' => $data['month']), 1)->month_name;
            }
        } else {
            // $data['year'] = $max_year ? $max_year->sal_year : date('Y');
            // $data['month'] = $max_year ? ($max_year->sal_month) + 1 : date('m');
            $data['year'] = date('Y', strtotime('first day of last month'));
            $data['month'] = date('m', strtotime('first day of last month'));
            $data['monthn'] = $this->Salary_Process->f_get_particulars("md_month", NULL, array('id' => $data['month']), 1)->month_name;
        }

        echo  json_encode($data);
    }


    public function generation_add()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $trans_dt     =   $this->input->post('sal_date');
            $sal_month    =   $this->input->post('month');
            $year         =   $this->input->post('year');
            $category     =   $this->input->post('category');
            $bank_id = $this->session->userdata['loggedin']['bank_id'];
            //Check given category exsit or not
            //for given month and date
            $select     =   array("catg_cd");
            $where      =   array(
                "bank_id"       => $bank_id, 
                "catg_cd"       =>  $category,
                "sal_month"     =>  $sal_month,
                "sal_year"      =>  $year
            );
            $flag     =   $this->Salary_Process->f_get_particulars("td_salary", $select, $where, 1);
            //echo $this->db->last_query(); die();
            if ($flag) {
                $this->session->set_flashdata('msg', 'For this month and category Payslip already generated!');
            } else {
                //Retrive max trans no
                $select     =   array("MAX(trans_no) trans_no");
                $where      =   array(
                    "bank_id"       => $bank_id, 
                    "trans_date"    =>  $trans_dt,
                    "sal_month"     =>  $sal_month,
                    "sal_year"      =>  $year
                );

                $trans_no     =   $this->Salary_Process->f_get_particulars("td_salary", $select, $where, 1);
                $data_array = array(
                    'bank_id' => $this->session->userdata['loggedin']['bank_id'],
                    "trans_date"   =>  $trans_dt,
                    "trans_no"     => ($trans_no != NULL) ? ($trans_no->trans_no + 1) : '1',
                    "sal_month"    =>  $sal_month,
                    "sal_year"     =>  $year,
                    "catg_cd"      =>  $category,
                    "approval_status" => 'U',
                    "created_by"   =>  $this->session->userdata['loggedin']['user_id'],
                    "created_dt"   =>  date('Y-m-d h:i:s')
                );

                if ($this->Salary_Process->f_insert("td_salary", $data_array)) {
                    $emp_list = $this->Salary_Process->get_emp_dtls($category);
                  
                    foreach ($emp_list as $emp) {
                        // if($emp->emp_code != 1108 && $emp->emp_code != 1144){
                        //     continue;
                        // } 
                        $table_name = 'td_earning_deduction a';
                        $select = 'a.emp_no,a.pay_head_id,a.pay_head_type,a.amount, a.account_no';
                        $er_where = array(
                            'a.emp_no' => $emp->emp_code,
                            'a.bank_id'=> $this->session->userdata['loggedin']['bank_id'],
                            'a.effective_dt = (SELECT MAX(c.effective_dt) FROM td_earning_deduction c where c.emp_no = "'.$emp->emp_code.'" AND c.bank_id = "'.$bank_id.'")' => null
                        );
                         $basic_pay = $this->Salary_Process->get_basicpay($emp->emp_code,$this->session->userdata['loggedin']['bank_id']);
                        $erning_dts = $this->Admin_Process->f_get_particulars($table_name, $select, $er_where, 0);
                        
                       $row_count = $this->db->get_where('td_earning_deduction', array('emp_no =' => $emp->emp_code,'bank_id'=>$bank_id))->result();
                        $gross = 0;
                       if(count($row_count) > 1){
                            $input_basic = array(
                                'bank_id' => $this->session->userdata['loggedin']['bank_id'],
                                'branch_id' => $emp->branch_id,
                                'trans_dt' => $trans_dt,
                                'trans_no' => $data_array['trans_no'],
                                'sal_month' => $sal_month,
                                'sal_year' => $year,
                                'emp_code' => $emp->emp_code,
                                'desig_id' => $emp->designation,
                                'catg_id' => $category,
                                'pay_head_id' => 0,
                                'pay_head_type' => 'E',
                                'amount' => $basic_pay,
                                'created_by' => $this->session->userdata['loggedin']['user_id'],
                                'created_dt' => date('Y-m-d h:i:s'),
                                'created_ip' => $_SERVER["REMOTE_ADDR"]
                            );
                            $this->Salary_Process->f_insert("td_pay_slip", $input_basic);
                            $gross += $basic_pay;
                        }
                       $da = 0;
                       foreach($erning_dts as $erning_dt){
                            $input = array(
                                'bank_id' => $this->session->userdata['loggedin']['bank_id'],
                                'branch_id' => $emp->branch_id,
                                'trans_dt' => $trans_dt,
                                'trans_no' => $data_array['trans_no'],
                                'sal_month' => $sal_month,
                                'sal_year' => $year,
                                'emp_code' => $emp->emp_code,
                                'desig_id' => $emp->designation,
                                'catg_id' => $category,
                                'pay_head_id' => $erning_dt->pay_head_id,
                                'pay_head_type' => $erning_dt->pay_head_type,
                                'amount' => $erning_dt->amount,
                                'account_no' => $erning_dt->account_no,
                                'created_by' => $this->session->userdata['loggedin']['user_id'],
                                'created_dt' => date('Y-m-d h:i:s'),
                                'created_ip' =>$_SERVER["REMOTE_ADDR"]
                            );
                            $this->Salary_Process->f_insert("td_pay_slip", $input);
                            if($erning_dt->pay_head_id == PAYHEAD_DA){
                                $da = $erning_dt->amount;
                            }
                            $gross += $erning_dt->pay_head_type == 'E' ? $erning_dt->amount : 0;
                       }
                        
                       //checked arrear da amount
                        $where = array(
                            'emp_code' => $emp->emp_code,
                            'bank_id' => $this->session->userdata['loggedin']['bank_id'],
                            'sal_month' => $sal_month,
                            'sal_year' => $year,
                            'pay_head_id' => PAYHEAD_ARREAR_DA
                        );
                        $query = $this->db->get_where('td_pay_slip', $where);
                        if ($query->num_rows() > 0) {
                            $result = $query->row();
                            $arrear_da = $result->amount;
                            $total = $basic_pay + $da + $arrear_da;
                            $pf = round($total * 0.12);
                            $input = array(
                                'amount' => $pf
                            );
                            $this->db->where(array('emp_code' => $emp->emp_code, 'bank_id' => $this->session->userdata['loggedin']['bank_id'], 'sal_month' => $sal_month, 'sal_year' => $year, 'pay_head_id' => PAYHEAD_PF))->update('td_pay_slip', $input);
                        }
                        $this->db->select('tax_amt');
                        $this->db->where(array(
                            'from_amt <=' => $gross,
                            'to_amt >=' => $gross,
                        ));
                        $query = $this->db->get('md_ptax_slab');
                        $ptax = 0;
                        if ($query->num_rows() > 0) {
                            $ptax = $query->row()->tax_amt;
                        }
                        $input = array(
                            'amount' => $ptax
                        );
                        $this->db->where(array(
                            'emp_code' => $emp->emp_code,
                            'sal_month' => $sal_month,
                            'sal_year' => $year,
                            'pay_head_id' => PAYHEAD_PTAX
                        ))->update('td_pay_slip', $input);
                    }
                }

                $this->session->set_flashdata('msg', 'Successfully generated!');
            }

            redirect('genspl');
        } else {

            //Month List
            $generation['month_list'] =   $this->Salary_Process->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $generation['sys_date']   =   $_SESSION['sys_date'];

            //Last payslip generation date
            $generation['generation_dtls']    =   $this->Salary_Process->f_get_generation();

            //Category List
            $generation['category']   =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);

            $this->load->view('post_login/payroll_main');

            $this->load->view("generation/add", $generation);

            $this->load->view('post_login/footer');
        }
    }






    /*************************REPORTS**************************/

    //For Categorywise Salary Report
    public function f_salary_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {


            //Employee Ids for Salary List
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  $this->input->post('category')

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for ($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);
            }


            //List of Salary Category wise
            unset($where);
            $where = array(

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year"      =>  $this->input->post('year')

            );

            $salary['list']               =   $this->Payroll->f_get_particulars_in("td_pay_slip", $eid_list, $where);

            $salary['attendance_dtls']    =   $this->Payroll->f_get_attendance();

            //Employee Group Count
            unset($select);
            unset($where);

            $select =   array(

                "emp_no", "emp_name", "COUNT(emp_name) count"

            );

            $where  =   array(

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year = '" . $this->input->post('year') . "' GROUP BY emp_no, emp_name"      =>  NULL

            );

            $salary['count']              =   $this->Payroll->f_get_particulars("td_pay_slip", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salary", $salary);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $salary['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $salary['sys_date']   =   $_SESSION['sys_date'];

            //Category List
            $salary['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salary", $salary);

            $this->load->view('post_login/footer');
        }
    }
    //////////////////////////////////////////////////////////////////////////
    public function f_salaryold_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {


            //Employee Ids for Salary List
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  $this->input->post('category')

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for ($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);
            }


            //List of Salary Category wise
            unset($where);
            $where = array(

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year"      =>  $this->input->post('year')

            );

            $salary['list']               =   $this->Payroll->f_get_particulars_in("td_pay_slip_old ", $eid_list, $where);

            $salary['attendance_dtls']    =   $this->Payroll->f_get_attendance();

            //Employee Group Count
            unset($select);
            unset($where);

            $select =   array(

                "emp_no", "emp_name", "COUNT(emp_name) count"

            );

            $where  =   array(

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year = '" . $this->input->post('year') . "' GROUP BY emp_no, emp_name"      =>  NULL

            );

            $salary['count']              =   $this->Payroll->f_get_particulars("td_pay_slip_old ", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salaryold", $salary);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $salary['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $salary['sys_date']   =   $_SESSION['sys_date'];

            //Category List
            $salary['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salaryold", $salary);

            $this->load->view('post_login/footer');
        }
    }
    //////////////////////////////////////////////////////////////////////////
    //For Payslip Report
    public function f_payslip_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            //Payslip
            $where  =   array(

                "emp_no"            =>  $this->input->post('emp_cd'),

                "sal_month"         =>  $this->input->post('sal_month'),

                "sal_year"          =>  $this->input->post('year'),

                "approval_status"   =>  'A'

            );

            $payslip['emp_dtls']    =   $this->Payroll->f_get_particulars("md_employee", NULL, array("emp_code" =>  $this->input->post('emp_cd')), 1);

            $payslip['payslip_dtls'] =   $this->Payroll->f_get_particulars("td_pay_slip", NULL, $where, 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslip", $payslip);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $payslip['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $payslip['sys_date']   =   $_SESSION['sys_date'];

            //Employee List
            unset($select);
            $select = array("emp_code", "emp_name");

            $payslip['emp_list']   =   $this->Payroll->f_get_particulars("md_employee", $select, array("emp_catg IN (1,2,3)" => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslip", $payslip);

            $this->load->view('post_login/footer');
        }
    }

    //////////////////////////////////////////////////////////////////

    public function f_payslipold_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            //Payslip
            $where  =   array(

                "emp_no"            =>  $this->input->post('emp_cd'),

                "sal_month"         =>  $this->input->post('sal_month'),

                "sal_year"          =>  $this->input->post('year'),

                "approval_status"   =>  'A'

            );

            $payslip['emp_dtls']    =   $this->Payroll->f_get_particulars("md_employee", NULL, array("emp_code" =>  $this->input->post('emp_cd')), 1);

            $payslip['payslip_dtls'] =   $this->Payroll->f_get_particulars("td_pay_slip_old ", NULL, $where, 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslipold", $payslip);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $payslip['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $payslip['sys_date']   =   $_SESSION['sys_date'];

            //Employee List
            unset($select);
            $select = array("emp_code", "emp_name");

            $payslip['emp_list']   =   $this->Payroll->f_get_particulars("md_employee", $select, array("emp_catg IN (1,2,3)" => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslipold", $payslip);

            $this->load->view('post_login/footer');
        }
    }

    //For Salary Statement
    public function f_statement_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employees salary statement
            $select = array(

                "m.emp_name", "m.bank_ac_no",

                "t.net_amount"

            );

            $where  = array(

                "m.emp_code = t.emp_no" =>  NULL,

                "t.sal_month"           =>  $this->input->post('sal_month'),

                "t.sal_year"            =>  $this->input->post('year'),

                "m.emp_catg"            =>  $this->input->post('category'),

                "m.emp_status"          =>  'A',

                "m.deduction_flag"      =>  'Y'

            );

            $statement['statement'] =   $this->Payroll->f_get_particulars("md_employee m, td_pay_slip t", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statement", $statement);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $statement['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //Category List
            $statement['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statement", $statement);

            $this->load->view('post_login/footer');
        }
    }
    //////////////////////////////////////
    public function f_statementold_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employees salary statement
            $select = array(

                "m.emp_name", "m.bank_ac_no",

                "t.net_amount"

            );

            $where  = array(

                "m.emp_code = t.emp_no" =>  NULL,

                "t.sal_month"           =>  $this->input->post('sal_month'),

                "t.sal_year"            =>  $this->input->post('year'),

                "m.emp_catg"            =>  $this->input->post('category'),

                "m.emp_status"          =>  'A',

                "m.deduction_flag"      =>  'Y'

            );

            $statement['statement'] =   $this->Payroll->f_get_particulars("md_employee m, td_pay_slip t", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statementold", $statement);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $statement['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //Category List
            $statement['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statementold", $statement);

            $this->load->view('post_login/footer');
        }
    }



    ////////////////////////////////////////

    //For Bonus Report
    public function f_bonus_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employee Ids for Bonus
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  $this->input->post('category')

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for ($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);
            }


            //List of Bonus Category wise
            unset($where);
            $where = array(

                "month"     =>  $this->input->post('month'),

                "year"      =>  $this->input->post('year')

            );

            $bonus['list']          =   $this->Payroll->f_get_particulars_in("td_bonus", $eid_list, $where);

            $bonus['bonus_dtls']    =   $this->Payroll->f_get_attendance();

            //Bonus Salary Range
            $bonus['bonus_range']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 14), 1);

            //Bonus Salary Year
            $bonus['bonus_year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/bonus", $bonus);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $bonus['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $bonus['sys_date']   =   $_SESSION['sys_date'];

            //Category List
            $bonus['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, NULL, 0);


            $this->load->view('post_login/main');

            $this->load->view("reports/bonus", $bonus);

            $this->load->view('post_login/footer');
        }
    }


    //For Incentive Report
    public function f_incentive_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employee Ids for Incentive
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  4

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for ($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);
            }


            //List of Incentive Category wise
            unset($where);
            $where = array(

                "month"     =>  $this->input->post('month'),

                "year"      =>  $this->input->post('year')

            );

            //Incentive list
            $incentive['list']          =   $this->Payroll->f_get_particulars_in("td_incentive", $eid_list, $where);

            //Incentive Year
            $incentive['incentive_year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/incentive", $incentive);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $incentive['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $incentive['sys_date']   =   $_SESSION['sys_date'];

            $this->load->view('post_login/main');

            $this->load->view("reports/incentive", $incentive);

            $this->load->view('post_login/footer');
        }
    }


    //Total Deduction Report

    public function f_totaldeduction_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $totaldeduction['total_deduct'] =   $this->Payroll->f_get_totaldeduction($this->input->post('from_date'), $this->input->post('to_date'));

            //Current Year
            $totaldeduction['year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/totaldeduction", $totaldeduction);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $totaldeduction['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $totaldeduction['sys_date']   =   $_SESSION['sys_date'];

            $this->load->view('post_login/main');

            $this->load->view("reports/totaldeduction", $totaldeduction);

            $this->load->view('post_login/footer');
        }
    }


    //PF Contribution Report
    public function f_pfcontribution_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Opening Balance Date
            $where  =   array(

                "emp_no"      => $this->input->post('emp_cd'),

                "trans_dt < " => $this->input->post("from_date")

            );

            //Max Transaction Date
            $max_trans_dt   =   $this->Payroll->f_get_particulars("tm_pf_dtls", array("MAX(trans_dt) trans_dt"), $where, 1);


            //temp variable
            $pfcontribution['pf_contribution']   =   NULL;

            if (!is_null($max_trans_dt->trans_dt)) {

                //Opening Balance
                $pfcontribution['opening_balance']   =   $this->Payroll->f_get_particulars("tm_pf_dtls", array("balance"), array("emp_no" => $this->input->post('emp_cd'), "trans_dt" => $max_trans_dt->trans_dt), 1);
            } else {

                //Opening Balance
                $pfcontribution['opening_balance']   =   0;
            }

            //PF Contribution List
            unset($where);
            $where  =   array(

                "emp_no"    => $this->input->post('emp_cd'),

                "trans_dt BETWEEN '" . $this->input->post("from_date") . "' AND '" . $this->input->post('to_date') . "'" => NULL

            );

            $pfcontribution['pf_contribution']   =   $this->Payroll->f_get_particulars("tm_pf_dtls", NULL, $where, 0);


            //Current Year
            $pfcontribution['year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            //Employee Name
            $pfcontribution['emp_name']  =   $this->Payroll->f_get_particulars("md_employee", array('emp_name'), array('emp_code' => $this->input->post('emp_cd')), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/pfcontribution", $pfcontribution);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $pfcontribution['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $pfcontribution['sys_date']   =   $_SESSION['sys_date'];

            //Employee List
            $select =   array("emp_code", "emp_name");

            $where  =   array(

                "emp_catg IN (1,2,3)"      => NULL,

                "deduction_flag"           => "Y"
            );

            $pfcontribution['emp_list']   =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/pfcontribution", $pfcontribution);

            $this->load->view('post_login/footer');
        }
    }
    public function get_basic(){
         $emp_cd = $this->input->get('emp_cd');
         $bank_id = $this->session->userdata['loggedin']['bank_id'];
         $gross = $this->Admin_Process->f_get_particulars("md_employee",NULL,array('emp_code'=>$emp_cd,'bank_id'=>$bank_id), 1);
        echo $gross->basic_pay;
    }

    public function paytype_detail(){
        $epay_cd = $this->input->get('epay_cd');
        $emp_cd = $this->input->get('emp_cd');
        $result = $this->Admin_Process->paytype_detail($emp_cd, $epay_cd);
        //$where  = array('sl_no'=>$epay_cd,'bank_id' => $this->session->userdata['loggedin']['bank_id']);
        //$result = $this->Admin_Process->f_get_particulars("md_pay_head",NULL,$where,1);
        echo json_encode($result);
    }
    public function payheadrevision_bk(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){

            $this->form_validation->set_rules('payhead_id', 'Payhead', 'required');
            $this->form_validation->set_rules('category', 'category', 'required');
            $this->form_validation->set_rules('year', 'Year', 'required|integer|exact_length[4]|greater_than_equal_to[1900]|less_than_equal_to[2100]');
            $this->form_validation->set_rules('month_id', 'Month', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[12]');
            $this->form_validation->set_rules('percentage', 'Percentage', 'required|numeric|greater_than[0]');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('/salary/payheadrevision');
            }else{
                $category = $this->input->post('category');
                $payhead_id = $this->input->post('payhead_id');
                $year = $this->input->post('year');
                $month_id = $this->input->post('month_id');
                $percentage = $this->input->post('percentage');
                $bank_id = $this->session->userdata['loggedin']['bank_id'];
               // Update each employee's payhead amount
                $data['emp_list'] = $this->Admin_Process->f_get_particulars(
                    "md_employee",
                    array('basic_pay','emp_code'),
                    array('bank_id' => $bank_id, 'emp_status' => 'A', 'emp_catg' => $category),
                    0
                );

                $this->db->trans_start(); // Start transaction

                foreach($data['emp_list'] as $emp){
                    $new_amount = round(($emp->basic_pay * $percentage) / 100); // total round
                    $this->db->set('amount', $new_amount, FALSE);
                    $this->db->where('bank_id', $bank_id);
                    $this->db->where('pay_head_id', $payhead_id);
                    $this->db->where('emp_no', $emp->emp_code);
                    $this->db->update('td_earning_deduction');
                }

                $this->db->trans_complete(); // Complete transaction

                // Check if transaction succeeded
                if ($this->db->trans_status() === FALSE) {
                    // Transaction failed: rollback happened
                    $this->session->set_flashdata('error', 'Failed to update employee payhead amounts.');
                    redirect('payheadrevision'); // redirect or handle error
                } else {
                    // Transaction succeeded: all updates applied
                     // Enclose post-salary processing in try-catch
                    try {
                        $data_array = array(
                            'bank_id'      => $bank_id,
                            'process_dttime'=> date('Y-m-d H:i:s'),
                            'years'        => $year,
                            'month_id'     => $month_id,
                            'payhead_id'   => $payhead_id,
                            'perc'         => $percentage,
                            'created_by'   => $this->session->userdata['loggedin']['user_id'],
                            'created_ip'   => $_SERVER["REMOTE_ADDR"]
                        );

                        // Insert process record
                        $this->Salary_Process->f_insert('td_payhead_process', $data_array);

                        // Update percentage in master payhead
                        $this->Salary_Process->f_edit(
                            'md_pay_head',
                            array('percentage' => $percentage),
                            array('bank_id' => $bank_id, 'sl_no' => $payhead_id)
                        );
                        $this->session->set_flashdata('success', 'Payhead process updated successfully.');
                      redirect('salary/payheadrevision');
                    } catch (Exception $e) {
                        // Handle exception
                        log_message('error', 'Payhead process error: ' . $e->getMessage());
                        $this->session->set_flashdata('error', 'Error occurred while updating payhead process.');
                        redirect('salary/payheadrevision'); // or any other page
                    }
                }
            }
        }else{
            $where  = array('bank_id' => $this->session->userdata['loggedin']['bank_id'],'input_flag'=>'A','pay_flag'=>'E' ,'sl_no !='=>0);
            $data['payhead_dtls'] = $this->Admin_Process->f_get_particulars("md_pay_head",NULL,$where,0);
            $data['month_list'] = $this->Admin_Process->f_get_particulars("md_month",NULL,NULL,0);
            $data['category'] = $this->Admin_Process->f_get_particulars("md_category",NULL,NULL,0);
            $this->load->view('post_login/payroll_main');
            $this->load->view("payhead/payheadrevision",$data);
            $this->load->view('post_login/footer');
        }
    }

    public function calculate_arrears(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){

            $this->form_validation->set_rules('payhead_id', 'Payhead', 'required');
            $this->form_validation->set_rules('category', 'category', 'required');
            $this->form_validation->set_rules('from_date', 'From Date', 'required|date');
            $this->form_validation->set_rules('to_date', 'To Date', 'required|date');
            $this->form_validation->set_rules('payment_date', 'Payment Date', 'required|date');
           // $this->form_validation->set_rules('percentage', 'Percentage', 'required|numeric|greater_than[0]');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('/salary/calculate_arrears');
            }else{
                $category = $this->input->post('category');
                $payhead_id = $this->input->post('payhead_id');
                $payment_date = $this->input->post('payment_date');
                $year = date('Y', strtotime($payment_date));
                $month = date('m', strtotime($payment_date));
                $percentage = $this->input->post('percentage');
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $bank_id = $this->session->userdata['loggedin']['bank_id'];
               // Update each employee's payhead amount
                $data['emp_list'] = $this->Admin_Process->f_get_particulars(
                    "md_employee",
                    array('emp_code','branch_id','designation'),
                    array('bank_id' => $bank_id, 'emp_status' => 'A', 'emp_catg' => $category),
                    0
                );
                $select     =   array("ifnull(MAX(trans_no), 0) trans_no");
                $where      =   array(
                    "bank_id"       => $bank_id, 
                    "sal_month"     =>  $month,
                    "sal_year"      =>  $year,
                    "catg_cd"      =>  $category,
                );

                $trans_no     =   $this->Salary_Process->f_get_particulars("td_salary", $select, $where, 1);
                $this->db->trans_start(); // Start transaction

                foreach ($data['emp_list'] as $emp) {
                    $emp_code = $emp->emp_code;
                    // if($emp_code != 1108){
                    //     continue;
                    // }
                    // 1️⃣ Fetch basic sum between from and to date
                    $this->db->select_sum('amount', 'total_basic');
                    $this->db->where('bank_id', $bank_id);
                    $this->db->where('emp_code', $emp_code);
                    $this->db->where('pay_head_id', '0'); // or BASIC payhead_id
                    $this->db->where("CONCAT(sal_year, LPAD(sal_month, 2, '0')) BETWEEN 
                                    DATE_FORMAT('$from_date', '%Y%m') AND 
                                    DATE_FORMAT('$to_date', '%Y%m')", NULL, FALSE);
                    $basic = $this->db->get('td_pay_slip')->row()->total_basic;
                    // echo $this->db->last_query();
                    // echo '<br>';
                    // echo 'basic: ' . $basic; exit;
                    // 2️⃣ Calculate arrear DA
                    $arrear_amount = round(($basic * $percentage) / 100);

                    // 3️⃣ Insert new row in td_payslip
                    $insertData = [
                        'bank_id' => $bank_id,
						'branch_id'=> $emp->branch_id,
                        'trans_dt' => $payment_date,
                        'trans_no' => ($trans_no->trans_no != 0) ? ($trans_no->trans_no) : '1',
                        'sal_month' => $month,
                        'sal_year' => $year,
                        'emp_code' => $emp->emp_code,
						'desig_id' => $emp->designation,
                        'catg_id' => $category,
                        'pay_head_id' => $payhead_id,
                        'pay_head_type' => 'E',
                        'amount' => $arrear_amount,
                        'created_by' => $this->session->userdata['loggedin']['user_id'],
                        'created_dt' => date('Y-m-d H:i:s'),
                        'created_ip' => $_SERVER["REMOTE_ADDR"]
                    ];
                    $this->db->insert('td_pay_slip', $insertData);
             
                    
                }

                $this->db->trans_complete(); // Complete transaction

                // Check if transaction succeeded
                if ($this->db->trans_status() === FALSE) {
                    // Transaction failed: rollback happened
                    $this->session->set_flashdata('error', 'Failed to update employee payhead amounts.');
                    redirect('/salary/calculate_arrears'); // redirect or handle error
                } else {
                    // Transaction succeeded: all updates applied
                     // Enclose post-salary processing in try-catch
                    try {
                        $data_array = array(
                            'bank_id'      => $bank_id,
                            'from_date'    => $from_date,
                            'to_date'      => $to_date,
                            'process_dttime'=> date('Y-m-d H:i:s'),
                            'years'        => $year,
                            'month_id'     => $month,
                            'payhead_id'   => $payhead_id,
                            'perc'         => $percentage,
                            'created_by'   => $this->session->userdata['loggedin']['user_id'],
                            'created_ip'   => $_SERVER["REMOTE_ADDR"]
                        );

                        // Insert process record
                        $this->Salary_Process->f_insert('td_payhead_process', $data_array);

                        // Update percentage in master payhead
                        $this->Salary_Process->f_edit(
                            'md_pay_head',
                            array('percentage' => $percentage),
                            array('bank_id' => $bank_id, 'sl_no' => $payhead_id)
                        );
                        $this->session->set_flashdata('success', 'Payhead process updated successfully.');
                      redirect('/salary/calculate_arrears');
                    } catch (Exception $e) {
                        // Handle exception
                        log_message('error', 'Payhead process error: ' . $e->getMessage());
                        $this->session->set_flashdata('error', 'Error occurred while updating payhead process.');
                        redirect('/salary/calculate_arrears'); // or any other page
                    }
                }
            }
        }else{
            $where  = array('bank_id' => $this->session->userdata['loggedin']['bank_id'],'input_flag'=>'AD','pay_flag'=>'E' );
            $data['payhead_dtls'] = $this->Admin_Process->f_get_particulars("md_pay_head",NULL,$where,0);
            $data['month_list'] = $this->Admin_Process->f_get_particulars("md_month",NULL,NULL,0);
            $data['category'] = $this->Admin_Process->f_get_particulars("md_category",NULL,NULL,0);
            $this->load->view('post_login/payroll_main');
            $this->load->view("payhead/calculate_arrears",$data);
            $this->load->view('post_login/footer');
        }
    }
    public function arrear_list()
    {
            $where  = array('a.sl_no= b.pay_head_id'=>NULL,'b.emp_code =c.emp_code'=>NULL,'a.bank_id' => $this->session->userdata['loggedin']['bank_id'],'b.bank_id' => $this->session->userdata['loggedin']['bank_id'],'c.bank_id' => $this->session->userdata['loggedin']['bank_id'],'a.input_flag'=>'AD' );
            $data['arrear_dtl'] = $this->Admin_Process->f_get_particulars("md_pay_head a,td_pay_slip b,md_employee c",array("b.*","c.emp_name"),$where,0);
            $this->load->view('post_login/payroll_main');
            $this->load->view("payhead/arrear_list",$data);
            $this->load->view('post_login/footer');
    }
    public function arrear_delete()
    {
            $where  = array('bank_id' => $this->session->userdata['loggedin']['bank_id'],'id' => $this->input->get('id'));
            $data['arrear_dtl'] = $this->Admin_Process->f_delete("td_pay_slip",$where);
            $this->load->view('post_login/payroll_main');
            $this->load->view("payhead/arrear_list",$data);
            $this->load->view('post_login/footer');
    }
}