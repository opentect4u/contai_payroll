<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_Process extends CI_Model
{

	public function f_get_particulars($table_name, $select = NULL, $where = NULL, $flag=NULL)
	{

		if (isset($select)) {

			$this->db->select($select);
		}

		if (isset($where)) {

			$this->db->where($where);
		}

		$result		=	$this->db->get($table_name);

		if ($flag == 1) {

			return $result->row();
		} else {

			return $result->result();
		}
	}


	public function f_get_particulars_in($table_name, $where_in = NULL, $where = NULL)
	{

		if (isset($where)) {

			$this->db->where($where);
		}

		if (isset($where_in)) {

			$this->db->where_in('emp_no', $where_in);
		}

		$result	=	$this->db->get($table_name);

		return $result->result();
	}
	public function f_edit($table_name, $data_array, $where)
	{

		$this->db->where($where);
		$this->db->update($table_name, $data_array);

		return;
	}

	//For inserting row
	public function f_insert($table_name, $data_array)
	{

		$this->db->insert($table_name, $data_array);

		return;
	}

	//For Deliting row
	public function f_delete($table_name, $where)
	{

		$this->db->delete($table_name, $where);

		return;
	}

	public function f_get_totaldeduction($from_date, $to_date)
	{
		$this->db->select('a.emp_code, SUM(a.it) it, SUM(a.cpf)cpf, SUM(a.gpf)gpf, 
		SUM(a.gigs)gigs, SUM(a.lpf)lpf, 
		SUM(a.fa)fa, SUM(a.gi)gi, 
		SUM(a.top)top, SUM(a.eccs)eccs, SUM(a.hblp)hblp, 
		SUM(a.hbli)hbli, SUM(a.s_adv)s_adv, SUM(a.tot_diduction)tot_diduction, b.emp_name');
		$this->db->where(array(
			'a.emp_code=b.emp_code' => null,
			'a.sal_month BETWEEN ' . date('m', strtotime($from_date)) . ' AND ' . date('m', strtotime($to_date)) => null
			// 'a.trans_date <=' => $from_date,
			// 'a.trans_date >=' => $to_date
		));
		$this->db->group_by('a.emp_code');
		$query = $this->db->get('td_pay_slip a, md_employee b');
		return $query->result();
	}

	public function f_get_totalearning($from_date, $to_date)
	{
		$bank_id = $this->session->userdata['loggedin']['bank_id'];
		$this->db->select('a.emp_code,b.emp_name,SUM(CASE WHEN a.pay_head_type = "E" THEN amount ELSE 0 END) AS tot_earn,SUM(CASE WHEN a.pay_head_type = "D" THEN amount ELSE 0 END) AS tot_dedu');
		$this->db->where(array(
			'a.emp_code=b.emp_code' => null,
			'a.bank_id'=>$bank_id,
			'b.bank_id'=>$bank_id,
			'a.sal_month BETWEEN ' . date('m', strtotime($from_date)) . ' AND ' . date('m', strtotime($to_date)) => null
		));
		$this->db->group_by('a.emp_code,b.emp_name');
		$query = $this->db->get('td_pay_slip a, md_employee b');
		//echo $this->db->last_query();exit;
		return $query->result();
	}

	public function f_get_emp_dtls($empno, $sal_month, $sal_yr)
	{

		$result = $this->db->query("select a.trans_date, a.trans_no, a.sal_month, a.sal_year, a.emp_code, 
			a.catg_id, a.basic, a.sp, a.da, a.hra, a.ma, a.sa, a.ta, a.arrear, a.ot, a.lwp, a.final_gross, 
			a.it, a.cpf, a.gpf, a.gigs, a.lpf, a.fa, 
			a.gi, a.top, a.eccs, a.hblp, a.hbli, 
			a.s_adv, a.tot_diduction, a.net_sal, a.remarks, b.emp_name,b.designation,b.phn_no,b.department,b.pan_no
			  from 
			  td_pay_slip a,md_employee b where a.emp_code=b.emp_code and a.emp_code = $empno
			  and a.sal_month=$sal_month and a.sal_year=$sal_yr ");

		//$result	=	$this->db->query($sql);

		return $result->row();
	}


	public function f_count_emp($emp_code)
	{

		$result = $this->db->query("select count(*)count_emp from md_employee where emp_code = $emp_code");

		//$result	=	$this->db->query($sql);

		return $result->row();
	}
	function sal_emp_amt($month, $year, $catg_id,$bank_id)
	{
		$this->db->select('a.emp_code,b.emp_name,b.bank_ac_no,SUM(CASE WHEN a.pay_head_type = "E" THEN amount ELSE 0 END) AS tot_earn,
		SUM(CASE WHEN a.pay_head_type = "D" THEN amount ELSE 0 END) AS tot_dedu');
		
		if ( $month && $year && $catg_id ) {
			
			$this->db->where(array(
				'a.emp_code = b.emp_code' => NULL,
				'a.bank_id' => $bank_id,
				'b.bank_id' => $bank_id,
				'a.sal_month' => $month,
				'a.sal_year' => $year,
				'a.catg_id' => $catg_id
			));
		}
		$this->db->group_by('a.emp_code,b.emp_name');
		$query = $this->db->get('td_pay_slip a,md_employee b');
		
		return $query->result();
	
	}

	function get_emp_list($branch_id,$emp_cat,$sal_month,$sal_year,$bank_id){
		$branchsql = '';
		if($branch_id > 0){
			$branchsql = "AND c.branch_id = $branch_id";
		}

		// $sql = "SELECT DISTINCT a.emp_code,c.emp_name,d.designation from td_pay_slip a,td_salary b,md_employee c,md_designation d
		// where a.catg_id = b.catg_cd
		// AND a.emp_code = c.emp_code
		// AND c.designation = d.sl_no
		// AND b.approval_status = 'A'
		// AND b.catg_cd = $emp_cat
		// AND a.bank_id = $bank_id
		// AND b.bank_id = $bank_id 
		// AND c.bank_id = $bank_id $branchsql
		// AND a.sal_month = $sal_month AND a.sal_year = $sal_year order by d.srl_no ASC";

		$sql = "SELECT DISTINCT a.emp_code,c.emp_name,d.designation from td_pay_slip a,td_salary b,md_employee c,md_designation d
		where a.catg_id = b.catg_cd
		AND a.emp_code = c.emp_code
		AND c.designation = d.sl_no
		AND b.catg_cd = $emp_cat
		AND a.bank_id = $bank_id
		AND b.bank_id = $bank_id 
		AND c.bank_id = $bank_id $branchsql
		AND a.sal_month = $sal_month AND a.sal_year = $sal_year order by d.srl_no ASC";

		$result	=	$this->db->query($sql);
		return $result->result();
	}
	function get_emp_saldetail($catg_id,$sal_month,$sal_year,$bank_id){

		$sql ="select a.amount,b.pay_head,a.emp_code,a.pay_head_type from td_pay_slip a,md_pay_head b 
				where a.pay_head_id = b.sl_no
				AND a.sal_month = $sal_month
				AND a.sal_year = $sal_year
				AND a.bank_id = $bank_id 
				AND b.bank_id = $bank_id
				AND a.catg_id = $catg_id
				" ;
	
		$result	=	$this->db->query($sql);
		return $result->result();
	}
	public function get_emp_salrydetail($emp_code,$sal_month,$sal_year,$bank_id){
		$sql ="select emp_code,emp_name,pay_head_id,pay_head,emp_desig,sum(e_amt)e_amt,sum(d_amt)d_amt
					from(
					SELECT a.emp_code,b.emp_name,a.pay_head_id,c.pay_head,a.amount e_amt,0 d_amt,b.designation,d.designation emp_desig
					FROM td_pay_slip a,md_employee b,md_pay_head c,md_designation d
					where a.emp_code = b.emp_code
					and   a.pay_head_id = c.sl_no
					and   b.designation = d.sl_no
					and   a.emp_code = $emp_code
					and   a.pay_head_type = 'E'
					and   a.sal_year = $sal_year
					and   a.sal_month = $sal_month
					and   a.bank_id = $bank_id
					UNION
					SELECT a.emp_code,b.emp_name,a.pay_head_id,c.pay_head,0 e_amt,a.amount d_amt,b.designation,d.designation emp_desig
					FROM td_pay_slip a,md_employee b,md_pay_head c,md_designation d
					where a.emp_code = b.emp_code
					and   a.pay_head_id = c.sl_no
					and   b.designation = d.sl_no
					and   a.emp_code = $emp_code 
					and   a.pay_head_type = 'D'
					and   a.sal_year = $sal_year
					and   a.sal_month = $sal_month
					and   a.bank_id = $bank_id)a
					group by emp_code,emp_name,pay_head_id,pay_head,emp_desig
					order by pay_head_id;";
	
		$result	=	$this->db->query($sql);
		return $result->result();
	}
	public function getempsalryd($empcd,$sal_month,$sal_year,$bank_id,$pay_code){

		$sql = "select IFNULL(amount, 0) AS amount from td_pay_slip where emp_code='$empcd' AND bank_id = $bank_id 
		        AND sal_month =$sal_month AND sal_year= $sal_year AND pay_head_id =$pay_code";

		$array	=	$this->db->query($sql)->row_array();
		if (isset($array) && is_array($array) && isset($array['amount'])) {
			return $array['amount'];
		} else {
			// Handle the case where $array is null or not set
			return 0 ; // or any other appropriate action
		}
	
	}

	function pf_deduction ($data) {
		$branch_id = $data['branch_id'];
		$year = $data['year'];
		$month = $data['month'];
		$category_id = $data['category_id'];
		$where = '';
		if ($branch_id > 0) {
			$where .= ' AND e.branch_id = ' . $branch_id;
		}
		if ($category_id != '') {
			$where .= ' AND e.emp_catg = ' . $category_id;
		}
		$sql = 'SELECT e.emp_code, e.emp_name, b.branch_name, e.uan, e.dob, e.basic_pay, sum(p.amount) as gross, 
				(p1.amount+p2.amount+ifnull(p3.amount,0)) as wages 
				FROM md_employee e 
				JOIN td_pay_slip p ON e.emp_code = p.emp_code JOIN md_branch b ON e.branch_id = b.id 
				LEFT JOIN td_pay_slip p1 ON p1.emp_code=p.emp_code AND p1.pay_head_id=0 AND p1.sal_month=p.sal_month AND p1.sal_year=p.sal_year 
				LEFT JOIN td_pay_slip p2 ON p2.emp_code=p.emp_code AND p2.pay_head_id=457 AND p2.sal_month=p.sal_month AND p2.sal_year=p.sal_year 
				LEFT JOIN td_pay_slip p3 ON p3.emp_code=p.emp_code AND p3.pay_head_id=459 AND p3.sal_month=p.sal_month AND p3.sal_year=p.sal_year
				WHERE e.bank_id=p.bank_id AND p.pay_head_type="E" AND b.bank_id=e.bank_id 
				'.$where.' AND p.sal_month = '.$month.' AND p.sal_year = '.$year.
				' AND p.bank_id = '.$this->session->userdata['loggedin']['bank_id'] . 
				' GROUP BY e.emp_code, e.emp_name, b.branch_name, e.uan, e.dob, e.basic_pay ORDER BY e.emp_name';
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	function tds_deduction ($data) {
		$from_month = date('m', strtotime($data['from_date']));
		$to_month = date('m', strtotime($data['to_date']));
		$from_year = date('Y', strtotime($data['from_date']));
		$to_year = date('Y', strtotime($data['to_date']));
		$where = '';
		if ($from_year == $to_year) {
			$where .= ' AND (p.sal_month >= ' . $from_month . ' AND p.sal_month <= ' . $to_month . ' AND p.sal_year = ' . $from_year . ')';
		} else {
			$where .= ' AND ((p.sal_month >= ' . $from_month . ' AND p.sal_year = ' . $from_year . ') OR (p.sal_month <= ' . $to_month . ' AND p.sal_year = ' . $to_year . '))';
		}
		$sql = 'SELECT e.emp_code, e.emp_name, b.branch_name, d.designation, e.pan_no, p.sal_month, p.sal_year, p.amount 
				FROM md_employee e JOIN td_pay_slip p ON e.emp_code = p.emp_code 
				JOIN md_branch b ON e.branch_id = b.id JOIN md_designation d ON e.designation = d.sl_no
				WHERE e.bank_id=p.bank_id AND p.pay_head_type="D" AND b.bank_id=e.bank_id 
				AND p.pay_head_id = 474 AND p.amount > 0 '.$where.
				' AND p.bank_id = '.$this->session->userdata['loggedin']['bank_id'] . ' ORDER BY b.branch_name, e.emp_name, p.sal_year, p.sal_month';
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_payslip_dtls($empno,$sal_month,$sal_yr) {
		$sql = 'SELECT b.*, if(b.pay_head_id > 0, c.pay_head, "Basic") as pay_head FROM td_salary a 
		JOIN td_pay_slip b ON a.trans_date = b.trans_dt AND a.trans_no = b.trans_no 
		LEFT JOIN md_pay_head c ON b.pay_head_id = c.sl_no 
		WHERE a.sal_month=b.sal_month AND a.sal_year=b.sal_year AND a.bank_id=b.bank_id AND a.catg_cd=b.catg_id 
		AND b.emp_code ='.$empno.' AND a.approval_status="A" 
		AND b.sal_month ='.$sal_month.' AND b.sal_year ='.$sal_yr.' AND a.bank_id ='.$this->session->userdata['loggedin']['bank_id'] . ' ORDER BY b.pay_head_type, c.seq';
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	function get_payhead($bank_id, $branch_id, $catg_id, $month, $year) {
		$where = $catg_id > 0 ? ' AND ps.catg_id='.$catg_id : '';
		$where .= $branch_id > 0 ? ' AND e.branch_id='.$branch_id : '';
		$sql = 'SELECT DISTINCT ps.pay_head_id, ph.code, ph.pay_head, ps.pay_head_type 
		FROM td_pay_slip ps JOIN md_pay_head ph ON ps.pay_head_id = ph.sl_no JOIN md_employee e ON ps.emp_code=e.emp_code
		WHERE ps.bank_id='.$bank_id.' AND ps.sal_month='.$month.' AND ps.sal_year='.$year.$where.' ORDER BY ph.pay_flag, ph.seq';
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); exit;
		return $query->result();
	}

	function get_salary_statement($bank_id, $branch_id, $catg_id, $month, $year) {
		$where = $catg_id > 0 ? ' AND ps.catg_id='.$catg_id : '';
		$where .= $branch_id > 0 ? ' AND e.branch_id='.$branch_id : '';
		$sql = 'SELECT DISTINCT e.emp_code, e.emp_name, b.branch_name, d.designation, 
		GROUP_CONCAT(ps.pay_head_id ORDER BY ps.pay_head_id) as payhead, 
		GROUP_CONCAT(ps.amount ORDER BY ps.pay_head_id) as amount 
		FROM td_pay_slip ps JOIN md_employee e ON ps.emp_code=e.emp_code JOIN md_branch b ON e.branch_id=b.id 
		JOIN md_designation d ON e.designation=d.sl_no 
		WHERE ps.bank_id='.$bank_id.' AND ps.sal_month='.$month.' AND ps.sal_year='.$year.$where.' 
		GROUP BY e.emp_code, e.emp_name, b.branch_name, d.designation ORDER BY b.branch_name, e.emp_name';
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_tds($emp_code, $month, $year) {
		$where = '';
		if($month > 3) {
			$where = ' AND (sal_month >= 4 and sal_month <='.$month.') AND sal_year ='.$year;
		} else {
			$where = ' AND ((sal_month >= 4 and sal_year ='.($year-1).') OR (sal_month <='.$month.' and sal_year ='.$year.'))';
		}
		$sql = 'SELECT sum(amount) as tds FROM td_pay_slip WHERE emp_code ='.$emp_code.' AND pay_head_id = '. PAYHEAD_TDS . $where;
		$query = $this->db->query($sql);
		return $query->row()->tds;
	}
}
