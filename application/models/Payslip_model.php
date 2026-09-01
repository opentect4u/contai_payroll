<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payslip_model extends CI_Model
{

    function shorten_url($long_url) {
        $long_url = str_replace("\/", "/", $long_url);
        //Validate URL format
        if (!filter_var($long_url, FILTER_VALIDATE_URL)) { 
            return false;
        }
        // API endpoint (plain text response)
        $api_url = "https://is.gd/create.php?format=simple&url=" . urlencode($long_url);
        // Use cURL for better error handling
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $short_url = curl_exec($ch);
        if (curl_errno($ch)) { 
            curl_close($ch);
            return false; // cURL error
        }
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // Check if API returned success
        if ($httpcode === 200) {
            return $short_url;
        }
        return false;
    }

    function send_sms($row) {        
        $input = array(
            'created' => date('Y-m-d'),
            'bank_id' => $row->bank_id,
            'emp_code' => $row->emp_code,
            'month' => $row->sal_month,
            'year' => $row->sal_year
        );
        $this->db->insert('td_sms', $input);
        $sms_id = $this->db->insert_id(); 
        $params = rand(1000, 9999) . $sms_id . rand(1000, 9999);
        $url = site_url('payslip/download/' . $params);
        $url = $this->shorten_url($url);
        $template_hd = str_replace('{#var1#}', $row->phn_no, SMS_TEMPLATE_HD);
        $template_text = str_replace('{#var2#}', $row->emp_name, SMS_TEMPLATE_TEXT);
        $period = date('F', mktime(0, 0, 0, $row->sal_month, 10)) . ', ' . $row->sal_year;
        $template_text = str_replace('{#var3#}', $period, $template_text);
        $template_text = str_replace('{#var4#}', str_replace('https://', '', $url), $template_text);
        
        //$template = 'http://sms.synergicapi.in/api.php?username=CONTAIARDB&apikey=GJLNb0RYDTGG&senderid=CCARDB&route=OTP&mobile=9051203118&text=Dear Nishanta Sahoo, Your salary for October, 2025 has been successfully processed. To view your paysheet, click the link https://is.gd/lu43KC - Contai CARD Bank Ltd.';
        //$template = 'http://sms.synergicapi.in/api.php?username=CONTAIARDB&apikey=GJLNb0RYDTGG&senderid=CCARDB&route=OTP&mobile=9831887194&text=Dear Tanmoy, Your salary for oct-2025 has been successfully processed. To view your paysheet, click the link abcd.com - Contai CARD Bank Ltd.';
        //$template = 'https://sms.synergicapi.in/api.php?username=CONTAIARDB&apikey=GJLNb0RYDTGG&senderid=CCARDB&route=OTP&mobile=9051203118&text='.urlencode("Dear Nishanta Sahoo, Your salary for October, 2025 has been successfully processed. To view your paysheet, click the link v.gd/AwdtJx - Contai CARD Bank Ltd.");
        //var_dump($template); 
        //var_dump($template_hd . urlencode($template_text));
        //exit;
        $curl = curl_init();
 
        curl_setopt_array($curl, array(
            CURLOPT_URL => $template_hd . urlencode($template_text),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        //echo $httpcode;
        if ($httpcode === 200) {
            $this->db->set('issms', 1);
            $this->db->where(array(
                'emp_code' => $row->emp_code,
                'sal_month' => $row->sal_month,
                'sal_year' => $row->sal_year
            ));
            $this->db->update('td_pay_slip');
        }        
    }

    function get_emp($emp_code) {
        $this->db->select('e.*, d.designation, b.branch_name');
		$this->db->where(array(
			'emp_code' => $emp_code
		));
		$this->db->join('md_designation d', 'e.designation = d.sl_no');
		$this->db->join('md_branch b', 'e.branch_id=b.id');
		$query = $this->db->get('md_employee e');
		return $query->row();
    }

    function get_sal($emp_code, $month, $year) {
        $sql = 'SELECT b.*, if(b.pay_head_id > 0, c.pay_head, "Basic") as pay_head FROM td_salary a 
		JOIN td_pay_slip b ON a.trans_date = b.trans_dt AND a.trans_no = b.trans_no 
		LEFT JOIN md_pay_head c ON b.pay_head_id = c.sl_no 
		WHERE a.sal_month=b.sal_month AND a.sal_year=b.sal_year AND a.bank_id=b.bank_id AND a.catg_cd=b.catg_id 
		AND b.emp_code ='.$emp_code.' AND a.approval_status="S" 
		AND b.sal_month ='.$month.' AND b.sal_year ='.$year.' ORDER BY b.pay_head_type, c.seq';
		$query = $this->db->query($sql); //echo $this->db->last_query(); exit;
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
