<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payslip extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->library('dompdf_lib');
        $this->load->model('payslip_model', 'model');
    }

	public function sms($bank_id, $trans_date)
	{ 
		$sql = 'SELECT DISTINCT e.emp_code, e.emp_name, e.phn_no, ps.bank_id, ps.sal_month, ps.sal_year 
		FROM td_salary s 
		JOIN td_pay_slip ps ON s.trans_date = ps.trans_dt AND s.trans_no = ps.trans_no AND s.bank_id=ps.bank_id 
		JOIN md_employee e ON ps.emp_code = e.emp_code
		WHERE ps.sal_month=s.sal_month AND ps.sal_year=s.sal_year AND s.approval_status = "A" 
		AND ps.issms = 0 AND ps.bank_id = '.$bank_id.' AND s.trans_date = "'.$trans_date.'"';
		$query = $this->db->query($sql); 
		if($query->num_rows() > 0) {
			$result = $query->result();
			foreach($result as $row) {
				//if($row->emp_code != 1108) continue;
				$this->model->send_sms($row);
			}
			$input = array('approval_status' => 'S');
			$this->db->where(array(
				'bank_id' => $bank_id,
				'trans_date' => $trans_date
			))->update('td_salary', $input);
		}
		redirect(site_url('payapprv'));
	}
	public function download($token = null)
	{
		$id = substr(substr($token, 4), 0, -4);
		//var_dump($id); exit;
		$this->db->where('id', $id);
		$query = $this->db->get('td_sms');
		$row = $query->row();	
		$this->db->where('sl_no', $row->bank_id);
		$query = $this->db->get('md_bank');
		$bank = $query->row();
		$this->db->query('UPDATE td_sms SET isread=isread+1 WHERE id=' . $id);
		$data['month'] = $row->month;
		$data['year'] = $row->year;	
		$data['bank'] = $bank;
		$data['emp'] = $this->model->get_emp($row->emp_code);
		$data['sal'] = $this->model->get_sal($row->emp_code, $row->month, $row->year);
		$data['tds'] = $this->model->get_tds($row->emp_code, $row->month, $row->year);
		//echo '<pre>';
		//print_r($data); exit;
		$dompdf = $this->dompdf_lib->load();
		//$this->load->view('payslip/view', $data);
		$html = $this->load->view('payslip/view', $data, TRUE);
        $dompdf->loadHtml($html);
        $dompdf->render();
		header("Content-Type: application/pdf");
		header("Content-Disposition: attachment; filename=" . $row->emp_code . $row->month . $row->year . ".pdf");
		echo $dompdf->output();
		exit;
	}

	function insert($payhead_id = null) {
		$sql = 'SELECT DISTINCT emp_code FROM md_employee ORDER BY emp_code';
		$query = $this->db->query($sql); 
		if($query->num_rows() > 0) {
			$result = $query->result();
			foreach($result as $row) {
				$sql = 'SELECT * FROM td_earning_deduction WHERE emp_no = ' . $row->emp_code . ' AND pay_head_id=' . $payhead_id;
				$query = $this->db->query($sql); 
				if($query->num_rows() == 0) {
					$input = array(
						'bank_id' => 6,
						'effective_dt' => date('Y-m-d'),
						'emp_no' => $row->emp_code,
						'pay_head_id' => $payhead_id,
						'pay_head_type' => 'D',
						'amount' => 0,
						'created_by' => 'contaiardb',
						'created_dt' => date('Y-m-d H:i:s'),
						'created_ip' => '115.187.54.184'
					);
					$this->db->insert('td_earning_deduction', $input);
				}
			}
		}
	}

	function update_ptax() {
		$sql = 'SELECT emp_code, sum(amount) as gross FROM td_pay_slip WHERE pay_head_type="E" AND sal_month=10 AND sal_year=2025 GROUP BY emp_code';
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$result = $query->result();
			foreach($result as $row) {
				$this->db->select('tax_amt');
				$this->db->where(array(
					'from_amt <=' => $row->gross,
					'to_amt >=' => $row->gross,
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
					'emp_code' => $row->emp_code,
					'sal_month' => 10,
					'sal_year' => 2025,
					'pay_head_id' => PAYHEAD_PTAX
				))->update('td_pay_slip', $input);
			}
			echo 'done';
		}
	}
}
