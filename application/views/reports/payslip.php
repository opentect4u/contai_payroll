<?php 
//echo '<pre>';
//print_r(sizeof($payslip_dtls));
?>
<script>
    function printDiv() {

        var divToPrint = document.getElementById('divToPrint');
        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title><style type="text/css">');
        WindowObject.document.writeln('@media print { .center { text-align: center;} .underline { text-decoration: underline; } p { display:inline; } .left { margin-left: 315px; text-align="left" display: inline; } .right { margin-right: 375px; display: inline; } td.left_algn { text-align: left; } td.right_algn { text-align: right; } .t2 td, th { border: 1px solid black; } td.hight { hight: 15px; } table.width { width: 100%; } table.noborder { border: 0px solid black; } th.noborder { border: 0px solid black; } .border { border: 1px solid black; } .bottom { position: absolute; bottom: 5px; width: 100%;} .payslip_logo_Desc_Uts h3{font-size: 18px; margin: 0 0 6px 0; font-family: "Roboto", sans-serif;} .payslip_logo_Desc_Uts h4{font-size: 14px; margin: 0 0 5px 0; font-family: "Roboto", sans-serif;}  table.table_1_Uts{font-family: "Roboto", sans-serif; font-size: 14px;}  table.table_1_Uts{font-family: "Roboto", sans-serif; font-size: 14px;} .payslip_logo_Uts{float:left; max-width: 16.66667%; padding-right:15px;} .payslip_logo_Desc_Uts{float:left; max-width: 83.33333%;} table.payslipTable_Uts tbody tr td {font-size: 13px; padding:5px 15px;} .table_1_Uts{width:100%;} .table_1_Uts td td{padding:2px 15px;} .table_2_Uts td td{padding:2px 15px;} .table_1_Uts{font-family: "Roboto", sans-serif; font-size: 13px;} .table_2_Uts{font-family: "Roboto", sans-serif; font-size: 13px;} .dtls_table{margin-top:10px} } </style>');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function() {
            WindowObject.close();
        }, 10);

    }
</script>
<style>
td.left_algn { text-align: left; } td.right_algn { text-align: right; padding-right: 15px;}



</style>


