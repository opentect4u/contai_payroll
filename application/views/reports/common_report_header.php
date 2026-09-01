<?php 
$bank_id = $this->session->userdata('loggedin')['bank_id'];
$sql = "select address from md_bank where sl_no = $bank_id";
$result = $this->db->query($sql)->row();
echo $result->address;
?>