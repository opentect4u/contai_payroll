<?php

class Reports extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!isset($this->session->userdata['loggedin']['user_id'])){
            redirect(base_url());
        }
        $this->load->model('Login_Process');
        $this->load->model('Report_Process');
        $this->load->model('Admin_Process');
        $this->load->helper('paddyrate_helper');
        $this->load->model('Salary_Process');
    }

    //Category wise 

    public function salarycatgreport()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //Employee Ids for Salary List
            $select     =   array("emp_code");
            $where      =   array(
                "emp_catg"  =>  $this->input->post('category')
            );

            $emp_id     =   $this->Report_Process->f_get_particulars("md_employee", $select, $where, 0);
            //Temp variable for emp_list
            $eid_list   =   [];
            for ($i = 0; $i < count($emp_id); $i++) {
                array_push($eid_list, $emp_id[$i]->emp_code);
            }

            //List of Salary Category wise
            unset($where);
            $where = array(
                "m.emp_code = t.emp_no" =>  NULL,
                "t.sal_month"     =>  $this->input->post('sal_month'),
                "t.sal_year"      =>  $this->input->post('year')
            );

            $salary['list']               =   $this->Report_Process->f_get_particulars_in("md_employee m,td_pay_slip t", $eid_list, $where);

            // $salary['attendance_dtls']    =   $this->Report_Process->f_get_attendance();

            //Employee Group Count
            unset($select);
            unset($where);

            $select =   array(
                "m.emp_code",  "COUNT(m.emp_code) count", "m.emp_name"
            );

            $where  =   array(
                "t.sal_month"     =>  $this->input->post('sal_month'),
                "t.sal_year = '" . $this->input->post('year') . "' GROUP BY m.emp_code,m.emp_name"      =>  NULL
            );

            $salary['count']              =   $this->Report_Process->f_get_particulars("md_employee m,td_pay_slip t", $select, $where, 0);
            // f_get_particulars("md_employee m, td_pay_slip t", $select, $where, 0);
            // echo $this->db->last_query();
            // die();

            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/salary", $salary);
            $this->load->view('post_login/footer');
        } else {

            //Month List
            $salary['month_list'] =   $this->Report_Process->f_get_particulars("md_month", NULL, NULL, 0);
            //For Current Date
            $salary['sys_date']   =   $_SESSION['sys_date'];
            //Category List
            $salary['category']   =   $this->Report_Process->f_get_particulars("md_category", NULL, null, 0);

            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/salary", $salary);
            $this->load->view('post_login/footer');
        }
    }

    //For Salary Statement

    public function paystatementreport()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          
            $month = $this->input->post('sal_month');
            $year = $this->input->post('year');
            $catg_id = $this->input->post('category');
            $bank_id = $this->session->userdata('loggedin')['bank_id'];

            $statement['sal_list']   =   $this->Report_Process->sal_emp_amt($month,$year,$catg_id,$bank_id);
            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/statement", $statement);
            $this->load->view('post_login/footer');
        } else {

            //Month List
            $statement['month_list'] =   $this->Report_Process->f_get_particulars("md_month", NULL, NULL, 0);
            //Category List
            $statement['category']   =   $this->Report_Process->f_get_particulars("md_category", NULL, null, 0);
            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/statement", $statement);
            $this->load->view('post_login/footer');
        }
    }
    //Total Deduction Report

    public function totaldeduction()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $totaldeduction['total_deduct'] =   $this->Report_Process->f_get_totaldeduction($this->input->post('from_date'), $this->input->post('to_date'));
            //Current Year
            $totaldeduction['year']  =   $this->Report_Process->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/totaldeduction", $totaldeduction);
            $this->load->view('post_login/footer');
        } else {
            //Month List
            $totaldeduction['month_list'] =   $this->Report_Process->f_get_particulars("md_month", NULL, NULL, 0);
            //For Current Date
            $totaldeduction['sys_date']   =   $_SESSION['sys_date'];

            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/totaldeduction", $totaldeduction);
            $this->load->view('post_login/footer');
        }
    }

    public function totalearning()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $totalearning['total_ear'] =   $this->Report_Process->f_get_totalearning($this->input->post('from_date'), $this->input->post('to_date'));
            //Current Year
            $totalearning['year']  =   $this->Report_Process->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/totalearning", $totalearning);
            $this->load->view('post_login/footer');
        } else {
            //Month List
            $totalearning['month_list'] =   $this->Report_Process->f_get_particulars("md_month", NULL, NULL, 0);
            //For Current Date
            $totalearning['sys_date']   =   $_SESSION['sys_date'];

            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/totalearning", $totalearning);
            $this->load->view('post_login/footer');
        }
    }

    public function payslipreport()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            //Payslip
            $empno     =  $this->input->post('emp_cd');
            $sal_month  = $this->input->post('sal_month');
            $sal_yr     = $this->input->post('year');
			$emp_whr = array(
                'a.emp_code' =>  $this->input->post('emp_cd'),
                'a.designation = b.sl_no' => null,
                'a.branch_id = c.id' => null,
                'a.bank_id' =>  $this->session->userdata['loggedin']['bank_id']
            );
            $emp_select = 'a.*, c.branch_name, b.designation';

            $payslip['emp_dtls']    =   $this->Report_Process->f_get_particulars("md_employee a, md_designation b, md_branch c", $emp_select, $emp_whr, 1);
            $payslip['payslip_dtls'] = $this->Report_Process->get_payslip_dtls($empno,$sal_month,$sal_yr);
            
            $payslip['tds'] = $this->Report_Process->get_tds($empno, $sal_month, $sal_yr);
            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/payslip", $payslip);
            $this->load->view('post_login/footer');
        } else {

            //Month List
            $payslip['month_list'] =   $this->Report_Process->f_get_particulars("md_month", NULL, NULL, 0);
            //For Current Date
            $payslip['sys_date']   =   $_SESSION['sys_date'];

            //Employee List
            unset($select);
            $select = array("emp_code", "emp_name");
            $payslip['emp_list']   =   $this->Report_Process->f_get_particulars("md_employee", $select, array("emp_catg IN (1,2,3,5)" => NULL,"bank_id"=>$this->session->userdata['loggedin']['bank_id'],'1 order by emp_name ASC'=>NULL), 0);
            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/payslip", $payslip);
            $this->load->view('post_login/footer');
        }
    }
    public function empeardedu()
    {
       
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          
            $month = $this->input->post('sal_month');
            $year = $this->input->post('year');
            $catg_id = $this->input->post('category');
            $bank_id = $this->session->userdata('loggedin')['bank_id'];
           

            $statement['emp_list']   = $this->Report_Process->get_emp_list($catg_id,$month,$year,$bank_id);
            $statement['bank_id'] = $bank_id;
          //  $statement['saldetail']  = $this->Report_Process->get_emp_saldetail($catg_id,$month,$year,$bank_id);
            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/empeardedu", $statement);
            $this->load->view('post_login/footer');
        } else {

            //Month List
            $statement['month_list'] =   $this->Report_Process->f_get_particulars("md_month", NULL, NULL, 0);
            //Category List
            $statement['category']   =   $this->Report_Process->f_get_particulars("md_category", NULL, null, 0);
            $statement['bank_id'] = $this->session->userdata('loggedin')['bank_id'];
            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/empeardedu", $statement);
            $this->load->view('post_login/footer');
        }
    }
    public function empeardedudd()
    {
       
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {          
            $month = $this->input->post('sal_month');
            $year = $this->input->post('year');
            $catg_id = $this->input->post('category');
            $branch_id = $this->input->post('branch_id');
            $bank_id = $this->session->userdata('loggedin')['bank_id'];
            $data['payhead'] = $this->Report_Process->get_payhead($bank_id, $branch_id, $catg_id, $month, $year);
            $data['list'] = $this->Report_Process->get_salary_statement($bank_id, $branch_id, $catg_id, $month, $year);
            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/empeardedudd", $data);
            $this->load->view('post_login/footer');

        //     $statement['branchname'] = '';
        //     $statement['emp_list']   = $this->Report_Process->get_emp_list($branch_id,$catg_id,$month,$year,$bank_id);
        //     $statement['sal_month'] = $this->input->post('sal_month');
        //     $statement['year'] = $this->input->post('year');
        //     $statement['bank_id'] = $this->session->userdata('loggedin')['bank_id'];
        //     if($branch_id > 0 ){
        //         $statem =   $this->Report_Process->f_get_particulars("md_branch", NULL, array('id'=>$branch_id), 1);
        //         $statement['barnch_name'] = $statem->branch_name;
        //     }else{
        //         $statement['barnch_name'] = 'ALL';
        //     }
        //   //  $statement['saldetail']  = $this->Report_Process->get_emp_saldetail($catg_id,$month,$year,$bank_id);
        //     $this->load->view('post_login/payroll_main');
        //     $this->load->view("reports/empeardedudd", $statement);
        //     $this->load->view('post_login/footer');
        } else {
            //Month List
            $statement['month_list'] =   $this->Report_Process->f_get_particulars("md_month", NULL, NULL, 0);
            $where = array('bank_id'=>$this->session->userdata('loggedin')['bank_id']);
            $statement['branchlist']   =   $this->Report_Process->f_get_particulars("md_branch", NULL,$where, 0);
            $statement['category']   =   $this->Report_Process->f_get_particulars("md_category", NULL, null, 0);
            $this->load->view('post_login/payroll_main');
            $this->load->view("reports/empeardedudd", $statement);
            $this->load->view('post_login/footer');
        }
    }

    public function pf_deduction()
    {
        $list = array();
        $selected = array(
            'branch_id' => '',
            'year' => date('Y'),
            'month' => date('m')-1,
            'category_id' => ''
        );
        if($this->input->post()){
            $selected = array(
                'branch_id' => $this->input->post('branch_id'),
                'year' => $this->input->post('year'),
                'month' => $this->input->post('month'),
                'category_id' => $this->input->post('category_id')
            );
            $list = $this->Report_Process->pf_deduction($selected);
        }
        $data['branch'] = $this->Report_Process->f_get_particulars('md_branch', NULL, array('bank_id'=>$this->session->userdata('loggedin')['bank_id']), 0);
        $data['month'] = $this->Report_Process->f_get_particulars('md_month');        
        $data['category'] = $this->Report_Process->f_get_particulars('md_category');
        $data['selected'] = $selected;
        $data['list'] = $list;
        $this->load->view('post_login/payroll_main');
        $this->load->view("reports/pf_deduction", $data);
        $this->load->view('post_login/footer');
    }

    public function tds_deduction()
    {
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');
        $list = array();
        $month = date('m')-1;
        $year = date('Y');
        if($month < 4){
            $from_date = date(($year-1) . '-04-01');
            $to_date = date('Y-m-d'); //date($year . '-03-31');
        } else {
            $from_date = date($year . '-04-01');
            $to_date = date('Y-m-d'); //date(($year+1) . '-03-31');
        }
        $selected = array(
            'from_date' => $from_date,
            'to_date' => $to_date
        );
        if($this->input->post()){
            $selected = array(
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date')
            );
            $list = $this->Report_Process->tds_deduction($selected);
        }
        $data['selected'] = $selected;
        $data['list'] = $list;
        $this->load->view('post_login/payroll_main');
        $this->load->view("reports/tds_deduction", $data);
        $this->load->view('post_login/footer');
    }
    public function emp_loandtls()
    {
        $where = array(
            'a.emp_no = b.emp_code' => NULL,
            'c.sl_no = a.pay_head_id' => NULL,'LENGTH(a.account_no) > 2' => NULL,
            'b.emp_status' => 'A','1 order by b.emp_name' => NULL
        );
        $select = array('b.emp_name','c.pay_head','a.amount','a.account_no');
        $list = $this->Report_Process->f_get_particulars('td_earning_deduction a,md_employee b,md_pay_head c', $select, $where, 0);
        $data['list'] = $list;
        $this->load->view('post_login/payroll_main');
        $this->load->view('reports/emp_loandtls', $data);
        $this->load->view('post_login/footer');
    }
}