<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($payslip_dtls)) {
?>
<style>
@media print {
    .row {
        display: block;
    }
    
    .col-6 {
        width: 50%;
        max-width: 50%;
        display: block;
        margin-bottom: 20px; /* Adds space between tables */
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #000; /* Add border for clarity */
        padding: 5px;
        
    }
    
    .t2 {
        font-weight: bold;
        background-color: #f0f0f0; /* Light background for table headers */
    }
}
th, td {
        /* border: 1px solid #000;  */
        padding: 5px;
        
    }
</style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body" id='divToPrint'>
                    <div class="row">
                        <div class="col-2 payslip_logo_Uts"><a href="javascript:void()"><img src="<?= base_url() ?>assets/images/<?php 
if (isset($this->session->userdata['loggedin']['logo_path'])) {
    echo $this->session->userdata['loggedin']['logo_path']; 
}
?>" alt="logo" height="100" width="100" /></a></div>
                        <div class="col-8 payslip_logo_Desc_Uts">
                            <?php include_once('common_report_header.php'); ?>
                            <h4>Pay Slip for <?php echo MONTHS[$this->input->post('sal_month')] . '-' . $this->input->post('year'); ?></h4>
                            <h4><?php //echo $emp_dtls->emp_name; ?></h4>

                        </div>
                        <div class="col-2"></div>
                        </div>
                   
                        <div class="row" style="margin-bottom:10px">
                             <div class="col-12">
                                <table  style="width:100%;">
                                    <tbody>
                                        <tr><?php //var_dump($payslip_dtls[0]); ?>
                                            <td style="width:15%;">Name</td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                            <td class="left_algn" style="width:33%;"><?php echo $emp_dtls->emp_name; ?></td>
                                            <td style="width:15%;"> Code </td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                            <td><?php if (strlen($emp_dtls->prefix_emp_cd) > 0) echo $emp_dtls->prefix_emp_cd; ?><?php echo $emp_dtls->emp_code; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%;">Date of Birth</td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                            <td class="left_algn" style="width:33%;"><?= (($emp_dtls->dob != "0000-00-00") && ($emp_dtls->dob != NULL)) ? date('d.m.Y', strtotime($emp_dtls->dob)) : ''; ?></td>
                                            <td style="width:15%;">Date of Joining</td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                            <td class="left_algn" style="width:33%;"><?= (($emp_dtls->join_dt != "0000-00-00") && ($emp_dtls->join_dt != NULL)) ? date('d.m.Y', strtotime($emp_dtls->join_dt)) : ''; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%;">Posting</td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                            <td class="left_algn" style="width:33%;"><?php echo sizeof($payslip_dtls) > 0 ? $payslip_dtls[0]->branch_name : ''; ?></td>
                                            <td style="width:15%;">Salary A/C No. </td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                        </tr>
                                        <tr>
                                            <td style="width:15%;">Designation</td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                            <td class="left_algn" style="width:33%;">
                                                <?php echo sizeof($payslip_dtls) > 0 ? $payslip_dtls[0]->designation : ''; ?><?php //echo $emp_dtls->designation; ?></td>
                                            <td style="width:15%;">Phone Number</td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                            <td class="left_algn" style="width:33%;"><?php echo $emp_dtls->phn_no; ?></td>                                            
                                        </tr>
                                        <tr>
                                            <td style="width:15%;">PAN</td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                            <td><?php echo $emp_dtls->pan_no; ?></td>
                                            <td style="width:15%;">UAN</td>
                                            <td class="left_algn" style="width:2%;">:</td>
                                            <td><?php echo $emp_dtls->UAN; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>   
                        </div>
                        <div class="row" style="margin-bottom:10px">
                             <div class="col-12">
                            <table  style="width:100%;">
                              <tbody>
                                <tr>
                                    <td style="width:50%;">
                                        <table  style="width:100%;">
                                            <tbody>
                                                <tr style="font-weight:bold">
                                                    <td>Earning</td>
                                                    <td align="right">Amount</td>
                                                </tr>
                                                </tbody>
                                        </table>
                                    </td>
                                    <td style="width:50%;">
                                        <table  style="width:100%;">
                                            <tbody>
                                                <tr style="font-weight:bold">
                                                    <td>Deduction</td>
                                                    <td align="right">Amount</td>
                                                </tr>
                                                </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:50%; vertical-align: top;">
                                        <table  style="width:100%;">                                       
                                        <tbody>
                                        <?php      
                                        $tot_earning = 0 ; $tot_deduction = 0;
                                         foreach($payslip_dtls as $ekey) {
                                           if($ekey->pay_head_type == 'E') {
                                             $tot_earning += $ekey->amount;
                                         ?>
                                          <tr>
                                            <td class="left_algn"><?= $ekey->pay_head; ?></td>
											  <td class="right_algn"><?= $ekey->amount; ?></td>
                                          </tr>
                                            <?php } 
                                            } ?>
                                        </tbody>
                                        </table>  
                                    </td>
                                    <td style="width:50%;">
                                        <table style="width:100%;">
                                        <tbody>
                                            <?php      
                                            foreach($payslip_dtls as $ekey) {
                                                if($ekey->pay_head_type == 'D') {
                                                $tot_deduction += $ekey->amount;
                                        ?>
                                          <tr>
                                                <td class="left_algn"><?= $ekey->pay_head; ?></td>
											  <td class="right_algn"><?= $ekey->amount; ?></td>
                                               
                                            </tr>
                                            <?php } 
                                            } ?>
                                        </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%;">
                                            <table  style="width:100%;">
                                                <tbody>
                                                    <tr style="font-weight:bold">
                                                        <td>Total</td>
                                                        <td align="right"><?= sprintf("%.2f", $tot_earning); ?></td>
                                                    </tr>
                                                    </tbody>
                                            </table>
                                        </td>
                                        <td style="width:50%;">
                                            <table  style="width:100%;">
                                                <tbody>
                                                    <tr style="font-weight:bold">
                                                        <td>Total</td>
                                                        <td align="right"><?= sprintf("%.2f", $tot_deduction); ?></td>
                                                    </tr>
                                                    </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>   
                        </div>
                        <div class="row" style="margin-bottom:20px">
                            <div class="col-12">
                                <br>
                                    <b><p style="display: inline;">Net Salary: <?php echo sprintf("%.2f", $tot_earning-$tot_deduction) . ' (<i>' . getIndianCurrency($tot_earning-$tot_deduction) . '</i>)'; ?></p></b>
                                    <p><b>Accumulated Income Tax: </b><?= $tds ?></p>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">
                            <div class="col-12" style="text-align: center;">
                            <br>
                            <p style="display: inline;text-transform: uppercase; font-size: 10px;"><b><?= PAYSLIP_FOOTER ?></b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <input type='button' id='btn' value='Print' onclick='printDiv();'>
            </div>

        </div>


    <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h3>Payslip Report</h3>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="form" action="<?php echo site_url("reports/payslipreport"); ?>">
                                            <div class="form-group">
                                                <div class="row">

                                                    <div class="col-4">
                                                        <label for="exampleInputName1">Month:</label>
                                                        <select class="form-control" name="sal_month" id="sal_month">
                                                            <option value="">Select Month</option>
                                                            <?php foreach ($month_list as $m_list) { ?>
                                                                <option value="<?php echo $m_list->id ?>"><?php echo $m_list->month_name; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleInputName1">Input Year:</label>
                                                        <input type="text" class="form-control" name="year" id="year" value="<?php echo date('Y'); ?>" />
                                                    </div>
                                                    <div class="col-4">
                                                        ` <label for="exampleInputName1">Emplyee Name:</label>
                                                        <select class="form-control required" name="emp_cd" id="emp_cd">
                                                            <option value="">Select Employee</option>
                                                            <?php

                                                            if ($emp_list) {
                                                                foreach ($emp_list as $e_list) {
                                                            ?>
                                                                    <option value='<?php echo $e_list->emp_code ?>'>
                                                                        <?php echo $e_list->emp_name; ?></option>
                                                            <?php
                                                                }
                                                            }    ?>
                                                        </select>
                                                    </div>`
                                                </div>
                                            </div>

                                            <input type="submit" class="btn btn-info" value="Proceed" />
                                            <button class="btn btn-light">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php

    } else {

        echo "<h1 style='text-align: center;'>No Data Found</h1>";
    }

        ?>