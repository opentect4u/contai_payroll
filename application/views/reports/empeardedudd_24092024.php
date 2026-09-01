<script>
    function printDiv() {
        var divToPrint = document.getElementById('divToPrint');
        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title><style type="text/css">');
        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
            '                                         .row { display: flex;flex-wrap: wrap; }' +
            '                                         .btmborder { border-bottom: 2px solid black; }' +
            '                                         .inline { display: inline; }' +
            '                                         .underline { text-decoration: underline; }' +
            '                                         .left { margin-left: 315px;} ' +
            '                                         .right { margin-right: 375px; display: inline; }' +
            '                                          table { border-collapse: collapse; }' +
            '                                          th { text-align: center; vertical-align: middle; }' +
            '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 10px;}' +
            '                                           th, td { }' +
            '                                         .border { border: 1px solid black; } ' +
            '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
            '                                       ' +
            '                                   } } </style>');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function() {
            WindowObject.close();
        }, 10);
    }
</script>
<!-- <style>
@media print {
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    .col-3, .col-8 {
        flex: 1;
    }
    .col-3 {
        max-width: 25%; /* Since col-3 represents 25% width */
    }
    .col-8 {
        max-width: 75%; /* Since col-8 represents 75% width */
    }
    img {
        max-width: 100%; /* Ensure images fit within their columns */
        height: auto; /* Maintain aspect ratio */
    }
    /* Additional print styles */
    .no-print {
        display: none;
    }
}
</style> -->

<style>
    th {
        text-align: center;
        vertical-align: middle !important;
    }
