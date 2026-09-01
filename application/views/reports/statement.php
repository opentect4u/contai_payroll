<script>
    function printDiv() {

        var divToPrint = document.getElementById('divToPrint');
        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title><style type="text/css">');
        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
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
                        <div class="col-2 payslip_logo_Uts"><a href="javascript:void()"><img src="<?= base_url() ?>assets/images/<?php 
if (isset($this->session->userdata['loggedin']['logo_path'])) {
    echo $this->session->userdata['loggedin']['logo_path']; 
}
?>" alt="logo" height="100" width="100" /></a></div>
                        <div class="col-10">
                            <div style="text-align:center;">
                                 <?php include_once('common_report_header.php'); ?>
                                <h4>Salary summary report for the month of <?php echo MONTHS[$this->input->post('sal_month')] . ' ' . $this->input->post('year'); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                            <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Emp Code</th>
                                            <th>Emp Name</th>
                                            <th>Gross</th>
                                            <th>Deduction</th>
                                            <th>Net Sal</th>
                                            <th>AC/No.</th>
                                        </tr>
                                        </thead>
                                        <?php 
                                           $tot_dedu = 0; $tot_earning = 0; $net_sal = 0;
                                        foreach($sal_list as $elist) { ?>
                                        <tbody>
                                        <tr>
                                            <td><?=$elist->emp_code?></td>
                                            <td><?=$elist->emp_name?></td>
                                            <td><?php echo $elist->tot_earn; $tot_earning +=$elist->tot_earn; ?></td>
                                            <td><?php echo $elist->tot_dedu; $tot_dedu +=$elist->tot_dedu; ?></td>
                                            <td><?php echo $elist->tot_earn - $elist->tot_dedu; $net_sal +=$elist->tot_earn - $elist->tot_dedu;?></td>
                                            <td><?php echo $elist->bank_ac_no; ?></td>
                                        </tr>
                                        </tbody>
                                        <?php } ?>
                                        <tfoot>
                                                <tr style="font-weight:bold">
                                                    <td colspan="2">Total</td>
                                                    <td><?=$tot_earning?></td>
                                                    <td><?=$tot_dedu?></td>
                                                    <td><?=$tot_earning - $tot_dedu?></td>
                                                </tr>
                                        </tfoot>
                                    </table>
                                <br>
                                <div>
                                    <p>Amount: <?php echo @$tot_net . ' (' . getIndianCurrency(@$tot_net > 0 ? $tot_net : 0.00) . ').'; ?></p>
                                </div>

                                <div class="bottom">
                                    <p style="display: inline;">Prepared By</p>
                                    <p style="display: inline; margin-left: 8%;"></p>
                                    <p style="display: inline; margin-left: 8%;"></p>
                                    <p style="display: inline; margin-left: 8%;">Chief Executive officer</p>
                                </div>

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
                        <h3>Salary Statement Report</h3>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="form" action="<?php echo site_url("reports/paystatementreport"); ?>">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="exampleInputName1">From Date:</label>
                                                        <input type="date" name="from_date" class="form-control required" id="from_date" value="<?php echo $this->session->userdata('sys_date'); ?>" />
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="exampleInputName1">Select Month:</label>
                                                        <select class="form-control" name="sal_month" id="sal_month" require>
                                                            <option value="">Select Month</option>
                                                            <?php foreach ($month_list as $m_list) { ?>

                                                                <option value="<?php echo $m_list->id ?>"><?php echo $m_list->month_name; ?></option>

                                                            <?php
                                                            }
                                                            ?>

                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="exampleInputName1">Input Year:</label>
                                                        <input type="text" class="form-control" name="year" id="year" value="<?php echo date('Y'); ?>" require />
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="exampleInputName1">Category:</label>
                                                        <select class="form-control required" name="category" id="category" require>

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