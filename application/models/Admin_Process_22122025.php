<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Process extends CI_Model
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

	public function f_edit($table_name, $data_array, $where)
	{

		$this->db->where($where);
		if ($this->db->update($table_name, $data_array)) {
			return true;
		} else {
			return false;
		}
	}

	//For inserting row
	public function f_insert($table_name, $data_array)
	{

		if ($this->db->insert($table_name, $data_array)) {
			return true;
		} else {
			return false;
		}
	}

	//For Deliting row
	public function f_delete($table_name, $where)
	{

		$this->db->delete($table_name, $where);

		return;
	}

	public function f_count_emp($emp_code)
	{

		$result = $this->db->query("select count(*)count_emp from md_employee where emp_code = $emp_code");

		//$result	=	$this->db->query($sql);

		return $result->row();
	}

	public function match_name($name)
	{
		$bank_id  =  $this->session->userdata['loggedin']['bank_id'];
		$result = NULL;
		$result = $this->db->query("select ifnull(count(*),0) cnt from md_designation where designation='$name' AND bank_id = '$bank_id'");
		$result = $result->row();
		return $result->cnt;
	}
	public function checkOldPassword($oldpassword){
			$user_id=$this->session->userdata['loggedin']['user_id'];
			
			$data=$this->db->where('user_id',$user_id)->get('md_users');
			
			if ($data->num_rows() > 0) {
				$row = $data->row();
				if(password_verify($oldpassword, $row->password)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
	}

	function phearning_apply($id){
		$where = array(
			'id' => $id
		);
		$phearning = $this->f_get_particulars('md_payhead_earning', NULL, $where, 0);
		$phearning = $phearning[0];
		$sql = 'UPDATE td_earning_deduction a, md_employee b SET a.amount = ' . $phearning->amount . ' WHERE a.emp_no=b.emp_code AND a.pay_head_id = ' . $phearning->payhead_id . ' AND b.designation = ' . $phearning->designation_id . ' AND b.emp_status = "A"';
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	function paytype_detail($emp_cd, $epay_cd) {
		$sql = 'SELECT a.*, ifnull(b.amount, 0) amount FROM md_pay_head a LEFT JOIN md_payhead_earning b ON a.sl_no = b.payhead_id AND b.payhead_id = ' . $epay_cd . ' AND b.designation_id = (SELECT designation FROM md_employee WHERE emp_code = ' . $emp_cd . ') WHERE a.sl_no = ' . $epay_cd . ' AND a.bank_id = ' . $this->session->userdata['loggedin']['bank_id'];
		$query = $this->db->query($sql);
		return $query->result();
	}

	function increment($month, $year) {
		$sql = 'SELECT ifnull(i.id, 0) as id, e.emp_code, e.emp_name, d.designation, c.category, e.join_dt, if(i.basic_old > 0, i.basic_old, e.basic_pay) as old_basic, if(i.basic_new > 0, i.basic_new, e.basic_pay) as new_basic, ifnull(i.isapplied, 0) as isapplied  
				FROM md_employee e JOIN md_designation d ON e.designation = d.sl_no JOIN md_category c ON e.emp_catg = c.id 
				LEFT JOIN md_increment_hd i ON e.emp_code = i.emp_code AND i.month = ' . $month . ' AND i.year = ' . $year . '
				WHERE e.emp_status = "A" AND e.join_dt like "%-' . $month . '-%" AND e.bank_id = ' . $this->session->userdata['loggedin']['bank_id'] . ' ORDER BY c.category, d.designation, e.emp_name';
		$query = $this->db->query($sql);
		return $query->result();
	}

	function increment_update ($data) {
		$this->db->trans_start();
		$id = $data['id'];
		$basic = $data['basic'] + $data['increment'];
		$input = array (
			'emp_code' => $data['code'],
			'basic_old' => $data['basic'],
			'basic_new' => $basic,
			'month' => $data['month'],
			'year' => $data['year'],
			'isactive' => 1
		);
		if ($id > 0) {
			$this->Admin_Process->f_edit('md_increment_hd', $input, array('id' => $id));
		} else {
			$where = array (
				'emp_code' => $data['code'],
				'month' => $data['month'],
				'year' => $data['year']
			);
			$result = $this->f_get_particulars('md_increment_hd', NULL, $where, 0);			
			if (count($result) > 0) {
				$id = $result[0]->id;
				$this->Admin_Process->f_edit('md_increment_hd', $input, array('id' => $id));
			} else {
				$input['created'] = date('Y-m-d');
				$this->Admin_Process->f_insert('md_increment_hd', $input);
				$id = $this->db->insert_id();
			}
		}
		if($id > 0) {
			$sql = 'SELECT ph.sl_no, ph.percentage, ed.amount FROM td_earning_deduction ed JOIN md_pay_head ph ON ed.pay_head_id = ph.sl_no WHERE emp_no = ' . $data['code'] . ' AND ph.input_flag = "A" ORDER BY ph.sl_no';
			$result = $this->db->query($sql);
			if($result->num_rows() > 0) {
				$da = 0;
				foreach ($result->result() as $row) {
					$where = array (
						'increment_id' => $id,
						'payhead_id' => $row->sl_no
					);
					$result = $this->f_get_particulars('md_increment_dt', NULL, $where, 0);
					$amount = round(($basic * $row->percentage) / 100, 0);
					if($row->sl_no == 457) {
						$da = $amount;
					}
					if($row->sl_no == 463) {
						$amount = round((($basic + $da) * $row->percentage) / 100, 0);
					}
					if (count($result) > 0) {
						$input = array (
							'percentage' => $row->percentage,
							'amt_new' => $amount,
							'isactive' => 1
						);
						$this->Admin_Process->f_edit('md_increment_dt', $input, array('id' => $result[0]->id));
					} else {
						$input = array (
							'created' => date('Y-m-d'),
							'increment_id' => $id,
							'payhead_id' => $row->sl_no,
							'percentage' => $row->percentage,
							'amt_old' => $row->amount,
							'amt_new' => $amount,
							'isactive' => 1
						);
						$this->Admin_Process->f_insert('md_increment_dt', $input);
					}
				}
			}
		}
		$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
	}

	function increment_apply($id) {
		$this->db->trans_start();
		$where = array(
			'id' => $id
		);
		$result = $this->f_get_particulars('md_increment_hd', NULL, $where, 0);
		if (count($result) > 0) {
			$incr = $result[0];
			$this->Admin_Process->f_edit('md_employee', array('basic_pay' => $incr->basic_new), array('emp_code' => $incr->emp_code));
			$result = $this->f_get_particulars('md_increment_dt', NULL, array('increment_id' => $id), 0);
			if(count($result) > 0) {
				foreach ($result as $row) {
					$this->Admin_Process->f_edit('td_earning_deduction', array('amount' => $row->amt_new), array('emp_no' => $incr->emp_code, 'pay_head_id' => $row->payhead_id));
				}
			}
			$this->Admin_Process->f_edit('md_increment_hd', array('isapplied' => 1), array('id' => $id));
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function get_deduction_header()
	{
		$sql = 'SELECT sl_no, pay_head FROM md_pay_head WHERE input_flag = "M" AND pay_flag = "D" AND bank_id = ' . $this->session->userdata['loggedin']['bank_id'] . ' ORDER BY sl_no';
		$query = $this->db->query($sql);
		return $query->result();
	}

	function other_deduction()
	{
		$sql = 'SELECT ed.emp_no as id, e.emp_code, e.emp_name, d.designation, 
				group_concat(ed.pay_head_id order by ph.seq) as pay_head_id, 
				group_concat(ed.amount order by ph.seq) as amount 
				FROM td_earning_deduction ed 
				JOIN md_employee e ON ed.emp_no = e.emp_code JOIN md_designation d ON e.designation = d.sl_no
				JOIN md_pay_head ph ON ed.pay_head_id = ph.sl_no 
				WHERE e.emp_status="A" AND ph.input_flag = "M" AND ph.pay_flag = "D" AND ed.amount > 0 AND e.bank_id = ' . $this->session->userdata['loggedin']['bank_id'] . ' 
				GROUP BY ed.emp_no, e.emp_code, e.emp_name, d.designation ORDER BY e.emp_name';
		$query = $this->db->query($sql); 
		return $query->result();
	}

	function other_deduction_update($data) {
		$this->db->trans_start();
		$emp_code = $data['code'];
		foreach ($data['payhead_data'] as $key => $value) {
			$where = array (
				'emp_no' => $emp_code,
				'pay_head_id' => $key
			);
			$result = $this->f_get_particulars('td_earning_deduction', NULL, $where, 0);
			if (count($result) > 0) {
				$input = array (
					'amount' => $value
				);
				$this->Admin_Process->f_edit('td_earning_deduction', $input, $where);
			} 
			$result = $this->f_get_particulars('td_other_deduction', NULL, $where, 0);
			if (count($result) > 0) {
				$input = array (
					'amount' => $value
				);
				$this->Admin_Process->f_edit('td_other_deduction', $input, $where);
			} else {
				$input = array (
					'emp_no' => $emp_code,
					'pay_head_id' => $key,
					'amount' => $value,
					'created' => date('Y-m-d')
				);
				$this->Admin_Process->f_insert('td_other_deduction', $input);
			}
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function transfer() {
		$sql = 'SELECT e.emp_code, e.emp_name, d.designation, b.branch_name, e.join_dt  
		FROM md_employee e JOIN md_designation d ON e.designation = d.sl_no JOIN md_branch b ON e.branch_id = b.id 
		WHERE e.emp_status = "A" AND e.bank_id = ' . $this->session->userdata['loggedin']['bank_id'] . ' ORDER BY b.branch_name, e.emp_name';
		$query = $this->db->query($sql);
		return $query->result();
	}

	function transfer_update($data) { 
		$this->db->trans_start();
		$leaving_date = date('Y-m-d', strtotime($data['trf_date'] . ' - 1 day'));
		$result = $this->f_get_particulars('md_employee', NULL, array('emp_code' => $data['code']), 0);
		$row = $result[0];
		$input = array (
			'created' => date('Y-m-d'),
			'emp_code' => $row->emp_code,
			'branch_id' => $row->branch_id,
			'joining_date' => $row->join_dt,
			'leaving_date' => $leaving_date
		);
		$this->Admin_Process->f_insert('td_transfer', $input);
		$input = array (
			'branch_id' => $data['branch_id'],
			'join_dt' => $data['trf_date']
		);
		$this->Admin_Process->f_edit('md_employee', $input, array('emp_code' => $data['code']));
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function process($file) {
        $arr = array();
        $cnt = 0;
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
            switch ($row) {
                case 1:
                    break;
                case 2:
                    $header[$row][$column] = $data_value;
                    break;
                default:
                    $arr[$row][$column] = $data_value;
                    break;
            }
        }
        $header = $header[2];
        foreach ($arr as $row) {
            $input = array();
			$emp_code = 0;
			$payhead_id = 0;
			$flag = false;
            foreach ($row as $k => $v) {
				if ($header[$k] == 'Code') {
					$emp_code = $row[$k];
					continue;
				} else if ($header[$k] == 'Name' || $header[$k] == 'Designation' || $header[$k] == 'P.Tax') {
					continue;
				} else {
					$this->db->where(array(
						'pay_flag' => 'D',
						'pay_head' => $header[$k]
					));
					$query = $this->db->get('md_pay_head');
					if($query->num_rows() > 0) {
						$payhead_id = $query->row()->sl_no;
					}
					if($emp_code > 0 && $payhead_id > 0) {
						$input = array (
							'amount' => $row[$k]
						);
						$this->db->where(array(
							'emp_no' => $emp_code,
							'pay_head_id' => $payhead_id,
							'pay_head_type' => 'D'
						))->update('td_earning_deduction', $input);
						$flag = true;
					}
				}
                //$input[$header[$k]] = $row[$k];
            }
			$flag ? $cnt++ : '';
        }
        return $cnt;
    }

	function update_da($percentage) {
		$sql = 'SELECT emp_code, basic_pay FROM md_employee WHERE emp_status = "A" AND bank_id = ' . $this->session->userdata['loggedin']['bank_id'];
		$query = $this->db->query($sql);
		$result = $query->result();
		foreach ($result as $row) {
			$da = round($row->basic_pay * $percentage / 100); 
			$input = array (
				'amount' => $da
			);
			$this->db->where(array(
				'emp_no' => $row->emp_code,
				'pay_head_id' => PAYHEAD_DA,
				'pay_head_type' => 'E'
			))->update('td_earning_deduction', $input);
			$pf = round(($row->basic_pay + $da) * 12 / 100);
			$input = array (
				'amount' => $pf
			);
			$this->db->where(array(
				'emp_no' => $row->emp_code,
				'pay_head_id' => PAYHEAD_PF,
				'pay_head_type' => 'D'
			))->update('td_earning_deduction', $input);
		}
	}
}