</style>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body" id='divToPrint'>
                    <div class="row">
                        <div class="col-3"><a href="javascript:void()"><img src="<?= base_url() ?>assets/images/bm_ardb.jpg" alt="logo" height="100" width="100" /></a></div>
                        <div class="col-9" class="center">
                            <div class="center">
                                 <?php include_once('common_report_header.php'); ?>
                                <h4>Salary summary report for the month of <?php echo MONTHS[$this->input->post('sal_month')] . ' ' . $this->input->post('year'); ?></h4>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-3"><b>Branch Name:</b><?=$barnch_name?></div>
                       
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                            <table class="table" style="width:100%">
                                        <tr>
                                            <th>SL</td>
                                            <th>Emp Name</th>
                                            <th>Designation</th>
                                            <th>Basic</th>
                                            <th>D.A.</th>
                                            <th>HRA</th>
                                            <th>M.A.</th>
                                            <th>Spl.Pay</th>
                                            <th>S.A.</th>
                                            <th>GROSS</th>
                                            <th>P.F.</th>
                                            <th>LIC</th>
                                            <th>I.T.</th>
                                            <th>P.T.</th>
                                            <th>F.A.</th>
                                            <th>L.W.P.</th>
                                        </tr>
                                        <tbody>
                                        <?php 
                                           $tot_dedu = 0; $tot_earning = 0; $net_sal = 0;
                                       
                                           $i=0;
                                           $basic_tot = 0;$da_tot = 0; $hra_tot = 0; $ma_tot = 0;
                                           $sa_tot = 0; $pf_tot = 0; $lic_tot = 0;$it_tot = 0;$pt_tot = 0;
                                           $fa_tot = 0;$lwp_tot = 0;
                                      
                                        foreach($emp_list as $elist) {
                                             $emp_tot_er  = 0; 
                                             $emp_tot_ded = 0; 
                                            ?>
                                        
                                        <tr>
                                            <td><?=++$i?></td>
                                            <td><?=$elist->emp_name?></td>
                                            <td><?=$elist->designation?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                            $basic_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
                                            $da_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
                                            ?></td>
                                             <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
                                            $hra_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
                                            $ma_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
                                            ?></td>
                                           
                                            <td><?php //echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                           // $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
                                            $sa_tot  +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
                                            ?></td>
                                            <td><?php echo $emp_tot_er;  $tot_earning +=$emp_tot_er; ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
                                            $pf_tot += $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
                                            $lic_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
                                            $it_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
                                            $pt_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
                                            $fa_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
                                            $lwp_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
                                            ?></td>
                                        </tr>
                                       
                                        <?php 
                                    
                                         } ?>
                                        
                                       
                                         <tr>
                                            <th>Total</td>
                                            <th></th>
                                            <th></th>
                                            <th><?=$basic_tot?></th>
                                            <th><?=$da_tot?></th>
                                            <th><?=$hra_tot?></th>
                                            <th><?=$ma_tot?></th>
                                            <th></th>
                                            <th><?=$sa_tot?></th>
                                            <th><?=$tot_earning?></th>
                                            <th><?=$pf_tot?></th>
                                            <th><?=$lic_tot?></th>
                                            <th><?=$it_tot?></th>
                                            <th><?=$pt_tot?></th>
                                            <th><?=$fa_tot?></th>
                                            <th><?=$lwp_tot?></th>
                                        </tr>
                                        <tr>
                                            <th></td>
                                            <th></th>
                                            <th></th>
                                            <th>HBL <br> Loan</th>
                                            <th>Innt.On<br> HBL.Loan</th>
                                            <th>Emergency <br>Loan</th>
                                            <th>Innt.On<br> E.Loan</th>
                                            <th>P.loan</th>
                                            <th>Innt.On<br> P.Loan</th>
                                            <th>Net Salary</th>
                                            <th colspan="6">Signature of Payee</th>
                                        </tr>
                                        </tbody>
                                        <tbody>
                                        <?php 
                                           $tot_dedu = 0; $tot_earning = 0; $net_sal = 0;
                                       
                                           $i=0;
                                           $basic_tot = 0;$da_tot = 0; $hra_tot = 0; $ma_tot = 0;
                                           $sa_tot = 0;$lic_tot = 0;$it_tot = 0;$pt_tot = 0;
                                           $fa_tot = 0;$lwp_tot = 0;$hblp_tot =0;$hbli_tot=0;$el_tot=0;$eli_tot=0;$pl_tot=0;$pli_tot=0;
                                        foreach($emp_list as $elist) {
                                             $emp_tot_er  = 0; 
                                             $emp_tot_ded = 0; 
                                            ?>
                                         <tr style="display:none">
                                            <td></td>
                                            <td><?=$elist->emp_name?></td>
                                            <td><?=$elist->designation?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                            $basic_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
                                            $da_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
                                            ?></td>
                                             <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
                                            $hra_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
                                            $ma_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
                                            ?></td>
                                           
                                            <td><?php //echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                           // $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
                                            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
                                            $sa_tot  +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
                                            ?></td>
                                            <td><?php echo $emp_tot_er;  $tot_earning +=$emp_tot_er; ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
                                            $pt_tot += $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
                                            $lic_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
                                            $it_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
                                            $pt_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
                                            $fa_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
                                            $lwp_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
                                            ?></td>
                                        </tr>
                                        <tr style="" class="btmborder">
                                            <td><?=++$i?></td>
                                            <td><?=$elist->emp_name?></td>
                                            <td><?=$elist->designation?></td>
                                            <td style="">
                                            <?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,209);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,209);
                                            $hblp_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,209);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,210);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,210);
                                            $hbli_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,210);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,213);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,213);
                                            $el_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,213);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,214);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,214);
                                            $eli_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,214);
                                            ?></td>
                                            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,211);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,211);
                                            $pl_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,211);
                                            ?></td>
                                             <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,212);
                                            $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,212);
                                            $pli_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,212);
                                            ?></td>
                                            <td><?php echo $emp_tot_er-$emp_tot_ded; $net_sal += $emp_tot_er-$emp_tot_ded; ?></td>
                                            <td colspan="6"></td>
                                        </tr>
                                        <?php 
                                    
                                         } ?>
                                        
                                        <!-- <tr>
                                            <th>Total</td>
                                            <th></th>
                                            <th></th>
                                            <th>HBL <br> Loan</th>
                                            <th>Innt.On<br> HBL.Loan</th>
                                            <th>Emergency <br>Loan</th>
                                            <th>Innt.On<br> E.Loan</th>
                                            <th>P.loan</th>
                                            <th>Innt.On<br> P.Loan</th>
                                            <th>Net Salary</th>
                                            <th colspan="3"></th>
                                        </tr> -->
                                        <tr>
                                            <th>Total</td>
                                            <th></th>
                                            <th></th>
                                            <th><?=$hblp_tot?></th>
                                            <th><?=$hbli_tot?></th>
                                            <th><?=$el_tot?></th>
                                            <th><?=$eli_tot?></th>
                                            <th><?=$pl_tot?></th>
                                            <th><?=$pli_tot?></th>
                                            <th><?=$net_sal?></th>
                                            <th colspan="6"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                            <!-- <table class="table" style="width:100%">
                                        <tr>
                                            <th></td>
                                            <th></th>
                                            <th></th>
                                            <th>HBL <br> Loan</th>
                                            <th>Innt.On<br> HBL.Loan</th>
                                            <th>Emergency <br>Loan</th>
                                            <th>Innt.On<br> E.Loan</th>
                                            <th>P.loan</th>
                                            <th>Innt.On<br> P.Loan</th>
                                            <th>Net Salary</th>
                                            <th colspan="3">Signature of Payee</th>
                                        </tr>
                                    </table> -->
                                <div>
                                    <!-- <p>Amount: <?php //echo @$tot_net . ' (' . getIndianCurrency(@$tot_net > 0 ? $tot_net : 0.00) . ').'; ?></p> -->
                                </div>

                            </div>
                            <div class=""  style="margin-top:50px">
                                    <p style="display: inline;">Prepared By</p>
                                    <p style="display: inline; margin-left: 8%;"></p>
                                    <p style="display: inline; margin-left: 8%;"></p>
                                    <p style="display: inline; margin-left: 8%;">Chief Executive officer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-12">
                        <input type='button' id='btn' value='Print' onclick='printDiv();'>
                        </div>
                    </div>
                
            </div>
        </div>



    <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h3>Employee Salary Statement Report</h3>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="form" action="<?php echo site_url("reports/empeardedudd"); ?>">
                                            <div class="form-group">
                                                <div class="row">
                                                <div class="col-3">
                                                        <label for="exampleInputName1">Branch:</label>
                                                        <select class="form-control" name="branch_id" id="branch_id" required>
                                                            <option value="">Select Branch</option>
                                                            <option value="0">All Branch</option>
                                                            <?php foreach ($branchlist as $m_list) { ?>
                                                                <option value="<?php echo $m_list->id ?>"><?php echo $m_list->branch_name; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="exampleInputName1">Input Year:</label>
                                                        <input type="text" class="form-control" name="year" id="year" value="<?php echo date('Y'); ?>" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="exampleInputName1">Select Month:</label>
                                                        <select class="form-control" name="sal_month" id="sal_month" required>
                                                            <option value="">Select Month</option>
                                                            <?php foreach ($month_list as $m_list) { ?>

                                                                <option value="<?php echo $m_list->id ?>"><?php echo $m_list->month_name; ?></option>

                                                            <?php
                                                            }
                                                            ?>

                                                        </select>

                                                    </div>
                                                    <div class="col-3">
                                                        <label for="exampleInputName1">Category:</label>
                                                        <select class="form-control required" name="category" id="category" required>

                                                            <option value="">Select Category</option>

                                                            <?php foreach ($category as $c_list) { ?>

                                                                <option value="<?php echo $c_list->id; ?>"><?php echo $c_list->category; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <input type="submit" class="btn btn-info" value="Proceed" onclick="return checkVal();" />
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

        <script>
            function checkVal() {
                var month = $('#sal_month').val();
                var catg_id = $('#category').val();
                if (month > 0 && catg_id > 0) {
                    return true;
                } else {
                    alert('Please fill all fields')
                    return false;
                }
            }
        </script>